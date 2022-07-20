<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Extra\src\PelEntryAscii;
use App\Extra\src\PelEntryByte;
use App\Extra\src\PelEntryRational;
use App\Extra\src\PelEntryUserComment;
use App\Extra\src\PelExif;
use App\Extra\src\PelIfd;
use App\Extra\src\PelJpeg;
use App\Extra\src\PelTag;
use App\Extra\src\PelTiff;

use App\Claim;
use App\ClaimFile;
use App\Reservation;
use App\Image;

use _Image;

class ExifController extends Controller
{
    public function index($id)
    {
        $s = Claim::where('sin_number',$id)->first();
        if ($s) {
            if ($s->claim_id == -1) {
                $ids = [$s->sin_number];

                $claims = Claim::where('claim_id',$s->id)->get();

                foreach ($claims as $key => $claim) {
                    $ids[] = $claim->sin_number;
                }

                sort($ids);

                $i = ClaimFile::whereIn('sin_number',$ids)->where('type','image')->orderBy('id','asc')->orderBy('order','asc')->get();
            }else{
                $i = ClaimFile::where('sin_number',$s->sin_number)->where('type','image')->orderBy('id','asc')->orderBy('order','asc')->get();
            }
            $sin_number = $id;

            foreach ($i as $key => $_i) {

                $path = public_path().'/uploads/operator/'.$_i->user_id.'/'.$_i->sin_number.'/images/'.$_i->file;

                $img = _Image::make($path);
                $img->resize(1920,null,function($c){
                    $c->aspectRatio();
                });
                $img->save($path);

                $jpeg = exif_read_data($path);

                $input = $path;
                $output = $path;
                $description = $_i->address;
                $comment = "";
                $make = array_key_exists('Make', $jpeg) ? $jpeg['Make'] : 'Marca non Rilevabile';
                $model = array_key_exists('Model', $jpeg) ? $jpeg['Model'] : '';
                $longitude = $_i->lon;
                $latitude = $_i->lat;
                $altitude = "0";
                $date_time = $_i->created_at;

                $this->addGpsInfo($input, $output, $description, $comment, $make, $model, $longitude, $latitude, $altitude, $date_time);
            }
        }
    }

