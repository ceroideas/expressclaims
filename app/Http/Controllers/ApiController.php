<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Response;
use Mail;
use App\User;
use App\Operator;
use App\Customer;
use App\Message;
use App\Image;
use App\Question;
use App\Video;
use App\File;
use App\Reservation;
use App\Test;
use App\Claim;
use App\Preassign;
use App\SMSPassword;
use App\PolicyModel;
use App\WebAppUser;

use App\ClaimFile;
use App\MailFile;

use App\MapInformation;

use App\ExcelFile;
use App\Record;
use App\Short;
use App\SelfManagement;
use App\Expert;
use App\State;

use App\Typology;
use App\TypologySection;

use Carbon\Carbon;

use Bitly;
use SimpleXMLElement;
use DB;

use Imagick;
use _Image;
// use CloudConvert;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Twilio\Rest\Client;

use \CloudConvert\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;

use Spatie\GoogleCalendar\Event;
// require_once('..\..\RSSDK\sendsms');

// use App\RSSDK\Sdk_SMS;

// use Midnite81\Plivo\Contracts\Services\Messaging;

class ApiController extends Controller
{
    public function __construct()
    {
        // Configuration of error messages
        $this->messages = [
            "email.required" => "Il campo email è obbligatorio",
            "email.email" => "Il campo email deve essere un indirizzo email valido",
            "email.unique" => "Quell'email è già in uso",
            "phone.required" => "Il campo telefonico è obbligatorio",
            "address.required" => "Il campo dell'indirizzo è obbligatorio",
            "password.required" => "Il campo della password è obbligatorio",
            "password.confirmed" => "Il campo della password deve corrispondere",
        ];
    }

    // function previously used for sending sms, deprecated
    public function array2xml($array, $xml = false){
        if($xml === false){
            $xml = new SimpleXMLElement('<result/>');
        }

        foreach($array as $key => $value){
            if(is_array($value)){
                $this->array2xml($value, $xml->addChild($key));
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }

    // function used to launch migrations without going through composer commands
    public function migrar(Request $r/*,Messaging $messaging*/)
    {
        /*return MapInformation::all();
        return MapInformation::where('Stato','000APERTA')->first();
        Mail::send('testImage', [], function ($message) {
            $message->to('jorgesolano92@gmail.com', 'John Doe');
            $message->subject('Subject');
        });*/
        // $mi = MapInformation::where('N_P',63097)->first();

        // $mi->DT_Incarico = "2022-01-29 00:00:00";
        // $mi->save();

        // return ClaimFile::where('sin_number','R123456-1')->get();
        
        /*Schema::table('map_informations', function(Blueprint $table) {
            //
            $table->integer('project')->nullable();
        });

        foreach (MapInformation::orderBy('updated_at','desc')->get() as $key => $value) {

            $repeat = MapInformation::where(['Danneggiato'=>$value['Danneggiato'], 'N_Sinistro'=>$value['N_Sinistro']])->where('id','!=',$value->id)->count();
            echo $value->id.'-'.$value->N_P.': '.$repeat;
            echo "<br>";

        }*/

        /*$code = rand(1000,9999);

        Mail::send('code', ['code'=>$code], function ($message) {
            $message->from('no_reply@expressclaims.it', 'Studio Zappa');
            $message->to('jorgesolano92@gmail.com', 'Jorge');
            $message->subject('Codice per ripristinare la password');
        });

        return "OK";

        return MapInformation::count();

        // return MapInformation::find(33176)->delete();
        return MapInformation::where('N_P','60919')->where('status',1)->get();
        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->string('latlng')->nullable();
        // });

        foreach (MapInformation::all() as $key => $value) {
            $value->latlng = $value->lat.','.$value->lng;
            $value->save();
        }*/
        /*return User::where('email','jorgesolano92@gmail.com')->get();
        
        $s = Short::all();
        $w = WebAppUser::all();

        foreach ($s as $key => $value) {
            $value->url = str_replace('webgest.gespea.it', 'app.expressclaims.it', $value->url);
            $value->save();
        }

        foreach ($w as $key => $value) {
            $value->url = str_replace('webgest.gespea.it', 'app.expressclaims.it', $value->url);
            $value->save();
        }*/

        // $event = new Event;

        // $event->name = 'UN NUEVO EVENTO - REUNION CON ILLYA';
        // $event->startDateTime = Carbon::now();
        // $event->endDateTime = Carbon::now()->addHour();

        // $event->save();
        
        // return Claim::find(18993);

        // return MapInformation::where('created_at','>',Carbon::today()->subDays(50))->get();
        // $c = Claim::where('updated_at','>',Carbon::today())->get();

        // return $c;

        // foreach ($c as $key => $value) {
        //     $value->json_information = null;
        //     $value->save();
        // }
        /*Schema::table('claims', function(Blueprint $table) {
            //
            $table->text('json_information')->nullable();
        });
        // Schema::table('typology_section_inputs', function(Blueprint $table) {
        //     //
        //     $table->string('key')->nullable();
        // });
        Schema::create('typologies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('long_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            //
        });

        Schema::create('typology_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('typology_id')->nullable();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            //
        });

        Schema::create('typology_section_inputs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('typology_section_id')->nullable();
            $table->string('question')->nullable();
            $table->string('type')->nullable(); // number, checkbox, radio, select;
            $table->string('key')->nullable();
            $table->integer('order')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
            //
        });
        
        Schema::create('typology_section_input_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('typology_section_input_id')->nullable();
            $table->string('option')->nullable();
            $table->timestamps();
            //
        });*/
        // Schema::table('users', function(Blueprint $table) {
        //     //
        //     $table->string('google_calendar_email')->nullable();
        // });
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://test3.wonduu.com/api/customers?schema=blank',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic V05CR1lBWEpWRExTQjVTS1dXNjhURkNRWEJEN0ZRWjE6'
          ),
        ));

        $response = simplexml_load_string(curl_exec($curl));

        curl_close($curl);

        $response->document[0]['firstname'] = 'Jorge';
        $response->document[0]['lastname'] = 'Solano';
        $response->document[0]['email'] = 'jorgesolano92@gmail.com';
        $response->document[0]['passwd'] = 'password1234';

        $output = new SimpleXMLElement($response,null,true);

        return $output;

        $curl2 = curl_init();

        curl_setopt_array($curl2, array(
          CURLOPT_URL => 'https://test3.wonduu.com/api/customers?output_format=JSON',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $output,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic V05CR1lBWEpWRExTQjVTS1dXNjhURkNRWEJEN0ZRWjE6',
            'Content-Type: application/xml',
          ),
        ));

        $response2 = curl_exec($curl2);

        curl_close($curl2);

        echo $response2;*/

        // $cf->sin_number = 'A111111';
        // $cf->file = 'A111111_12-01-2021 11_40_32.jpg';
        // $cf->save();

        // return $cf;
        
        // $c = Claim::find(20622);
        // $c->sin_number = 'A111111';
        // $c->save();

        // $c = Claim::find(20623);
        // $c->sin_number = 'A111111-1';
        // $c->society = '';
        // $c->save();

        // $c = $c->claims[0];

        // $c->sin_number = 'R12123-2';
        // $c->save();

        // Schema::table('claim_files', function(Blueprint $table) {
        //     //
        //     $table->string('web')->nullable();
        // });

        // Schema::table('claims', function(Blueprint $table) {
        //     //
        //     $table->integer('autoassign')->nullable();
        // });
        // $mi = MapInformation::orderBy('id','desc')->get();

        // return $mi;
        // return MapInformation::first();
        // $u = User::where('email','superadmin@mail.com')->first();
        // $u->password = bcrypt('R8cAzX#py7U&');
        // $u->save();

        // return $u;
        // $us = User::where('role_id',2)->whereNotExists(function($q) {
        //     $q->from('operators')
        //       ->whereRaw('operators.user_id = users.id');
        // })->get();

        // foreach ($us as $key => $u) {
        //     $o = new Operator;
        //     $o->user_id = $u->id;
        //     $o->et = 1;
        //     $o->save();
        // }
        // Schema::create('experts', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('idp')->nullable();
        //     $table->string('name')->nullable();
        //     $table->string('email')->nullable();
        //     $table->string('phone')->nullable();
        //     $table->string('society')->nullable();
        //     $table->timestamps();
        //     //
        // });

        // Schema::create('states', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('idav')->nullable();
        //     $table->string('description')->nullable();
        //     $table->string('order')->nullable();
        //     $table->timestamps();
        //     //
        // });
        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->text('note')->nullable();
        //     $table->integer('VDP')->default(0);
        //     $table->integer('AUT')->default(0);
        // });

        // Schema::table('map_informations', function(Blueprint $table) {
            //
            // $table->string('SOPRALLUOGO_2')->nullable();
            // $table->string('DATA_SOPRALLUOGO_2')->nullable();
            // $table->string('society')->nullable();
            // $table->string('ET')->nullable();
        // });

        // exec("curl 192.168.1.25:8080", $outcome, $status);
        // foreach ($outcome as $key => $value) {
        //     echo $value.'<br>';
        // }

        /*$c = Claim::find(21197);
        // $c->status = 2;
        // $c->save();
        // return $c;

        $curl = curl_init();

        $json = [
            "operation" => 'close',
            "idperizia" => 11378,
            "society" => 'R',
            "stato" => 30,
            "dtperizia" => Carbon::now()->format('Y-m-d H:i:s'),
            "dtperizia2" => null,
            "idsopralluogo1" => $c->user_id,
            "idsopralluogo2" => null,
            "idgestore" => $c->supervisor,
            "dtt1" => Carbon::now()->format('Y-m-d H:i:s'),
            "note" => null,
            "VDP" => null,
            "AUT" => null
        ];

        curl_setopt_array($curl, [
          CURLOPT_URL => "192.168.1.25:8080/perizia",
          CURLOPT_POSTFIELDS => json_encode($json),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;*/

        // $u = User::where('role_id',2)->get()->last();

        // $o = new Operator;
        // $o->user_id = $u->id;
        // $o->et = 1;
        // $o->save();
        // Schema::table('self_managements', function(Blueprint $table) {
        //     //
        //     $table->string('data_reminder')->nullable();
        // });
        // Mail::send('mail', ['msg'=>'hola'], function ($message) {
        //     $message->from('info@studiozappa.it', 'Studio Zappa');
        //     $message->sender('info@studiozappa.it', 'Studio Zappa');
        
        //     $message->to('jorgesolano92@gmail.com', 'John Doe');
        // });
        // return Record::where('user_id',1387)->get();

        /*$img = _Image::make(public_path().'/test.jpg');
        $img->resize(1280,null,function($c){
            $c->aspectRatio();
        });
        $img->save(public_path().'/test_1.jpg');*/

        return "Ok";

        // $im->readImage(public_path().'/uploads/autoperizia/5ec7cca63bbdb_1590152315218294909878.jpg');

        // $im->commentImage('8.1303768, -63.559923');

        // // print($im->getImageProperty('comment'));
        // file_put_contents (public_path().'/uploads/autoperizia/5ec7cca63bbdb_1590152315218294909878.jpg', $im);

        // $s = SelfManagement::find(1);
        // $s->status = 0;
        // $s->save();

        // $s = Short::get()->last();
        // $s->url = "https://webgest.gespea.it/autoperizia?token=b957056dd8ad16f1f46ca090727df5828d933758/1495/1";
        // $s->save();
        // Schema::create('self_managements', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id')->nullable();
        //     $table->string("society")->nullable();
        //     $table->string('company')->nullable();

        //     $table->string('call_id');

        //     $table->integer('status')->default(0);
        //     $table->string('url');
        //     $table->string('expiration')->nullable();
        //     $table->string('code')->nullable();
        //     $table->string('phone')->nullable();
        //     $table->string('fullphone')->nullable();

        //     $table->string('lat')->nullable();
        //     $table->string('lng')->nullable();
        //     $table->string('address')->nullable();
            
        //     $table->string('typology')->nullable();
        //     $table->string('date')->nullable();
        //     $table->string('ammount')->nullable();
        //     $table->integer('type_iban')->nullable();
        //     $table->string('iban')->nullable();

        //     $table->timestamps();
        //     //
        // });

        // Schema::create('self_management_images', function(Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('self_management_id');
        //     $table->string('image')->nullable();
            
        //     $table->string('lat')->nullable();
        //     $table->string('lng')->nullable();
        //     $table->string('address')->nullable();

        //     $table->timestamps();
        //     //
        // });

        // Schema::create('self_management_documents', function(Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('self_management_id');
        //     $table->string('document')->nullable();

        //     $table->string('lat')->nullable();
        //     $table->string('lng')->nullable();
        //     $table->string('address')->nullable();

        //     $table->timestamps();
        //     //
        // });
        // Schema::table('records', function(Blueprint $table) {
        //     //
        //     $table->string('remote_url')->nullable();
        // });

        // return Reservation::whereNotExists(function($q){
        //     $q->from('questions')
        //       ->whereRaw('questions.reservation_id = reservations.id');
        // })->whereExists(function($q){
        //     $q->from('users')
        //       ->whereRaw('users.id = reservations.customer_id')
        //       ->whereExists(function($q){
        //         $q->from('web_app_users')
        //             ->whereRaw('web_app_users.user_id = users.id');
        //       });
        // })->count();
        // Schema::table('operators', function(Blueprint $table) {
        //     //
        //     $table->integer('ec')->nullable();
        //     $table->integer('mp')->nullable();
        //     $table->integer('et')->nullable();
            // $table->integer('ap')->nullable();
        // });

        // return WebAppUser::all();
        // foreach (WebAppUser::all() as $key => $value) {
        //     $value->fullphone = $value->code.$value->phone;
        //     $value->save();
        // }
        // Schema::table('web_app_users', function($table) {
        //     //
        //     $table->string("fullphone")->nullable();
        // });
        // $c = Carbon::today()->subDays(3);
        // $res = Reservation::where('updated_at','>=',$c)->where('updated_at','<',$c->copy()->addDay())->get();

        // foreach ($res as $key => $value) {
        //     $value->status = 0;
        //     $value->save();
        // }
        // phpinfo();

        // $im = new Imagick;

        // $im->readImage(public_path().'/test.jpg');
        // $im->commentImage("12.3456789,-12.3456789");
        // echo $im->getImageProperty("comment");
        // $im->setImageProperty('lat', 'pruebalat');
        // $im->setImageProperty('lng', 'pruebalng');
        // print($im->getImageProperty('comment'));
        // file_put_contents (public_path().'/test.jpg', $im);
        // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));

        // Schema::table('reservations', function(Blueprint $table) {
        //     //
        //     // $table->string('made')->nullable();
        //     $table->integer('reopen')->nullable();
        // });

        // $res = Reservation::where('status',0)->with('user','user.webapp')->get();

        // foreach ($res as $key => $value) {
        //     $diff = Carbon::parse($value->made)->diffInDays(Carbon::today());
        //     // if ($diff > 7) {
        //         $value->reopen = 1;
        //         $value->save();
        //     // }
        // }

        // $msg = $messaging->msg('Hello World!')->to('+584143857947')->sendMessage();
        // return $msg;
        // $day7 = Carbon::today()->subDays(7);
        // while ($day7 <= Carbon::today()) {
        //     $ef = ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
        //     if ($ef) {
        //         echo $ef->created_at.' '.$ef->name.'<br>';
        //     }
        //     $day7->addDay();
        // }

        // return MapInformation::where('status',1)->where('type',2)->count();

        /*$account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);

        // // return $bundle = $client->numbers
        // //                         ->v2
        // //                         ->regulatoryCompliance
        // //                         ->bundles
        // //                         ->create("RENOVA SRL, Bundle", // friendlyName
        // //                                "giorgio.zappa@studiozappa.com", // email
        // //                                [
        // //                                    "endUserType" => "business",
        // //                                    "isoCountry" => "it",
        // //                                    "numberType" => "local",
        // //                                    "statusCallback" => "https://video.expressclaims.it/twillioCallback"
        // //                                ]
        // //                         );

        // // return ($bundle->sid);

        $twilio_number = "EXPclaims";
        // $twilio_number = getenv("TWILIO_NUMBER");
        $message = $client->messages->create("+".$r->phone, 
                ['from' => $twilio_number, 'body' => $r->message]);

        return $message->sid;*/

        /**/

        // $u = User::where('role_id',2)->get();

        // $p = [];

        // foreach ($u as $key => $value) {
        //     $temp['id'] = $value->id;
        //     $temp['name'] = $value->fullname();
        //     $temp['email'] = $value->email;
        //     $temp['device_id'] = $value->device_id;
        //     $temp['phone'] = $value->street_phone;

        //     $p[] = $temp;

        // }

        // return $p;

        // return MapInformation::select('DATA_SOPRALLUOGO','N_P')->get();
        // Schema::drop('file_excel');
        // Schema::create('excel_files', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('name')->nullable();
        //     $table->timestamps();
        //     //
        // });
        // Schema::table('excel_files', function(Blueprint $table) {
        //     //
        //     $table->string('all')->nullable();
        //     $table->string('l20')->nullable();
        //     $table->string('l40')->nullable();
        //     $table->string('l60')->nullable();
        //     $table->string('p60')->nullable();

        //     $table->string('mall')->nullable();
        //     $table->string('ml20')->nullable();
        //     $table->string('ml40')->nullable();
        //     $table->string('ml60')->nullable();
        //     $table->string('mp60')->nullable();
        // });

        // Schema::table('excel_files', function(Blueprint $table) {
        //     //
        //     $table->string('fiss')->nullable();
        //     $table->string('nonf')->nullable();
        //     $table->string('gmfs')->nullable();
        //     $table->string('gmnf')->nullable();

        // });

        // Schema::table('map_informations', function(Blueprint $table) {
            
        //     // $table->dropColumn('type');
        //     $table->integer('type')->default(1);
        //     // $table->string('PERITO_GESTORE')->nullable();
        // });
        // $sms = new Sdk_SMS;
        // $sms->Sdk_SMS();
        // // $sms->sms_type = SMSTYPE_ALTA;
        // $sms->message = 'prueba de envio de mensaje con api nueva';
        // $sms->sender = 'StudioZappa';
        // $sms->add_recipient('+34633808197');
        // // $sms->add_recipient('+584143857947');
        // $sms->set_immediate();
        // if ($sms->validate()) {
        //   $res = $sms->send();
        //   if ($res['ok']) {
        //     echo $res['sentsmss'].' | '.$res['order_id'];
        //   } else {
        //     echo ' E: '.$sms->problem();
        //   }
        // } else {
        //     echo ' I: '.$sms->problem();
        // }

        // return [$sms];
        // // return MapInformation::where('status',1)->orderBy('DATA_SOPRALLUOGO','desc')->where(["lat"=> "45.4378386","lng"=> "9.1466082"])->get();
        // $mi = MapInformation::orderBy('DATA_SOPRALLUOGO','desc');

        // // return $mi->toSql();

        // // $mi = MapInformation::where('status',1)->groupBy('lat','lng')->get();
        // // return $mi;
        // return DB::table(DB::raw("({$mi->toSql()}) as mi"))

        //     ->where('status',1)

        //     // 

        //     ->groupBy('lat','lng')

        //     ->get();
        // // return $mi->count();
        // $total = 0;
        // foreach ($mi as $key => $value) {

        //     $_mi = MapInformation::where('status',1)->where(['lat'=>$value->lat,'lng'=>$value->lng])->groupBy('N_Sinistro')->get();

        //     // $total += $_mi->count();

        //     foreach ($_mi as $key => $val) {
        //         if ($val->DATA_SOPRALLUOGO != "") {
        //             if (Carbon::parse($val->DATA_SOPRALLUOGO) >= Carbon::today() && ($val->lat && $val->lng)) {
        //                 $total++;
        //             }
        //         }
        //     }
        // }
        // return $total;
        // return MapInformation::select('*', DB::raw("CONCAT(map_informations.lat,' ',map_informations.lng) as lat_lng"))->groupBy('lat_lng')->get();
        // $all = MapInformation::all();
        // $a = 0;

        // foreach ($all as $key => $value) {
        //     if ($value->Danneggiato == "CONDOMINIO CRIVELLINO 35" && $value->N_P == "4414") {
        //        $a++; 
        //     }
        // }

        // return $a;

        // return MapInformation::where(["lat"=>"45.4755034","lng"=>"9.1322041"])->get();

        // Schema::dropIfExists('shorts');
        // Schema::create('shorts', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('url');
        //     $table->timestamps();
        //     //
        // });
        /*$op = User::
        // where('role_id',1)
        where('email','expresstech@studiozappa.com')
        ->first();

        // return $op;

        $op->role_id = 1;
        $op->supervisor = NULL;
        $op->save();*/

        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->string('DATA_SOPRALLUOGO')->nullable();
        // });

        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->string('status')->default(1);
        // });

        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->string('file_name')->nullable();
        // });
        // Schema::table('map_informations', function(Blueprint $table) {
        //     //
        //     $table->string("lat")->nullable();
        //     $table->string("lng")->nullable();
        // });

        // Schema::create('map_informations', function (Blueprint $table) {
            
        //     $table->increments('id');
        //     $table->string("N_P")->nullable();
        //     $table->string("TP")->nullable();
        //     $table->string("Assicurato")->nullable();
        //     $table->string("Danneggiato")->nullable();
        //     $table->string("COMUNE")->nullable();
        //     $table->string("CAP")->nullable();
        //     $table->string("PROVINCIA")->nullable();
        //     $table->string("INDIRIZZO")->nullable();
        //     $table->string("TELEFONO")->nullable();
        //     $table->string("CELLULARE")->nullable();
        //     $table->string("EMAIL")->nullable();
        //     $table->string("Stato")->nullable();
        //     $table->string("SOPRALLUOGO")->nullable();
        //     $table->string("RISERVA")->nullable();
        //     $table->string("N_Sinistro")->nullable();
        //     $table->string("DT_Sinistro")->nullable();
        //     $table->string("DT_Incarico")->nullable();
        //     $table->string("DT_ASSEGNATA")->nullable();
        //     $table->string("DT_CONSEGNA")->nullable();
        //     $table->string("COMPAGNIA")->nullable();
        //     $table->string("AGENZIA")->nullable();
        //     $table->string("NP")->nullable();
        //     $table->timestamps();
        //     //
        // });

        // return [Claim::where('sin_number','mmmm')->first()->user->fullname(), Claim::where('sin_number','mmmm')->first()->name];
        // Schema::create('predefined_mails', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->text('predefined');
        //     $table->integer('status')->default(1);
        //     $table->timestamps();
        //     //
        // });

        // Schema::table('predefined_mails', function($table) {
        //     //
        //     $table->string('title');
        // });

        // Schema::create('mail_files', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('claim_id');
        //     $table->string('file');
        //     $table->timestamps();
        //     //
        // });
        // Schema::table('claims', function($table) {
        //     //
        //     $table->integer('supervisor')->nullable();
        // });
        // Schema::table('claims', function($table) {
        //     //
        //     $table->text('mail_text')->nullable();
        // });
        // return "";
        // Schema::table('users', function($table) {
        //     //
        //     $table->integer('supervisor')->nullable();
        // });
        // $p = [
        //     "Google Pixel 3",
        //     "Honor View 20",
        //     "OnePlus 6T",
        //     "iPhone XR",
        //     "Huawei Mate 20 Pro",
        //     "LG V40 ThinQ",
        //     "Samsung Galaxy S10 Plus",
        //     "Xiaomi Mi 8 Pro",
        //     "Samsung Galaxy Note 9",
        // ];

        // foreach ($p as $key => $value) {
        //     $pm = new \App\PhoneModel;
        //     $pm->name = $value;
        //     $pm->save();
        // }
        // Schema::create('phone_models', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('name');
        //     $table->timestamps();
        // });

        // Schema::table('details', function($table) {
        //     //
        //     $table->string('phone_model');
        //     $table->string('phone_works');
        // });
        // $users = User::where('role_id',0)->where(function($q){
        //     $q->where('operator_call_id',Auth::user()->id)->orWhereExists(function($q){
        //         $q->from('customers')
        //           ->whereRaw('customers.user_id = users.id')
        //           ->whereRaw('operator_id = '.Auth::user()->id);
        //     });
        // })->whereExists(function($q){
        //     $q->from('reservations')
        //       ->whereRaw('reservations.customer_id = users.id')
        //       ->whereRaw('reservations.status = 0')
        //       ->whereRaw('reservations.sin_number != ""');
        // })->get();

        // foreach ($users as $key => $value) {
        //     if ($value->customer) {
        //         echo "CUSTOMER ";
        //     }else if($value->webapp){
        //         echo "WEBAPP ";
        //     }
        // }
        // $u = User::where('name','like','%/%')->get();

        // foreach ($u as $key => $value) {
        //     foreach (Image::where('user_id',$value->id)->get() as $key => $value1) {
        //         echo public_path().'/uploads/images/'.$value1->imagen.'<br>';
        //         // echo file_exists(public_path().'/uploads/videos/'.$value1->name) ? 'yes' : 'no'.'<br>';
        //     }
        // }

        // foreach ($u as $key => $value) {
        //     foreach (\App\Record::where('user_id',$value->id)->get() as $key => $value1) {
        //         $value1->delete();
        //     }
        // }
        // foreach (WebAppUser::all() as $key => $value) {
        //     $i = Image::where('user_id',$value->id)->get();

        //     foreach ($i as $key => $value1) {
        //         echo $value1->type;
        //     }

        // Schema::table('images', function($table) {
        //     $table->integer('order')->default(9999);
        // });

        // Schema::table('images', function($table) {
        //     $table->integer('web')->nullable();
        // });

        // }
        // return Reservation::all();
        // return Image::all();
        // return User::all();
        // return User::where('operator_call_id','!=','')->get();
        // Auth::loginUsingId(User::where('email','expresstech@renova.srl')->first()->id);


        // Auth::loginUsingId(User::where('email','expresstech@studiozappa.com')->first()->id,true);


        // return redirect('admin/videocalls');
        // Schema::table('preassigns', function($table) {
        //     $table->string('fullphone')->after('phone')->nullable();
        // });

        // Schema::table('users', function($table) {
            // $table->string('street_phone')->nullable();
            // $table->string('street_code')->nullable();
        // });

        // Schema::table('claim_files', function($table) {
        //     // $table->integer('order')->default(9999);
        //     $table->integer('offline')->default(0);
        // });

        // User::get()->last()->delete();

        // Schema::dropIfExists('web_app_users');

        // Schema::create('web_app_users', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->string('call_id');
        //     $table->integer('status');
        //     $table->string("company");
        //     $table->string("society");
            // $table->string("url");
        // $table->string("lat")->nullable();
        // $table->string("lng")->nullable();
            // $table->string("expiration")->nullable();
            // $table->string("code")->nullable();
            // $table->string("phone")->nullable();
        //     $table->timestamps();
        //     //
        // });

        // Schema::table('web_app_users', function($table) {
        //     //
        //     $table->string("code")->nullable();
        // });

        // return User::get()->last();

        // Schema::create('questions', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('reservation_id');
        //     $table->integer('rate');
        //     $table->string('email')->nullable();
        //     $table->text('comment')->nullable();
        //     $table->timestamps();
        //     //
        // });
    }

    public function check(Request $r)
    {
        // post data validation
        $this->validate($r,[
            'sin_number'=>'required'
        ],[
            'sin_number.required' => 'Occorre indicare un numero di sinistro'
        ]);

        // request claim with parameters
        $c = Claim::where(['sin_number'=>$r->sin_number,'user_id'=>$r->id])->where('status','<',1)->with('claims')->first();

        // if not results throws a 422 response
        if (!$c) {
            return response()->json([['Riferimento interno non registrato']],422);
        }
        return $c;
    }

    public function getOperator($id)
    {
        // just fin user by id
        return User::find($id);
    }

    // function to send push to multiple users via onesignal api
    public function send_msg_notification($device_id,$sin_number,$u,$claim, $mail = true)
    {
        // body of message
        $content = [
            "en" => 'Ti è stato assegnato il nuovo incarico n.: '.$sin_number
        ];
        // title of message
        $heading = array(
            "en" => 'Express Tech'
        );

        // organizing the elements
        $fields = [
            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111", // onesignal app_id, from onesignal.com
            'include_player_ids' => [$device_id], // all devices where the notification will be sent
            'contents' => $content,
            'headings' => $heading
        ];

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
        // the curl function
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8', 'Authorization: Basic YTQwMjg1N2ItZmYyOC00NDEzLTliOGUtYmI0NGE2MTM4MGJi']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);

        // check if we have to sent email
        if ($mail) {
            $mess = $claim->mail_text;

            $files = MailFile::where('claim_id',$claim->id)->get();

            Mail::send('admin.new-assign', ["msg" => $mess], function ($message) use($u,$claim,$files,$sin_number) {
                $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                // $message->sender('john@johndoe.com', 'John Doe');
            
                $message->to($u->email, $u->fullname());
                if ($claim->_supervisor) {
                    $message->cc($claim->_supervisor->email, $claim->_supervisor->fullname());
                }
                // $message->bcc("jorgesolano92@gmail.com", "Jorge Solano");
            
                $message->subject('Express Tech - '.$sin_number);

                if ($files) {
                    foreach ($files as $key => $filePath) {
                        $message->attach($filePath->file);
                    }
                }
            });
        }
    }

    public function checkBack(Request $r)
    {
        // post data validation
        $this->validate($r,[
            'sin_number' => 'confirmed'
        ]);

        // check the society to prepend a vocal before the sin_number
        if ($r->society == 'Renova') {
            $r->sin_number = 'R'.$r->sin_number;
        }
        if ($r->society == 'Studio Zappa') {
            $r->sin_number = 'Z'.$r->sin_number;
        }
        if ($r->society == 'Gespea') {
            $r->sin_number = 'G'.$r->sin_number;
        }

        // find reservation and claim by sin_number
        $res = Reservation::where('sin_number',$r->sin_number)->first();

        $c = Claim::where(['sin_number'=>$r->sin_number])->first();

        // if any of avobe exists, throws a 422 response
        // if ($c) {
        if ($res || $c) {
            return response()->json([['Riferimento interno già registrato']],422);
            // $c->delete();
        }

        // code to create a new claim
        $c = new Claim;
        $c->sin_number = $r->sin_number;
        $c->user_id = $r->id;
        $c->name = $r->name ? $r->name : "";
        $c->society = $r->society;
        $c->status = 0;
        $c->email1 = $r->email1 ? $r->email1 : "";
        $c->email2 = $r->email2 ? $r->email2 : "";
        $c->supervisor = $r->supervisor;
        $c->mail_text = $r->mail_text;

        $c->json_information = $r->typology;

        $c->save();

        $files = [];

        // if any file is present, create attatchmente to mail

        if ($r->attachments) {
            foreach ($r->attachments as $key => $value) {
                $file = $value;
                $path = public_path().'/uploads/attachments';
                $name = Carbon::now()->format('d_m_Y-h_i_s').'-'.$file->getClientOriginalName();
                $file->move($path,$name);
                $files[] = public_path().'/uploads/attachments/'.$name;
            }
        }

        foreach ($files as $key => $value) {
            $i = new MailFile;
            $i->claim_id = $c->id;
            $i->file = $value;
            $i->save();
        }

        $u = User::find($c->user_id);

        // send notification

        $this->send_msg_notification($u->device_id,$c->sin_number,$u,$c);

        return $c;
    }
    // function to create a sub claim in the express tech app
    public function createSubproduct(Request $r)
    {
        $sin_number = $r->sin_number;
        $name = $r->name;

        // checking the main claim (parent)
        function check($sin_number,$count) {
            $check = Claim::where('sin_number',$sin_number.'-'.$count)->first();

            if ($check) {
                return check($sin_number,$count+1);
            }

            return $sin_number.'-'.$count;
        }
        // if (!$res) {
        //     return response()->json([['Riferimento interno non trovato']],422);
        // }

        $claim = Claim::where(['sin_number'=>$sin_number])->first();

        if ($claim->claim_id != -1) {
            $claim = Claim::find($claim->claim_id);
        }

        $count = Claim::where(['claim_id'=>$claim->id])->count()+1;

        $sin_number = check($claim->sin_number,$count);

        // if ($c) {
        $c = new Claim;
        $c->sin_number = $sin_number;
        // $c->sin_number = $claim->sin_number.'-'.$count;
        // $c->damage = $name;
        $c->user_id = $claim->user_id;
        $c->claim_id = $claim->id;
        $c->name = $claim->name;
        $c->society = $claim->society;
        $c->status = 0;
        $c->email1 = "";
        $c->email2 = "";
        $c->information = json_encode(['typology'=>$name]);

        // main information 
        $c->json_information = 
            ["main_information"=>[
                    ["key"=>"typology","question"=>"Partita di danno","value"=>$name],
                    ["key"=>"sin_number","question"=>"Riferimento Interno","value"=>$sin_number]
                ],"questions"=>[], "typology" => $claim->json_information
            ];

        $c->save();

        // $u = User::find($c->user_id);

        // $this->send_msg_notification($u->device_id,$c->sin_number);

        return [$c,Claim::where('id',$c->claim_id)->with('claims')->first()];
    }

    // save the claim when offline mode is enable un express tech app

    public function saveOfflineClaims(Request $r)
    {
        foreach ($r->all() as $key => $value) {
            $claim = Claim::find($value['claim_id']);

            $c = new Claim;
            $c->sin_number = $value['sin_number'];
            $c->information = json_encode(['typology'=>$value['name']]);
            $c->user_id = $claim->user_id;
            $c->claim_id = $claim->id;
            $c->name = $value['name'];
            $c->society = $claim->society;
            $c->status = 0;
            $c->email1 = "";
            $c->email2 = "";
            $c->save();
        }
    }

    // function to reasign the claim to another technician
    public function checkBackReasign(Request $r)
    {
        $old_id = NULL;

        $c = Claim::where('sin_number',$r->sin_number)->first();

        $old_riferimento = $c->sin_number;
        $old_user_id = $c->user_id;

        if ($c->status == 0) {
            $old_id = $c->user_id;

            $us = User::find($c->user_id);

            Mail::send('admin.new-assign', ["msg" => 'È stato annullato il incarico n: '.$c->sin_number], function ($message) use($us,$c) {
                $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                // $message->sender('john@johndoe.com', 'John Doe');
            
                $message->to($us->email, $us->fullname());
            
                $message->subject('Express Tech - '.$c->sin_number);
            });
        }

        if ($c->society == 'Renova') {
            $idp = ltrim($c->sin_number,'R');
        }
        if ($c->society == 'Studio Zappa') {
            $idp = ltrim($c->sin_number,'Z');
        }
        if ($c->society == 'Gespea') {
            $idp = ltrim($c->sin_number,'G');
        }

        if ($r->society == 'Renova') {
            $idp = 'R'.$idp;
        }
        if ($r->society == 'Studio Zappa') {
            $idp = 'Z'.$idp;
        }
        if ($r->society == 'Gespea') {
            $idp = 'G'.$idp;
        }


        $res = Reservation::where('sin_number',$idp)->first();

        $c2 = Claim::where(['sin_number'=>$idp])->where('id','!=',$c->id)->first();

        if ($res || $c2) {
            return response()->json([['Riferimento interno già registrato']],422);
        }

        $c->sin_number = $idp;

        $c->user_id = $r->id;
        $c->name = $r->name ? $r->name : "";
        $c->society = $r->society;
        $c->status = 0;
        $c->email1 = $r->email1 ? $r->email1 : "";
        $c->email2 = $r->email2 ? $r->email2 : "";
        $c->supervisor = $r->supervisor;
        $c->mail_text = $r->mail_text;
        $c->reassingned = Carbon::now();

        $c->json_information = $r->typology;

        $c->save();

        @rename(public_path().'/uploads/operator/'.$old_user_id.'/'.$old_riferimento, public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number);

        foreach (ClaimFile::where('sin_number',$old_riferimento)->get() as $key => $value) {
            $old_file = $value->file;
            $value->file = str_replace($value->sin_number, $c->sin_number, $value->file);
            $value->sin_number = $c->sin_number;
            $value->user_id = $r->id;
            $value->save();

            rename(
                public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images/'.$old_file,
                public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images/'.$value->file
            );
        }

        foreach ($c->claims as $key => $claim) {

            $_old_rif = $value->sin_number;

            $idp2 = "";

            if ($claim->society == 'Renova') {
                $idp2 = ltrim($claim->sin_number,'R');
            }
            if ($claim->society == 'Studio Zappa') {
                $idp2 = ltrim($claim->sin_number,'Z');
            }
            if ($claim->society == 'Gespea') {
                $idp2 = ltrim($claim->sin_number,'G');
            }

            if ($r->society == 'Renova') {
                $idp2 = 'R'.$idp2;
            }
            if ($r->society == 'Studio Zappa') {
                $idp2 = 'Z'.$idp2;
            }
            if ($r->society == 'Gespea') {
                $idp2 = 'G'.$idp2;
            }

            $claim->society = $c->society;
            $claim->sin_number = $idp2;
            $claim->save();

            @rename(public_path().'/uploads/operator/'.$c->user_id.'/'.$_old_rif, public_path().'/uploads/operator/'.$c->user_id.'/'.$value->sin_number);

            foreach (ClaimFile::where('sin_number',$_old_rif)->get() as $key => $_value) {

                $old_file = $_value->file;
                $_value->file = str_replace($_value->sin_number, $c->sin_number, $_value->file);
                
                $_value->sin_number = $value->sin_number;
                $_value->user_id = $r->id;
                $_value->save();

                rename(
                    public_path().'/uploads/operator/'.$c->user_id.'/'.$_value->sin_number.'/images/'.$old_file,
                    public_path().'/uploads/operator/'.$c->user_id.'/'.$_value->sin_number.'/images/'.$_value->file
                );
            }
        }

        MailFile::where('claim_id',$c->id)->delete();

        $files = [];

        if ($r->attachments) {
            foreach ($r->attachments as $key => $value) {
                $file = $value;
                $path = public_path().'/uploads/attachments';
                $name = Carbon::now()->format('d_m_Y-h_i_s').'-'.$file->getClientOriginalName();
                $file->move($path,$name);
                $files[] = url('uploads/attachments').'/'.$name;
            }
        }

        foreach ($files as $key => $value) {
            $i = new MailFile;
            $i->claim_id = $c->id;
            $i->file = $value;
            $i->save();
        }

        $u = User::find($c->user_id);

        $this->send_msg_notification($u->device_id,$c->sin_number,$u,$c);

        return [$c,$old_id];
    }

    // function to find the street operator
    public function searchStrertOperator(Request $r)
    {
        $users = User::where('role_id',2)->where(function($q) use($r){
            $q->where('name','like','%'.$r->search.'%')->orWhere('email','like','%'.$r->search.'%');
        })->get();

        foreach ($users as $key => $value) {
            $value->_name = $value->fullname();
        }

        return $users;
    }

    // to delete a claim from the app
    public function deleteBack($id)
    {
        $c = Claim::find($id);

        $files = [];

        foreach ($c->claims as $value) {
            $cf = ClaimFile::where('sin_number',$value->sin_number)->get();

            foreach ($cf as $value1) {
                $files[] = $value1;

                $value1->delete();
            }

        }

        foreach ($files as $f) {
            if ($f->type == "image") {
                $path = public_path().'/uploads/operator/'.$c->user_id.'/'.$f->sin_number.'/images/'.$f->file;
                @unlink(public_path().'/uploads/operator/'.$c->user_id.'/'.$f->sin_number.'/images/t_'.$f->file);
            }else if($f->type == "video") {
                $path = public_path().'/uploads/operator/'.$c->user_id.'/'.$f->sin_number.'/videos/'.$f->file;
            }else {
                $path = public_path().'/uploads/operator/'.$c->user_id.'/'.$f->sin_number.'/audios/'.$f->file;
            }
            @unlink($path);
            // echo url('/uploads/operator/'.$c->user_id.'/'.$f->sin_number.'/images',$f->file).'<br>';
        }

        $c->delete();

        return back();
    }

    // saving the device id

    public function techDeviceId($device_id,$user_id)
    {
        $u = User::find($user_id);
        $u->device_id = $device_id;
        $u->save();
    }

    // get all claims
    public function getClaims(Request $r)
    {
        return Claim::where(['user_id'=>$r->id,'status'=>0,'claim_id'=>-1])->with('claims')->orderBy('sin_number','asc')->get();
    }

    // get specific claim by id
    public function getClaim($claim_id)
    {
        return Claim::where('id',$claim_id)->with('claims')->first();
    }

    // delete specific claim
    public function deleteSub($claim_id)
    {
        $to_delete = Claim::find($claim_id);
        $claim_id = $to_delete->claim_id;
        $to_delete->delete();
        return Claim::where('id',$claim_id)->with('claims')->first();
    }

    // function where is located the logic to send data to "progetto" 
    public function sendCurl($json)
    {
        // stop for 2 seconds
        sleep ( 2 );
        
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "93.45.47.193:50801/perizia",
          // CURLOPT_URL => "192.168.1.25:8080/perizia",
          CURLOPT_POSTFIELDS => json_encode($json),
          // CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        // print_r($json);

        echo $response;

        $res = json_decode($response,true);
    }

    public function notFinished(Request $r)
    {
        $c = Claim::where(['sin_number'=>$r->sin_number])->first();

        if ($c->claim_id != -1) {
            $c = Claim::find($c->claim_id);
        }


        // $c = Claim::where(['sin_number'=>$r->sin_number])->first();
        if ($c->society == "") {
            $c->status = 1;
        }else{
            $c->status = 2; // antes 1
        }
        $c->save();
        $soc = "";

        if ($c->society == 'Renova') {
            $idp = ltrim($c->sin_number,'R');
            $soc = 'R';
        }
        if ($c->society == 'Studio Zappa') {
            $idp = ltrim($c->sin_number,'Z');
            $soc = 'Z';
        }
        if ($c->society == 'Gespea') {
            $idp = ltrim($c->sin_number,'G');
            $soc = 'G';
        }

        $json = [
            "operation" => 'fail',
            "idperizia" => (int)$idp,
            "society" => $soc,
            "viaggio" => $r->viaggio
        ];

        // $claims = Claim::where('claim_id',$c->id)->get();

        // if ($claims) {
        //     foreach ($claims as $key => $value) {
        //         $value->status = 1;
        //         $value->save();
        //     }
        // }

        // function sendMail($email,$claim,$id)
        // {
            $o = User::find($c->user_id);
            $mess = "Il Perito ".$o->fullname()." non ha effettuato il sopralluogo ".$c->sin_number.".";

            Mail::send('conclusion', ['mess' => $mess], function ($message) {
                 $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                 $message->sender('no_reply@expressclaims.it', 'Studio Zappa');
             
                 $message->to('re@studiozappa.com', 'Studio Zappa');
             
                 $message->subject('Sopralluogo non fatto');
            });
        // }

        // if ($c->email1 != "") {
        //     sendMail($c->email1,$c,$c->user_id);
        // }

        // if ($c->email2 != "") {
        //     sendMail($c->email2,$c,$c->user_id);
        // }

        // if ($c->supervisor) {
        //     sendMail($c->_supervisor->email,$c,$c->user_id);
        // }

        if ($c->society != "") {
            $this->sendCurl($json);
        }

        // return $c;
    }
    public function closeSin(Request $r)
    {
        $c = Claim::where(['sin_number'=>$r->sin_number])->first();

        if ($c->claim_id != -1) {
            $c = Claim::find($c->claim_id);
        }


        // $c = Claim::where(['sin_number'=>$r->sin_number])->first();
        if ($c->society == "") {
            $c->status = 1;
        }else{
            $c->status = 2; // antes 1
        }
        $c->save();
        $soc = "";

        if ($c->society == 'Renova') {
            $idp = ltrim($c->sin_number,'R');
            $soc = 'R';
        }
        if ($c->society == 'Studio Zappa') {
            $idp = ltrim($c->sin_number,'Z');
            $soc = 'Z';
        }
        if ($c->society == 'Gespea') {
            $idp = ltrim($c->sin_number,'G');
            $soc = 'G';
        }

        $json = [
            "operation" => 'close',
            "idperizia" => (int)$idp,
            "society" => $soc,
            "stato" => 30,
            "dtperizia" => Carbon::now()->format('Y-m-d H:i:s'),
            "dtperizia2" => null,
            "idsopralluogo1" => $c->user_id,
            "idsopralluogo2" => null,
            "idgestore" => $c->supervisor,
            "dtt1" => Carbon::now()->format('Y-m-d H:i:s'),
            "note" => null,
            "VDP" => null,
            "AUT" => null
        ];

        // $claims = Claim::where('claim_id',$c->id)->get();

        // if ($claims) {
        //     foreach ($claims as $key => $value) {
        //         $value->status = 1;
        //         $value->save();
        //     }
        // }

        function sendMail($email,$claim,$id)
        {
            $o = User::find($id);
            // if ($claim->mail_text) {
            //     $mess = $claim->mail_text;
            // }else{
                $mess = "Il Perito ".$o->fullname()." ha concluso gli accertamenti relativi alla perizia ".$claim->sin_number.", pregasi completare la perizia";
            // }

            // $files = MailFile::where('claim_id',$claim->id)->get();

            Mail::send('conclusion', ['mess' => $mess], function ($message) use($email/*,$files*/){
                 $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                 $message->sender('no_reply@expressclaims.it', 'Studio Zappa');
             
                 $message->to($email);
             
                 $message->subject('Completare la perizia');
             
                 $message->priority(3);

                // if ($files) {

                //     foreach ($files as $key => $filePath) {
                //         $message->attach($filePath->file);
                //     }
                // }
            });
        }

        if ($c->email1 != "") {
            sendMail($c->email1,$c,$c->user_id);
        }

        if ($c->email2 != "") {
            sendMail($c->email2,$c,$c->user_id);
        }

        if ($c->supervisor) {
            sendMail($c->_supervisor->email,$c,$c->user_id);
        }

        if ($c->society != "") {
            $this->sendCurl($json);
        }

        return $c;
    }

    public function closeSelected(Request $r)
    {
        $claims = Claim::find($r->data);

        function sendMail($email,$claim,$id)
        {
            $o = User::find($id);
            // if ($claim->mail_text) {
            //     $mess = $claim->mail_text;
            // }else{
                $mess = "Il Perito ".$o->fullname()." ha concluso gli accertamenti relativi alla perizia ".$claim->sin_number.", pregasi completare la perizia";
            // }

            // $files = MailFile::where('claim_id',$claim->id)->get();

            Mail::send('conclusion', ['mess' => $mess], function ($message) use($email/*,$files*/){
                $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                $message->sender('no_reply@expressclaims.it', 'Studio Zappa');
            
                $message->to($email);
            
                $message->subject('Completare la perizia');
            
                $message->priority(3);

                /*if ($files) {

                    foreach ($files as $key => $filePath) {
                        $message->attach($filePath->file);
                    }
                }*/
            });
        }

        foreach ($claims as $key => $c) {
            if ($c->society == "") {
                $c->status = 1;
            }else{
                $c->status = 2; // antes 1
            }
            $c->save();

            $soc = "";

            if ($c->society == 'Renova') {
                $idp = ltrim($c->sin_number,'R');
                $soc = 'R';
            }
            if ($c->society == 'Studio Zappa') {
                $idp = ltrim($c->sin_number,'Z');
                $soc = 'Z';
            }
            if ($c->society == 'Gespea') {
                $idp = ltrim($c->sin_number,'G');
                $soc = 'G';
            }

            $json = [
                "operation" => 'close',
                "idperizia" => (int)$idp,
                "society" => $soc,
                "stato" => 30,
                "dtperizia" => Carbon::now()->format('Y-m-d H:i:s'),
                "dtperizia2" => null,
                "idsopralluogo1" => $c->user_id,
                "idsopralluogo2" => null,
                "idgestore" => $c->supervisor,
                "dtt1" => Carbon::now()->format('Y-m-d H:i:s'),
                "note" => null,
                "VDP" => null,
                "AUT" => null
            ];

            if ($c->email1 != "") {
                sendMail($c->email1,$c,$c->user_id);
            }

            if ($c->email2 != "") {
                sendMail($c->email2,$c,$c->user_id);
            }

            if ($c->supervisor) {
                sendMail($c->_supervisor->email,$c,$c->user_id);
            }

            if ($c->society != "") {
                $this->sendCurl($json);
            }
        }
    }
    //
    public function authentication(Request $r)
    {
        $this->validate($r,[
            'email' => 'required',
            'password' => 'required',
        ],$this->messages);

        // return response()->json(User::where(['role_id' => 1])->get(),422);

        if (Auth::attempt(['email' => $r->email, 'password' => $r->password/*, 'role_id' => 2*/],true)) {
            if ((Auth::user()->operator && Auth::user()->operator->et == 1)) {
                return Auth::user();
            }
            Auth::logout();
            return response()->json([['It was not possible to log in, please check your data-code1']],422);
            // if (Auth::user()->role_id != 2) {
            // }
            // return Auth::user();
        }else{
            return response()->json([['It was not possible to log in, please check your data-code2']],422);
        }
    }
    public function registrationStreet(Request $r)
    {
        $this->validate($r,[
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|confirmed'
        ],$this->messages);

        $u = new User;
        $u->name = $r->name;
        $u->email = $r->email;
        $u->street_phone = '+'.$r->code.$r->phone;
        $u->role_id = 2;
        $u->status = 0;
        $u->password = bcrypt($r->password);
        $u->operator_call_id = "";
        $u->save();

        $o = new Operator;
        $o->user_id = $u->id;
        $o->et = 1;
        $o->save();

        return $u;
    }
    public function save_message(Request $r)
    {

    }
    public function registration(Request $r)
    {
        $this->validate($r,[
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|confirmed'
        ],$this->messages);

    	$u = new User;
    	$u->name = $r->name;
    	$u->email = $r->email;
    	$u->role_id = 0;
    	$u->status = 1;
    	$u->password = bcrypt($r->password);
        $u->operator_call_id = "";
    	$u->save();

    	$c = new Customer;
    	$c->user_id = $u->id;
    	$c->phone = $r->code.$r->phone;
    	$c->address = $r->address;
    	$c->lat = 0;
    	$c->lng = 0;
        $c->photo = "";
        $c->call_id = $u->id;

        $p = Preassign::where(['code' => $r->code, 'phone' => $r->phone])->first();

        if ($p) {
            $c->operator_id = $p->operator_id;
            $s = new Reservation;
            $s->message = "";
            $s->sin_number = $p->sin_number;
            $s->customer_id = $u->id;
            $s->status = 0;
            $s->save();
            $s->made = $s->created_at;
            $s->save();

            $p->status = 1;
            $p->save();
            $p->delete();
        }
        $c->save();

        $u->customer;

        if ($u->customer->photo == "") {
            $u->customer->photo = url('uploads/users/default.png');
        }

    	return $u;
    }

    public function saveLocation(Request $r)
    {
    	$u = User::find($r->id);
    	$c = Customer::where('user_id',$u->id)->first();
    	$c->lat = $r->lat;
        $c->lng = $r->lng;
    	$c->call_id = $r->callId;
    	$c->save();

    	return [];
    }

    public function savePhoto(Request $r)
    {
    	$u = User::find($r->id);
    	$c = Customer::where('user_id',$u->id)->first();
    	$c->photo = $r->photo;
    	$c->save();
        $u->customer;
        $u->customer;

    	return $u;
    }
    public function login(Request $r)
    {
    	$this->validate($r,[
    		'email' => 'required',
    		'password' => 'required',
    	],$this->messages);
        if(Auth::attempt(['email' => $r->email, 'password' => $r->password, 'role_id' => 0])){
            Auth::user()->customer->lat = $r->lat;
            Auth::user()->customer->lng = $r->lng;
            Auth::user()->customer->call_id = Auth::user()->id;
            Auth::user()->customer->save();
            Auth::user()->status = 1;
            Auth::user()->save();

            if (Auth::user()->customer->photo == "") {
                Auth::user()->customer->photo = url('uploads/users/default.png');
            }

            return Auth::user();
        }else{
            return Response::json(['error'=>['Credenziali non valide']],422);
        }
    }

    public function logout($id)
    {
        $u = User::find($id);
        $u->status = 0;
        $u->save();

        return [];
    }

    public function loadMessages($id, $destId)
    {
        $o = User::where('operator_call_id',$destId)->first();
        $res = Reservation::where('customer_id',$id)->where('status',0)->first();

        $m = Message::where(function($q) use($id, $o){

            $q->where(function($q) use($id,$o){
                $q->where('from_id',$o->id)->where('to_id',$id);
            })->orWhere(function($q) use($id,$o){
                $q->where('from_id',$id)->where('to_id',$o->id);
            });

        //     $q->where('from_id',$o->id)->where('to_id',$id);
        // })->orWhere(function($q) use($id, $o){
        //     $q->where('from_id',$id)->where('to_id',$o->id);
        })
        ->where('reservation_id',$res->id)
        ->with('from','to')->get();

        foreach ($m as $key => $value) {
            $value->created = $value->created_at->format('d M, H:i');
        }

        return [$o->name,$m];
    }

    public function saveMessage(Request $r)
    {
        $o = User::where('operator_call_id',$r->call_id)->first();
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        if ($res) {
            $m = new Message;
            $m->from_id = $r->id;
            $m->to_id = $o->id;
            $m->message = $r->message;
            $m->reservation_id = $res->id;
            $m->save();
        }

        return [gmdate("d M, H:i",time()+7200)];
    }

    public function uploadImage(Request $r)
    {
        // $i = new Image;
        // $i->user_id = $r->id;
        // $i->platform = $r->platform;
        // $i->imagen = $r->image;
        // $i->save();

        // return [];
    }

    public function uploadImageB(Request $r)
    {
        // $i = new Image;
        // $i->user_id = $r->id;
        // $i->platform = $r->platform;
        // $i->imagen = $r->image;
        // $i->save();

        $res = Reservation::where(['customer_id' => $r->id, 'status' => 0])->first();
        $u = User::find($r->id);

        $i = [Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$res->id,'type'=>1])->orderBy('id','desc')->get(),Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$res->id,'type'=>4])->orderBy('id','desc')->get()];

        foreach ($i as $key => $val) {
            foreach ($val as $key => $value) {

                $res = Reservation::find($value->reservation_id);

                $path = public_path().'/uploads/users/'.$value->user_id.'/'.$res->sin_number.'/images/';
                if (file_exists($path.$value->imagen)) {

                    if (!file_exists($path.'t_'.$value->imagen)) {
                        $img = _Image::make($path.$value->imagen);
                        $img->resize(200,null,function($c){
                            $c->aspectRatio();
                        });
                        $img->save($path.'t_'.$value->imagen);
                    }
                }

                $value->full_imagen = url('uploads/users/'.$u->id.'/'.$res->sin_number.'/images',$value->imagen);
                $value->imagen = url('uploads/users/'.$u->id.'/'.$res->sin_number.'/images','t_'.$value->imagen);
            }
        }

        return $i;
    }

    public function sendSMS(Request $r)
    {
        // Mail::send('mail', ['msg' => $r->message], function ($message) {
        //     $message->from('no_reply@expressclaims.it', 'ExpressClaims');
        //     $message->to('jorgesolano92@gmail.com', 'Prueba');
        //     $message->subject('Subject');
        // });

        // return [];
        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);

        if ($r->name) {
            $name = "EXPtech";
        }else{
            $name = "EXPclaims";
        }

        $twilio_number = $name;
        // $twilio_number = getenv("TWILIO_NUMBER");
        $message = $client->messages->create("+".$r->number, 
                ['from' => $twilio_number, 'body' => $r->message]);

        return json_encode($message->sid);
        /*if ($r->name) {
            $name = "EXPtech";
        }else{
            $name = "EXPclaims";
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <sms>
          <recipient>
            <msisdn>'.$r->number.'</msisdn>
          </recipient>
          <message>'.$r->message.'</message>
          <tpoa>'.$name.'</tpoa>
        </sms>';

        $p = SMSPassword::first();

        if ($p) {
            $password = $p->password;
        }else{
            $password = '';
        }
        
        $ch = curl_init('http://api.labsmobile.com/clients/');
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
         // curl_setopt($ch, CURLOPT_USERPWD, 'giorgio.zappa@studiozappa.com'.':'.$password);
         curl_setopt($ch, CURLOPT_USERPWD, 'giorgio.zappa@studiozappa.com'.':'.$password);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, 'XmlData='.$xml);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HEADER, true);
         curl_setopt($ch, CURLOPT_TIMEOUT, 15);
         $result = curl_exec($ch);*/

         // return json_encode($result);
    }

    public function saveRegistrationId(Request $r)
    {
        $c = Customer::where('user_id',$r->id)->first();
        $c->device_id = $r->onesignalId;
        $c->save();

        return [];
    }

    public function loadRequests($id)
    {
        return Reservation::where('customer_id',$id)->get();
    }

    public function sendRequest(Request $r)
    {
        if (Reservation::where('customer_id',$r->id)->where('status',0)->count() > 0) {
            return Response::json(['Hai già una richiesta con stato 0'],422);
        }
        $re = new Reservation;
        $re->customer_id = $r->id;
        $re->message = $r->message;
        $re->date = $r->date;
        $re->status = 0;
        $re->save();
        $re->made = $re->created_at;
        $re->save();

        return $re;
    }
    public function getUser($id)
    {
        return User::where('id',$id)->with('customer')->first();
    }

    public function getOperatorId($id)
    {
        $c = Customer::where('user_id',$id)->first();
        $o = User::find($c->operator_id);
        return $o;
    }

    public function checkSteps($id)
    {
        // $data1 = false;
        // $data2 = false;
        $res = Reservation::where(['customer_id' => $id, 'status' => 0])->first();
        if (!$res) {
            return [false];
        }
        return [true, $res->sin_number, $res->message == ""];

        // if ($res->file == "") {
        //     $data1 = true;
        //     $data2 = false;
        // }else{
        //     $data1 = false;
        //     $data2 = true;
        // }

        // return [false, $data1, $data2];
    }

    public function sendInformation(Request $r)
    {
        $res = new Reservation;
        $res->customer_id = $r->id;
        $res->message = $r->message;
        $res->file = "";
        $res->status = 0;
        $res->save();
        $res->made = $res->created_at;
        $res->save();
        return [];
    }

    public function uploadImage2(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        if ($res) {
            $f = new File;
            $f->reservation_id = $res->id;
            $f->user_id = $r->id;
            $f->file = $r->image;
            $f->lat = $r->lat;
            $f->lon = $r->lng;
            $f->address = $r->address;
            $f->save();
        }

        return [];
    }

    // public function updateDestId($id)
    // {
    //     $c = Customer::where('user_id',$id)->first();
    //     $o = User::find($c->operator_id);
    //     return $o->operator_call_id;
    // }

    // public function upload(Request $r)
    // {
    //     $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();

    //     if ($r->hasFile('file')) {
    //         $file = $r->file('file');
    //         $path = public_path().'/uploads/users/'.$r->id.'/'.$res->sin_number.'/images';
    //         $name = uniqid().rand(10000000,99999999).'-user-'.$r->id.'.mp4';
    //         $file->move($path,$name);
    //     }

    //     if ($res) {
    //         $f = new Video;
    //         $f->reservation_id = $res->id;
    //         $f->user_id = $r->id;
    //         $f->video = $name;
    //         $f->lat = $r->lat;
    //         $f->lon = $r->lng;
    //         $f->address = $r->address;
    //         $f->save();
    //     }

    //     return [];
    // }

    public function uploadVideo(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        $u = User::find($r->id);

        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/users/'.$r->id.'/'.$res->sin_number.'/videos';
            $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d-m-Y h_i_s').'.mp4';
            $file->move($path,$name);

            if ($res) {
                $f = new Video;
                $f->reservation_id = $res->id;
                $f->user_id = $r->id;
                $f->video = $name;
                $f->lat = $r->lat;
                $f->lon = $r->lng;
                $f->address = $r->address;
                $f->save();
            }

            return [url('uploads/users/'.$r->id.'/'.$res->sin_number.'/videos',$name),gmdate("d M, H:i",time()+7200)];
        }
    }

    public function uploadFile(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        $u = User::find($r->id);
        
        $validator = Validator::make($r->all(),[
            'file' => 'mimes:pdf,doc,docx'
        ]);

        if($validator->fails())
        {
            // $validator = Validator::make($r->all(),[
            //     'file' => 'mimes:jpg,jpeg,png'
            // ]);

            if(/*$validator->fails()*/false)
            {
                return ['nodoc'];

            }else{
                if ($r->hasFile('file')) {

                    $file = $r->file('file');

                    if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
                        $ext = 'jpg';
                    }else{
                        $ext = $file->getClientOriginalExtension();
                    }
                    $path = public_path().'/uploads/users/'.$r->id.'/'.$res->sin_number.'/images';
                    $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
                    $file->move($path,$name);

                    $i = new Image;
                    $i->reservation_id = $res->id;
                    $i->user_id = $r->id;
                    $i->imagen = $name;
                    $i->lat = $r->lat;
                    $i->lon = $r->lng;
                    $i->address = $r->address;
                    $i->type = $r->type;
                    $i->save();

                    // $im = new Imagick;

                    // if (strstr(mime_content_type($path.'/'.$name),'image')) {
                        
                    //     $im->readImage($path.'/'.$name);

                    //     $im->commentImage($r->lat.','.$r->lng);
                    //     // print($im->getImageProperty('comment'));
                    //     file_put_contents ($path.'/'.$name, $im);
                    //     // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));
                    // }

                    return [url('uploads/users/'.$r->id.'/'.$res->sin_number.'/images',$name),gmdate("d M, H:i",time()+7200),'image'];
                }
            }
        }else{
            if ($r->hasFile('file')) {
                $file = $r->file('file');

                if (strstr($file->getMimeType(),'pdf')) {
                    $ext = 'pdf';
                }elseif(strstr($file->getMimeType(),'word')){
                    $ext = 'docx';
                }else{
                    $ext = '';
                }
                $path = public_path().'/uploads/files';
                $name = uniqid().rand(10000000,99999999).'-utente-'.$r->id.'.'.$ext;
                $file->move($path,$name);

                return [url('uploads/files',$name) , gmdate("d M, H:i",time()+7200) , 'document'];
            }
        }
    }

    public function uploadFileImage(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        $u = User::find($r->id);

        $validator = Validator::make($r->all(),[
            'file' => 'mimes:jpg,jpeg,png'
        ]);

        if($validator->fails())
        {
            return ['noimg'];
        }

        if ($r->hasFile('file')) {
            $file = $r->file('file');

            if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
                $ext = 'jpg';
            }else{
                $ext = $file->getClientOriginalExtension();
            }
            $path = public_path().'/uploads/users/'.$r->id.'/'.$res->sin_number.'/images';
            $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
            $file->move($path,$name);

            $i = new Image;
            $i->reservation_id = $res->id;
            $i->user_id = $r->id;
            $i->imagen = $name;
            $i->lat = $r->lat;
            $i->lon = $r->lng;
            $i->address = $r->address;
            $i->type = $r->type;
            $i->save();

            // $im = new Imagick;

            // if (strstr(mime_content_type($path.'/'.$name),'image')) {
                
            //     $im->readImage($path.'/'.$name);

            //     $im->commentImage($r->lat.','.$r->lng);
            //     // print($im->getImageProperty('comment'));
            //     file_put_contents ($path.'/'.$name, $im);
            //     // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));
            // }

            return [url('uploads/users/'.$r->id.'/'.$res->sin_number.'/images',$name),gmdate("d M, H:i",time()+7200)];
        }
    }

    public function uploadVideoTech(Request $r)
    {
        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/operator/'.$r->id.'/'.$r->sin_number.'/videos';
            $name = $r->sin_number.'_'.Carbon::now()->format('d-m-Y h_i_s').'.mp4';
            $file->move($path,$name);

            $f = new ClaimFile;
            $f->sin_number = $r->sin_number;
            $f->user_id = $r->id;
            $f->type = "video";
            $f->file = $name;
            $f->lat = $r->lat;
            $f->lon = $r->lng;
            $f->offline = $r->offline;
            $f->address = $r->address;
            $f->map_canvas = "";
            $f->save();

            return [url('uploads/operator/'.$r->id.'/'.$r->sin_number.'/videos',$name),gmdate("d M, H:i",time()+7200)];
        }
    }

    public function uploadAudioTech(Request $r)
    {
        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/operator/'.$r->id.'/'.$r->sin_number.'/audios';
            $name = $file->getClientOriginalName();
            $file->move($path,$name);

            $f = new ClaimFile;
            $f->sin_number = $r->sin_number;
            $f->user_id = $r->id;
            $f->type = "audio";
            $f->file = $name;
            $f->lat = $r->lat;
            $f->lon = $r->lng;
            $f->offline = $r->offline;
            $f->address = $r->address;
            $f->map_canvas = "";
            $f->save();

            return [url('uploads/operator/'.$r->id.'/'.$r->sin_number.'/audios',$name),gmdate("d M, H:i",time()+7200)];
        }
    }
    public function uploadFileImageTech(Request $r)
    {
        if ($r->hasFile('file')) {
            $file = $r->file('file');
            // if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
            //     $ext = 'jpg';
            // }else{
            $ext = $file->getClientOriginalExtension();
            // }
            $path = public_path().'/uploads/operator/'.$r->id.'/'.$r->sin_number.'/images';
            $name = $r->sin_number.'_'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
            $file->move($path,$name);

            $i = new ClaimFile;
            $i->sin_number = $r->sin_number;
            $i->user_id = $r->id;
            $i->type = "image";
            $i->file = $name;
            $i->lat = $r->lat;
            $i->lon = $r->lng;
            $i->offline = $r->offline;
            $i->address = $r->address;
            $i->map_canvas = "";
            $i->save();

            $img = _Image::make($path.'/'.$name);
            $img->resize(1280,null,function($c){
                $c->aspectRatio();
            });
            $img->save($path.'/'.$name);

            // $im = new Imagick;

            // if (strstr(mime_content_type($path.'/'.$name),'image')) {
                
            //     $im->readImage($path.'/'.$name);

            //     $im->commentImage($r->lat.','.$r->lng);
            //     // print($im->getImageProperty('comment'));
            //     file_put_contents ($path.'/'.$name, $im);
            //     // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));
            // }

            return [url('uploads/operator/'.$r->id.'/'.$r->sin_number.'/images',$name),gmdate("d M, H:i",time()+7200)];
        }
    }

    public function uploadExtraFileImageTech(Request $r)
    {
        $this->validate($r,[
            'address' => 'required',
            'file' => 'required',
            'id' => 'required',
        ],[
            'address.required' => "Il campo indirizzo è obbligatorio",
            'file.required' => "Scegli un'immagine",
            'id.required' => "Seleziona la tipologia",
        ]);

        if ($r->hasFile('file')) {

            $c = Claim::find($r->id);

            // $date = Carbon::createFromFormat('d-m-Y H:i',$r->date);

            $file = $r->file('file');
            // if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
            //     $ext = 'jpg';
            // }else{
            $ext = $file->getClientOriginalExtension();
            // }
            $path = public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images';
            $name = $c->sin_number.'_'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
            $file->move($path,$name);

            $i = new ClaimFile;
            $i->sin_number = $c->sin_number;
            $i->user_id = $c->user_id;
            $i->type = "image";
            $i->file = $name;
            $i->lat = $r->lat ? $r->lat : 0;
            $i->lon = $r->lng ? $r->lng : 0;
            $i->offline = 0;
            $i->address = $r->address;
            $i->map_canvas = "";
            $i->web = $r->date ? $r->date : 'N/A';
            $i->save();

            $img = _Image::make($path.'/'.$name);
            $img->resize(1280,null,function($c){
                $c->aspectRatio();
            });
            $img->save($path.'/'.$name);

            $img = _Image::make($path.'/'.$name);
            $img->resize(200,null,function($c){
                $c->aspectRatio();
            });
            $img->save($path.'/t_'.$name);

            // $im = new Imagick;

            // if (strstr(mime_content_type($path.'/'.$name),'image')) {
                
            //     $im->readImage($path.'/'.$name);

            //     $im->commentImage($r->lat.','.$r->lng);
            //     // print($im->getImageProperty('comment'));
            //     file_put_contents ($path.'/'.$name, $im);
            //     // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));
            // }
        }else{
            return response()->json([["Seleziona un'immagine"]],422);
        }
    }

    public function uploadExtraFileImage(Request $r)
    {
        $this->validate($r,[
            'address' => 'required',
            'file' => 'required',
            'id' => 'required',
        ],[
            'address.required' => "Il campo indirizzo è obbligatorio",
            'file.required' => "Scegli un'immagine",
            'id.required' => "ID REQUIRED",
        ]);

        if ($r->hasFile('file')) {
    
            $res = Reservation::find($r->id);
            $u = User::find($res->customer_id);

            $file = $r->file('file');

            if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
                $ext = 'jpg';
            }else{
                $ext = $file->getClientOriginalExtension();
            }
            $path = public_path().'/uploads/users/'.$res->customer_id.'/'.$res->sin_number.'/images';
            $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
            $file->move($path,$name);

            $i = new Image;
            $i->reservation_id = $res->id;
            $i->user_id = $res->customer_id;
            $i->imagen = $name;
            $i->lat = $r->lat ? $r->lat : 0;
            $i->lon = $r->lng ? $r->lng : 0;
            $i->address = $r->address;
            $i->type = 5;
            $i->web = $r->date ? $r->date : 'N/A';
            $i->save();

            // return [url('uploads/users/'.$r->id.'/'.$res->sin_number.'/images',$name),gmdate("d M, H:i",time()+7200)];

            // $c = Claim::find($r->id);

            // $file = $r->file('file');
            
            // $ext = $file->getClientOriginalExtension();
            // // }
            // $path = public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images';
            // $name = $c->sin_number.'_'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
            // $file->move($path,$name);

            // $i = new ClaimFile;
            // $i->sin_number = $c->sin_number;
            // $i->user_id = $c->user_id;
            // $i->type = "image";
            // $i->file = $name;
            // $i->lat = $r->lat ? $r->lat : 0;
            // $i->lon = $r->lng ? $r->lng : 0;
            // $i->offline = 0;
            // $i->address = $r->address;
            // $i->map_canvas = "";
            // $i->web = $r->date ? $r->date : 'N/A';
            // $i->save();

            $img = _Image::make($path.'/'.$name);
            $img->resize(200,null,function($c){
                $c->aspectRatio();
            });
            $img->save($path.'/t_'.$name);

            // $im = new Imagick;

            // if (strstr(mime_content_type($path.'/'.$name),'image')) {
                
            //     $im->readImage($path.'/'.$name);

            //     $im->commentImage($r->lat.','.$r->lng);
            //     // print($im->getImageProperty('comment'));
            //     file_put_contents ($path.'/'.$name, $im);
            //     // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));
            // }
        }else{
            return response()->json([["Seleziona un'immagine"]],422);
        }
    }

    public function getClaimMedia(Request $r)
    {
        $c = Claim::where('sin_number',$r->sin_number)->first();
        $f = ClaimFile::where('sin_number',$r->sin_number)->orderBy('id','desc')->get();
        foreach ($f as $key => $value) {
            if ($value->type == "video") {
                $value->preview = url('video.png');
                $value->file = url('uploads/operator/'.$c->user_id.'/'.$r->sin_number.'/videos',$value->file);
                $value->file = str_replace(' ','%20',$value->file);
            }else if ($value->type == "audio") {
                $value->preview = url('audio.png');
                $value->file = url('uploads/operator/'.$c->user_id.'/'.$r->sin_number.'/audios',$value->file);
                $value->file = str_replace(' ','%20',$value->file);
            }else{
                $value->preview = url('uploads/operator/'.$c->user_id.'/'.$r->sin_number.'/images',$value->file);
                $value->preview = str_replace(' ','%20',$value->preview);
            }
        }

        return $f;
    }
    public function deleteFile(Request $r)
    {
        $f = ClaimFile::find($r->id);
        if ($f->type == "video") {
            $file = public_path().'/uploads/operator/'.$f->user_id.'/'.$f->sin_number.'/videos/'.$f->file;
        }else if ($f->type == "audio") {
            $file = public_path().'/uploads/operator/'.$f->user_id.'/'.$f->sin_number.'/audios/'.$f->file;
        }else{
            $file = public_path().'/uploads/operator/'.$f->user_id.'/'.$f->sin_number.'/images/'.$f->file;
        }
        @unlink($file);
        $f->delete();
    }

    public function saveInformation(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();
        if ($res) {
            $res->message = $r->info;
            $res->save();
        }

        return [];
    }

    public function uploadSnapshot(Request $r)
    {
        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $path = public_path().'/uploads/files';
            $name = $r->clientId.'.'.$file->getClientOriginalExtension();
            $file->move($path,$name);
        }
    }

    /**********/

    public function sendCode(Request $r)
    {
        $u = User::where('email',$r->email)->first();

        if (!$u) {
            return Response::json(['error'=>['Email does not exists, please check it!']],422);
        }

        $code = rand(1000,9999);

        Mail::send('code', ['code'=>$code], function ($message) use ($u) {
            $message->from('no_reply@expressclaims.it', 'Studio Zappa');
            $message->to($u->email, $u->name);
            $message->subject('Codice per ripristinare la password');
        });

        $u->recovery_code = bcrypt($code);
        $u->save();

        return [$u->email];
    }
    public function checkCode(Request $r)
    {
        $u = User::where(['email'=>$r->email])->first();

        if (!\Hash::check($r->code, $u->recovery_code)) {
            return Response::json(['error'=>['Il codice inserito non è corretto, riprova.']],422);
        }

        $u->recovery_code = null;
        $u->save();

        return $u;
    }

    public function changePassword(Request $r)
    {
        $u = User::find($r->id);
        $u->password = bcrypt($r->password);
        $u->save();
    }

    public function saveNumber(Request $r)
    {
        $u = User::find($r->id);
        $u->customer->phone = $r->phone;

        $p = Preassign::where(['fullphone' => $r->phone])->first();

        if ($p) {
            $u->customer->operator_id = $p->operator_id;
            $s = new Reservation;
            $s->message = "";
            $s->sin_number = $p->sin_number;
            $s->customer_id = $u->id;
            $s->status = 0;
            $s->save();
            $s->made = $s->created_at;
            $s->save();

            $p->status = 1;
            $p->save();
            $p->delete();
        }

        $u->customer->save();

        if ($u->customer->photo == "") {
            $u->customer->photo = url('uploads/users/default.png');
        }

        return $u;
    }

    public function checkCall($id)
    {
        $u = User::find($id);
        if ($u->customer->can_call == NULL) {
            return 0;
        }
        return $u->customer->can_call;
    }

    public function reloadUser($id)
    {
        $u = User::find($id);
        $u->customer;
        if ($u->customer->photo == "") {
            $u->customer->photo = url('uploads/users/default.png');
        }
        $u->operator_name = User::find($u->customer->operator_id)->name;
        return $u;
    }

    public function loadSinister($id)
    {
        $res = Reservation::where('customer_id',$id)->where('status',0)->first();
        if (!$res) {
            return [];
        }
        return $res;
    }

    public function checkUser($id)
    {
        $u = User::find($id);
        if (!$u) {
            return [];
        }
        return $u;
    }

    public function getTime()
    {
        return [gmdate("d M, H:i",time()+7200)];
    }

    public function loadInformation($sin_number)
    {
        $c = Claim::where('sin_number',$sin_number)->first();

        if ($c->json_information) {
            return [$c->json_information,'json'];
        }

        return [$c->information == NULL ? json_encode('{}') : json_encode($c->information),'information'];
    }

    public function uploadInformation(Request $r)
    {
        // return $r->all();
        $c = Claim::where('sin_number',$r->sin_number)->first();

        if (!$c) {
            return [];
        }
        // $c->information = json_encode($r->all());
        $c->json_information = $r->all();
        $c->save();
        return $c;
    }


    /**/



    public function autoassign(Request $r)
    {
        $this->validate($r,[
            'sin_number' => 'required|confirmed'
        ],[
           'sin_number.required' => 'È richiesto un riferimento interno',
           'sin_number.confirmed' => 'Il riferimento interno non corrisponde'
        ]);

        // if ($r->society == 'Renova') {
        $r->sin_number = 'A'.$r->sin_number;
        // }
        // if ($r->society == 'Studio Zappa') {
        //     $r->sin_number = 'Z'.$r->sin_number;
        // }
        // if ($r->society == 'Gespea') {
        //     $r->sin_number = 'G'.$r->sin_number;
        // }

        $res = Reservation::where('sin_number',$r->sin_number)->first();

        // if (!$res) {
        //     return response()->json([['Riferimento interno non trovato']],422);
        // }

        $c = Claim::where(['sin_number'=>$r->sin_number])->first();

        // if ($c) {
        if ($res || $c) {
            return response()->json([['Riferimento interno già registrato']],422);
            // $c->delete();
        }

        $u = User::find($r->id);

        $c = new Claim;
        $c->sin_number = $r->sin_number;
        $c->user_id = $r->id;
        $c->name = $r->name ? $r->name : "";
        $c->society = "";
        $c->status = 0;
        $c->email1 = $u->email;
        $c->email2 = "";
        $c->supervisor = $r->id;
        $c->mail_text = "Autoassegnazione";
        $c->autoassign = 1;
        $c->save();

        // $files = [];

        // if ($r->attachments) {
        //     foreach ($r->attachments as $key => $value) {
        //         $file = $value;
        //         $path = public_path().'/uploads/attachments';
        //         $name = Carbon::now()->format('d_m_Y-h_i_s').'-'.$file->getClientOriginalName();
        //         $file->move($path,$name);
        //         $files[] = public_path().'/uploads/attachments/'.$name;
        //     }
        // }

        // foreach ($files as $key => $value) {
        //     $i = new MailFile;
        //     $i->claim_id = $c->id;
        //     $i->file = $value;
        //     $i->save();
        // }

        // $u = User::find($c->user_id);

        $this->send_msg_notification($u->device_id,$c->sin_number,$u,$c,false);
    }

    // change society from the web
    public function changeSociety(Request $r)
    {
        // return response()->json($r->all(),422);

        $c = Claim::find($r->id);

        $old_riferimento = $c->sin_number;

        // $c->sin_number = ltrim($c->sin_number, 'A');
        $c->sin_number = $r->sin_number;

        if ($r->society == 'Renova') {
            $c->sin_number = 'R'.$c->sin_number;
        }
        if ($r->society == 'Studio Zappa') {
            $c->sin_number = 'Z'.$c->sin_number;
        }
        if ($r->society == 'Gespea') {
            $c->sin_number = 'G'.$c->sin_number;
        }

        $res = Reservation::where('sin_number',$c->sin_number)->first();

        $cl = Claim::where(['sin_number'=>$c->sin_number])->first();

        // if ($c) {
        if ($res || $cl) {
            return response()->json([['Riferimento interno già registrato']],422);
            // $c->delete();
        }

        $c->society = $r->society;

        $c->save();

        rename(public_path().'/uploads/operator/'.$c->user_id.'/'.$old_riferimento, public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number);

        foreach (ClaimFile::where('sin_number',$old_riferimento)->get() as $key => $value) {
            $old_file = $value->file;
            $value->file = str_replace($value->sin_number, $c->sin_number, $value->file);

            $value->sin_number = $c->sin_number;
            $value->save();

            rename(
                public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images/'.$old_file,
                public_path().'/uploads/operator/'.$c->user_id.'/'.$c->sin_number.'/images/'.$value->file
            );
        }

        foreach ($c->claims as $key => $value) {

            $_old_rif = $value->sin_number;

            $value->sin_number = str_replace($old_riferimento, $c->sin_number, $value->sin_number);

            $value->sin_number = ltrim($value->sin_number, 'A');

            // if ($r->society == 'Renova') {
            //     $value->sin_number = 'R'.$value->sin_number;
            // }
            // if ($r->society == 'Studio Zappa') {
            //     $value->sin_number = 'Z'.$value->sin_number;
            // }
            // if ($r->society == 'Gespea') {
            //     $value->sin_number = 'G'.$value->sin_number;
            // }

            $value->society = $r->society;

            $value->save();

            rename(public_path().'/uploads/operator/'.$c->user_id.'/'.$_old_rif, public_path().'/uploads/operator/'.$c->user_id.'/'.$value->sin_number);

            foreach (ClaimFile::where('sin_number',$_old_rif)->get() as $key => $_value) {

                $old_file = $_value->file;
                $_value->file = str_replace($_value->sin_number, $c->sin_number, $_value->file);
                
                $_value->sin_number = $value->sin_number;
                $_value->save();

                rename(
                    public_path().'/uploads/operator/'.$c->user_id.'/'.$_value->sin_number.'/images/'.$old_file,
                    public_path().'/uploads/operator/'.$c->user_id.'/'.$_value->sin_number.'/images/'.$_value->file
                );
            }
        }

    }
























    // first function to convert wmv to mp4, deprecated
    public function convertMp4(Request $r)
    {
        $path = public_path().'/uploads/videos';
        $rec = Record::find($r->id);
        // return url('/uploads/videos',$rec->name);

        // CloudConvert::file( $path.'/'.$rec->name )->to('mp4');

        $cloudconvert = new CloudConvert([
            'api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNiNTRlZGRjYjk3ZDJjYmEzOTdkNzg0ZmNhYjc1Mzc1ZGU1NWMxNzlmNDNmNDk4MzMwZDJmNDNjZDhjMmFjYWMwZTcxZGYwODliYWNiZDg3In0.eyJhdWQiOiIxIiwianRpIjoiM2I1NGVkZGNiOTdkMmNiYTM5N2Q3ODRmY2FiNzUzNzVkZTU1YzE3OWY0M2Y0OTgzMzBkMmY0M2NkOGMyYWNhYzBlNzFkZjA4OWJhY2JkODciLCJpYXQiOjE1ODg2OTQ0NTQsIm5iZiI6MTU4ODY5NDQ1NCwiZXhwIjo0NzQ0MzY4MDU0LCJzdWIiOiI0MTk2NjgyMiIsInNjb3BlcyI6WyJ1c2VyLnJlYWQiLCJ1c2VyLndyaXRlIiwidGFzay5yZWFkIiwidGFzay53cml0ZSIsIndlYmhvb2sud3JpdGUiLCJwcmVzZXQucmVhZCIsInByZXNldC53cml0ZSIsIndlYmhvb2sucmVhZCJdfQ.TmeMPwiHzsA3BQv3CJfm1nLeYK-dk_eO1tWQWMXF-EawZYdw-RuRTRobjOSKSGXkAikoSoGGSL1iD59paJb8tAB-7klXcs4mIkuNb-gWO1Q-nA9DdrS78HqE7s_x9c43W1ZiK81UbLdzWRPWG9zGHAacrBryXKm2tURhMNdQ4LIbmk2JWM4DQxbc_dQaFenINuyXlOoRrUPWUYW5cRjR9GeQh7yz9Wt44J1Q8o4LNxS-Ht_YTrW68zQQmHjMvdhZo4aCZZGCabO2KwvZ55ojlRXeNm8Ook59RgRzpx5OO5C2HEYww2zjRb3DOHmKChywNJWtQM4T0HBiq21XKm5xGpmHszfygTPjCwpdmGUx5yPD0SUEcoOw_Y5gL-CfksWAPwZi2bGkZ4_9YHjkpXOP2TtbsGFZC8SavgBFq_AUAkymBeSYg0wWt3hQQH2D5qS1P2DmbKC5jX3tPr7FcSFYeiXFK5udP3nPSKS5YuWxkfEa17dF0JfzrtqcsSUDJyVkjdPIXyGQMqd6AfMf9UieOQnz9YEjB64IHdERb2KIo6PgGbE5MZ3HnRwac17U4Tn2xyW29HX1yyzaZFT445YZbWILk4zjX0hXreGLB9qESyxCnHFN0mXqMdT4OlP4zoJ58I82lU6bPdOig-PxBjrsOcDjo0eego04rQdZSx1b3NM',
            'sandbox' => false
        ]);

        $job = (new Job())
            ->addTask(
                (new Task('import/url', 'import-my-file'))
                    // ->set('url', url('/uploads/videos/zappa-giorgio-19032020-20_04_2020-11_47_40.webm'))
                    ->set('url', url('/uploads/videos',$rec->name))
            )
            ->addTask(
                (new Task('convert', 'convert-my-file'))
                    ->set('input', 'import-my-file')
                    ->set('output_format', 'mp4')
                    ->set('preset', 'ultrafast')
                    ->set('video_codec', 'copy')
            )
            ->addTask(
                (new Task('export/url', 'export-my-file'))
                    ->set('input', 'convert-my-file')
                    ->set('inline', false)
            );

        $cloudconvert->jobs()->create($job);

        $cloudconvert->jobs()->wait($job);

        $file = $job->getExportUrls()[0];

        $source = $cloudconvert->getHttpTransport()->download($file->url)->detach();
        $dest = fopen(public_path().'/uploads/videos/' . $file->filename, 'w');
        
        stream_copy_to_stream($source, $dest);

        // @unlink($path.'/'.$rec->name);

        $rec->name = str_replace('.webm','.mp4',$rec->name);
        $rec->save();

        return [url('/uploads/videos',$rec->name)];

    }

    public function getTypologies()
    {
        return Typology::all();
    }
    public function getSections($id)
    {
        return TypologySection::where('typology_id',$id)->with('inputs','inputs.options')->orderBy('order','desc')->get();
    }

    // function o upload image to express tech from the web
    public function uploadExternalImageTech(Request $r)
    {
        // \Log::info($r->all());
        if ($r->hasFile('file')) {

            // \Log::info($r->all());
            // \Log::info($r->date);
            // sleep ( 1 );

            $file = $r->file('file');

            if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
                $ext = 'jpg';
            }else{
                $ext = $file->getClientOriginalExtension();
            }
            $path = public_path().'/uploads/operator/'.$r->id.'/'.$r->sin_number.'/images';
            $name = $r->sin_number.'_'.Carbon::now()->format('d-m-Y h_i_s_u').'.'.$ext;
            $file->move($path,$name);

            if (!$r->date || $r->date == 'undefined') {
                $r->date = Carbon::now()->format("Y-m-d H:i:s");
            }

            $f = new ClaimFile;
            $f->sin_number = $r->sin_number;
            $f->user_id = $r->id;
            $f->type = "image";
            $f->file = $name;
            $f->lat = $r->lat;
            $f->lon = $r->lng;
            $f->offline = 2;
            $f->address = $r->address;
            $f->map_canvas = "";
            $f->web = $r->date ? Carbon::parse($r->date)->format('Y-m-d H:i:s') : 'N/A';
            $f->save();

            $img = _Image::make($path.'/'.$name);
            $img->resize(1280,null,function($c){
                $c->aspectRatio();
            });
            $img->save($path.'/'.$name);


        }else{

            foreach ($r->images as $key => $file) 
            {
                if ($file->getClientOriginalExtension() == "" || $file->getClientOriginalExtension() == NULL) {
                    $ext = 'jpg';
                }else{
                    $ext = $file->getClientOriginalExtension();
                }

                $path = public_path().'/uploads/operator/'.$r->id.'/'.$r->sin_number.'/images';
                $name = $r->sin_number.'_'.$key.'_'.Carbon::now()->format('d-m-Y h_i_s').'.'.$ext;
                $file->move($path,$name);

                if (!$r->date || $r->date == 'undefined') {
                    $r->date = Carbon::now()->format("Y-m-d H:i:s");
                }

                $f = new ClaimFile;
                $f->sin_number = $r->sin_number;
                $f->user_id = $r->id;
                $f->type = "image";
                $f->file = $name;
                $f->lat = $r->lat;
                $f->lon = $r->lng;
                $f->offline = 2;
                $f->address = $r->address;
                $f->map_canvas = "";
                $f->web = $r->date ? Carbon::parse($r->date)->format('Y-m-d H:i:s') : 'N/A';
                $f->save();
            }

        }
    }
}