    // exto es de expressclaims
    public function indexClaims($id)
    {
        $res = Reservation::find($id);

        $i = Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])
        ->orderBy('order','asc')->get();
        $reservation_id = $id;

        foreach ($i as $key => $_i) {

            $res = Reservation::find($_i->reservation_id);
            $path = public_path().'/uploads/users/'.$_i->user_id.'/'.$res->sin_number.'/images/'.$_i->imagen;

            $jpeg = exif_read_data($path);

            $input = $path;
            $output = $path;
            $description = $_i->address;
            $comment = "";
            $make = array_key_exists('Make', $jpeg) ? $jpeg['Make'] : '';
            $model = array_key_exists('Model', $jpeg) ? $jpeg['Model'] : '';
            $longitude = $_i->lon;
            $latitude = $_i->lat;
            $altitude = "0";
            $date_time = $_i->created_at;

            $this->addGpsInfo($input, $output, $description, $comment, $make, $model, $longitude, $latitude, $altitude, $date_time);
        }
    }

    public function indexClaimsUser($id)
    {
        $res = Reservation::where('customer_id',$id)->where('status',0)->first();

        $_i = Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])
        ->orderBy('order','asc')->get()->last();
        // $reservation_id = $id;

        // foreach ($i as $key => $_i) {
            // $res = Reservation::find($_i->reservation_id);
            $path = public_path().'/uploads/users/'.$_i->user_id.'/'.$res->sin_number.'/images/'.$_i->imagen;

            $jpeg = exif_read_data($path);

            $input = $path;
            $output = $path;
            $description = $_i->address;
            $comment = "";
            $make = array_key_exists('Make', $jpeg) ? $jpeg['Make'] : '';
            $model = array_key_exists('Model', $jpeg) ? $jpeg['Model'] : '';
            $longitude = $_i->lon;
            $latitude = $_i->lat;
            $altitude = "0";
            $date_time = $_i->created_at;

            $this->addGpsInfo($input, $output, $description, $comment, $make, $model, $longitude, $latitude, $altitude, $date_time);
        // }
    }

    public function convertDecimalToDMS($degree)
    {
        if ($degree > 180 || $degree < - 180) {
            return null;
        }

        $degree = abs($degree); // make sure number is positive
                                // (no distinction here for N/S
                                // or W/E).

        $seconds = $degree * 3600; // Total number of seconds.

        $degrees = floor($degree); // Number of whole degrees.
        $seconds -= $degrees * 3600; // Subtract the number of seconds
                                     // taken by the degrees.

        $minutes = floor($seconds / 60); // Number of whole minutes.
        $seconds -= $minutes * 60; // Subtract the number of seconds
                                   // taken by the minutes.

        $seconds = round($seconds * 100, 0); // Round seconds with a 1/100th
                                             // second precision.

        return [
            [
                $degrees,
                1
            ],
            [
                $minutes,
                1
            ],
            [
                $seconds,
                100
            ]
        ];
    }

    public function addGpsInfo($input, $output, $description, $comment, $make, $model, $longitude, $latitude, $altitude, $date_time)
    {
        /* Load the given image into a PelJpeg object */
        $jpeg = new PelJpeg($input);

        /*
         * Create and add empty Exif data to the image (this throws away any
         * old Exif data in the image).
         */
        $exif = new PelExif();
        $jpeg->setExif($exif);

        /*
         * Create and add TIFF data to the Exif data (Exif data is actually
         * stored in a TIFF format).
         */
        $tiff = new PelTiff();
        $exif->setTiff($tiff);

        /*
         * Create first Image File Directory and associate it with the TIFF
         * data.
         */
        $ifd0 = new PelIfd(PelIfd::IFD0);
        $tiff->setIfd($ifd0);

        /*
         * Create a sub-IFD for holding GPS information. GPS data must be
         * below the first IFD.
         */
        $gps_ifd = new PelIfd(PelIfd::GPS);
        $ifd0->addSubIfd($gps_ifd);

        /*
         * The USER_COMMENT tag must be put in a Exif sub-IFD under the
         * first IFD.
         */
        $exif_ifd = new PelIfd(PelIfd::EXIF);
        $exif_ifd->addEntry(new PelEntryUserComment($comment));
        $ifd0->addSubIfd($exif_ifd);

        $inter_ifd = new PelIfd(PelIfd::INTEROPERABILITY);
        $ifd0->addSubIfd($inter_ifd);

        $ifd0->addEntry(new PelEntryAscii(PelTag::MAKE, $make));
        $ifd0->addEntry(new PelEntryAscii(PelTag::MODEL, $model));
        $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
        $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description));

        $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));

        /*
         * Use the convertDecimalToDMS function to convert the latitude from
         * something like 12.34� to 12� 20' 42"
         */
        list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($latitude);

        /* We interpret a negative latitude as being south. */
        $latitude_ref = ($latitude < 0) ? 'S' : 'N';

        $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
        $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));

        /* The longitude works like the latitude. */
        list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($longitude);
        $longitude_ref = ($longitude < 0) ? 'W' : 'E';

        $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
        $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));

        /*
         * Add the altitude. The absolute value is stored here, the sign is
         * stored in the GPS_ALTITUDE_REF tag below.
         */
        $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
            abs($altitude),
            1
        ]));
        /*
         * The reference is set to 1 (true) if the altitude is below sea
         * level, or 0 (false) otherwise.
         */
        $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));

        /* Finally we store the data in the output file. */
        file_put_contents($output, $jpeg->getBytes());
    }

    public function textExif()
    {
        $jpeg = exif_read_data(public_path().'/test_exif.jpg');
        return array_key_exists('Make', $jpeg) ? $jpeg['Make'] : '' ;
    }

}
