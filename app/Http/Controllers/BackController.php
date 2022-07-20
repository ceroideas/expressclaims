<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Push;
use App\SMS;
use App\Predefined;
use App\User;
use App\Reservation;
use App\Message;
use App\Video;
use App\File;
use App\Image;
use App\Record;
use App\Preassign;
use App\Detail;
use App\SMSPassword;

use App\Claim;
use App\ClaimFile;

use App\Company;
use App\PolicyModel;
use App\Damage;

use App\PhoneModel;

use App\PredefinedMail;
use App\MailFile;

use App\MapInformation;

use App\SelfManagement;
use App\SelfManagementImage;
use App\SelfManagementDocument;

use Carbon\Carbon;
use Validator;
use Response;
use Auth;
use Mail;

use PDF;
use ZipArchive;
use Excel;
use DB;
use _Image;
use App\ExcelFile;
use App\Expert;
use App\State;

use Spatie\GoogleCalendar\Event;

// use CloudConvert;

use \CloudConvert\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;

use Twilio\Rest\Client;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class BackController extends Controller
{
    //
    public function __construct()
    {
        error_reporting(E_ALL ^ E_DEPRECATED);

        $this->messages = [
            'number.required' => 'Il numero di telefono è richiesto',
            'title.required' => 'Il titolo è richiesto',
            'message.required' => 'Il messaggio è richiesto',
            'phone.required' => 'Il numero di telefono è richiesto',
            'phone.unique' => 'Il numero di telefono è già in uso',
            'sin_number.required' => 'Il numero di sinistro è richiesto',
            'sin_number.unique' => 'Il numero di sinistro è già in uso',
            'operator_id.required' => "L'operatore è richiesto",
        ];
    }

    public function uploadExcel(Request $r)
    {
        // return $r->all();

        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/excel';
            $name = $file->getClientOriginalName();
            $file->move($path,$name);
            /**/
            $all = MapInformation::all();
            // $f = ExcelFile::first();
            // if (!$f) {
                $f = new ExcelFile;
            // }
            $f->name = $name;
            $f->save();
            /**/
            Excel::selectSheetsByIndex(0)->load(public_path().'/uploads/excel/'.$name, function($reader) use($name,$all) {

                try {

                    $results = $reader->get();

                    // MapInformation::truncate();
                    // foreach ($all as $key => $value) {
                    //     $value->status = 0;
                    //     $value->save();
                    // }

                    DB::table('map_informations')->update(['status'=>0]);

                    foreach ($results as $key => $fila) {

                        if ($fila['tp'] != NULL) {
                            // $a = 0;
                            $i = MapInformation::where(['Danneggiato'=>$fila['nome'], 'N_Sinistro'=>$fila['n.sinistro']])->first();

                            if (!$i) {
                                $i = new MapInformation;
                            }

                            $i->N_P = isset($fila['n.p.']) ? $fila['n.p.'] : '';
                            $i->TP = isset($fila['tp']) ? $fila['tp'] : '';
                            $i->Assicurato = isset($fila['assicurato']) ? $fila['assicurato'] : '';
                            $i->Danneggiato = isset($fila['nome']) ? $fila['nome'] : '';
                            $i->COMUNE = isset($fila['comune']) ? $fila['comune'] : '';
                            $i->CAP = isset($fila['cap']) ? $fila['cap'] : '';
                            $i->PROVINCIA = isset($fila['provincia']) ? $fila['provincia'] : '';
                            $i->INDIRIZZO = isset($fila['indirizzo']) ? $fila['indirizzo'] : '';
                            $i->TELEFONO = isset($fila['telefono']) ? $fila['telefono'] : '';
                            $i->CELLULARE = isset($fila['cellulare']) ? $fila['cellulare'] : '';
                            $i->EMAIL = isset($fila['email']) ? $fila['email'] : '';
                            $i->Stato = isset($fila['stato']) ? $fila['stato'] : '';
                            $i->SOPRALLUOGO = isset($fila['perito']) && $fila['perito'] != null ? $fila['perito'] : (isset($fila['sopralluoghista']) && $fila['sopralluoghista'] != null ? $fila['sopralluoghista'] : '');
                            $i->DATA_SOPRALLUOGO = isset($fila['data_sopralluogo']) && $fila['data_sopralluogo'] != null ? $fila['data_sopralluogo'] : '';
                            $i->RISERVA = isset($fila['riserva']) ? $fila['riserva'] : '';
                            $i->N_Sinistro = isset($fila['n.sinistro']) ? $fila['n.sinistro'] : '';
                            $i->DT_Sinistro = isset($fila['dt_sinistro']) ? $fila['dt_sinistro'] : '';
                            $i->DT_Incarico = isset($fila['dt_incarico']) ? $fila['dt_incarico'] : '';
                            $i->DT_ASSEGNATA = isset($fila['dt_assegnata']) ? $fila['dt_assegnata'] : null;
                            $i->DT_CONSEGNA = isset($fila['dt_riconsegna']) ? $fila['dt_riconsegna'] : null;
                            $i->COMPAGNIA = isset($fila['compagnia']) ? $fila['compagnia'] : '';
                            $i->AGENZIA = isset($fila['agenzia']) ? $fila['agenzia'] : '';
                            // $i->NP = isset($fila['np']) ? $fila['np'] : '';
                            $i->type = isset($fila['tipo']) && $fila['tipo'] != null ? $fila['tipo'] : 1;
                            $i->PERITO_GESTORE = isset($fila['perito_gestore']) ? $fila['perito_gestore'] : '';
                            $i->note = isset($fila['note']) ? $fila['note'] : '';

                            $i->society = isset($fila['soc']) ? $fila['soc'] : '';

                            $i->project = null;

                            $i->file_name = $name;
                            $i->status = 1;
                            $i->save();

                            // if ($all) {
                            //     foreach ($all as $key => $value) {
                            //         if ($value->Danneggiato == $i->Danneggiato && $value->N_P == $i->N_P) {
                            //             // $a++;
                            //             $i->lat = $value->lat;
                            //             $i->lng = $value->lng;
                            //             $i->save();
                            //         }
                            //     }
                            // }
                        }
                    }

                    MapInformation::where('status',0)->delete();

                } catch (Exception $e) {

                    // foreach ($all as $key => $value) {
                    //     $value->status = 1;
                    //     $value->save();
                    // }

                    DB::table('map_informations')->update(['status'=>1]);

                    return response()->json(['File non leggibile!'],422);

                }

                // $reader->each(function($fila) {

                // });

            });

        }
    }

    public function alignExperts(Request $r)
    {
        // return $r->all();

        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/excel';
            $name = $file->getClientOriginalName();
            $file->move($path,$name);
            /**/
            Expert::where('society',$r->type)->delete();
            /**/
            Excel::selectSheetsByIndex(0)->load(public_path().'/uploads/excel/'.$name, function($reader) use($r) {

                try {

                    $results = $reader->get();

                    foreach ($results as $key => $fila) {

                        if ($fila['idp'] != NULL) {
                            // $a = 0;
                            $e = new Expert;

                            $e->idp = $fila['idp'];
                            $e->name = $fila['nome'];
                            $e->email = $fila['mail'];
                            $e->phone = $fila['cellulare'];
                            $e->society = $r->type;
                            $e->save();
                        }
                    }

                } catch (Exception $e) {

                    return response()->json(['File non leggibile!'],422);

                }

                // $reader->each(function($fila) {

                // });

            });

        }
    }
    /**/

    public function alignStates(Request $r)
    {
        // return $r->all();

        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/excel';
            $name = $file->getClientOriginalName();
            $file->move($path,$name);
            /**/
            State::truncate();
            /**/
            Excel::selectSheetsByIndex(0)->load(public_path().'/uploads/excel/'.$name, function($reader) use($r) {

                try {

                    $results = $reader->get();

                    foreach ($results as $key => $fila) {

                        if ($fila['idavanzamento'] !== NULL) {
                            // $a = 0;
                            $s = new State;

                            $s->idav = $fila['idavanzamento'];
                            $s->description = $fila['descr'];
                            $s->order = $fila['ordine'];
                            $s->save();
                        }
                    }

                } catch (Exception $e) {

                    return response()->json(['File non leggibile!'],422);

                }

                // $reader->each(function($fila) {

                // });

            });

        }
    }

    public function saveLatLng(Request $r, $id)
    {
        $mi = MapInformation::find($id);
        $mi->lat = $r->lat;
        $mi->lng = $r->lng;
        $mi->latlng = $r->lat.','.$r->lng;
        $mi->save();
    }

    public function getMapInformation2(Request $r)
    {
        $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->where(function($q){
            $q->where(['lat'=>'','lng'=>''])
              ->orWhere(['lat'=>null,'lng'=>null]);
        })->get();
        return $mi;
    }

    public function getMapInformation3(Request $r)
    {
        $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})
        ->where('status',1)
        ->where(function($q) use($r){
            $q->where('SOPRALLUOGO','!=',$r->perito2);
            $q->where('SOPRALLUOGO','!=','');
        })
        ->where(function($q){
            $q->where('DATA_SOPRALLUOGO','');
            $q->orWhere('DATA_SOPRALLUOGO',NULL);
        })
        ->with('diferents')
        ->whereIn('type',$r->data_type)
        ->groupBy('lat','lng')
        ->get();

        // foreach ($mi as $key => $val) {
        //     $total = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(['lat'=>$val->lat,'lng'=>$val->lng])->orderBy('DATA_SOPRALLUOGO','desc')->get();
            
        //     $sinisters = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->

        //     where(function($q) use($r){
        //         $q->where('SOPRALLUOGO','!=',$r->perito2);
        //         $q->where('SOPRALLUOGO','!=','');
        //     })
        //     ->where(function($q){
        //         $q->where('DATA_SOPRALLUOGO','');
        //         $q->orWhere('DATA_SOPRALLUOGO',NULL);
        //     })
        //     ->

        //     where(['lat'=>$val->lat,'lng'=>$val->lng])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro')

        //     ->get();

        //     $val->total = $total->count();
        //     $val->sinisters = count($sinisters);
        //     $val->diferents = $sinisters;
        // }

        return $mi;
    }
    public function findMapInformation($id)
    {
        $val = MapInformation::with('diferents')->find($id);

        // $total = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',[$val->type])->where(['lat'=>$val->lat,'lng'=>$val->lng])->orderBy('DATA_SOPRALLUOGO','desc')->get();
        
        // $sinisters = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',[$val->type])->

        // where(function($q) use($val){
        //     $q->where('SOPRALLUOGO','!=',$val->SOPRALLUOGO);
        //     $q->where('SOPRALLUOGO','!=','');
        // })
        // ->where(function($q){
        //     $q->where('DATA_SOPRALLUOGO','');
        //     $q->orWhere('DATA_SOPRALLUOGO',NULL);
        // })
        // ->

        // where(['lat'=>$val->lat,'lng'=>$val->lng])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro')

        // ->get();

        $json = [
            "operation" => "read",
            "idperizia" => (int)$val->N_P,
            "society" => $val->society,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "93.45.47.193:50801/perizia",
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

        $res = json_decode($response,true);

        $idgestore = Expert::where('idp',$res['idgestore'])->where('society',$res['society'])->first();
        $idsopralluogo1 = Expert::where('idp',$res['idsopralluogo1'])->where('society',$res['society'])->first();
        $idsopralluogo2 = Expert::where('idp',$res['idsopralluogo2'])->where('society',$res['society'])->first();
        $stato = State::where('idav',$res['stato'])->first();

        // return [$idgestore,$idsopralluogo1,$idsopralluogo2,$stato,$res];


        $val->AUT = $res['AUT']; // : 0
        $val->VDP = $res['VDP']; // : 0
        $val->DATA_SOPRALLUOGO = $res['dtperizia']; // : ""
        $val->DATA_SOPRALLUOGO_2 = $res['dtperizia2']; // : ""

        $val->PERITO_GESTORE = $idgestore ? $idgestore->name : ""; // : 0

        $val->SOPRALLUOGO = $idsopralluogo1 ? $idsopralluogo1->name : ""; // : 0

        $val->SOPRALLUOGO_2 = $idsopralluogo2 ? $idsopralluogo2->name : ""; // : 0

        $val->society = $res['society']; // : "Z"
        $val->Stato = $stato ? $stato->order : null; // : 14

        $val->save();

        // $val->total = $total->count();
        // $val->sinisters = count($sinisters);
        // $val->diferents = $sinisters;

        return $val;
    }
    public function retrieveRestantes(Request $r)
    {
        return 
        [MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(function($q){
            $q->where(['lat'=>'','lng'=>''])
              ->orWhere(['lat'=>null,'lng'=>null]);
        })->count(),$past = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where('DATA_SOPRALLUOGO','<',Carbon::today())->where('DATA_SOPRALLUOGO','!=','')->count()];
    }
    public function getMapInformation(Request $r)
    {
        session()->forget('perito2');
        $_excel = [];
        if ($r->daassegnare == 'si') {

            session(['perito2' => $r->perito2]);

            $mi = MapInformation::
            whereIn('Stato',['000APERTA','020FISSATO'])->
            where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->orderBy('DATA_SOPRALLUOGO','desc')->

            // where(function($q) use($r){
            //     $q->where('SOPRALLUOGO',$r->perito2)->orWhere('SOPRALLUOGO',"");
            // })



            where(function($q) use($r){
                if ($r->datepicker && $r->datepicker != "") {
                    $dt = Carbon::createFromFormat('d/m/Y',$r->datepicker)->startOfDay();
                    $dtc = $dt->copy()->addDay()->subSecond();

                    $q->where(function($q) use($r,$dt,$dtc){
                        $q->where('SOPRALLUOGO',$r->perito2)->whereBetween('DATA_SOPRALLUOGO',[$dt->format('Y-m-d H:i:s'),$dtc->format('Y-m-d H:i:s')]);
                    })
                    ->orWhere('SOPRALLUOGO',"");

                }else{
                    $q->where('SOPRALLUOGO',$r->perito2)
                    ->orWhere('SOPRALLUOGO',"");
                }
            })

            ->where('INDIRIZZO','!=',"")

            ->with('diferents')

            ->groupBy('lat','lng')->get();

            // foreach ($mi as $key => $val) {
            //     $total = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(['lat'=>$val->lat,'lng'=>$val->lng])->orderBy('DATA_SOPRALLUOGO','desc')->get();
                
            //     $sinisters = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->

            //     where(function($q) use($r){
                    
            //         $q->where(function($q) use($r){
            //             // $q->where('SOPRALLUOGO',$r->perito2)
            //             // ->orWhere('SOPRALLUOGO',"");

            //             if ($r->datepicker && $r->datepicker != "") {
            //                 $dt = Carbon::createFromFormat('d/m/Y',$r->datepicker)->startOfDay();
            //                 $dtc = $dt->copy()->addDay()->subSecond();

            //                 $q->where(function($q) use($r,$dt,$dtc){
            //                     $q->where('SOPRALLUOGO',$r->perito2)->whereBetween('DATA_SOPRALLUOGO',[$dt->format('Y-m-d H:i:s'),$dtc->format('Y-m-d H:i:s')]);
            //                 })
            //                 ->orWhere('SOPRALLUOGO',"");

            //             }else{
            //                 $q->where('SOPRALLUOGO',$r->perito2)
            //                 ->orWhere('SOPRALLUOGO',"");
            //             }
            //         })

            //         ->where(function($q) use($r){
            //             if ($r->datepicker && $r->datepicker != "") {
            //                 $dt = Carbon::createFromFormat('d/m/Y',$r->datepicker)->startOfDay();
            //                 $dtc = $dt->copy()->addDay()->subSecond();
            //                 $q->where('DATA_SOPRALLUOGO','')->orWhereBetween('DATA_SOPRALLUOGO',[$dt->format('Y-m-d H:i:s'),$dtc->format('Y-m-d H:i:s')]);
            //             }
            //         });
            //     })->
            //     where(['lat'=>$val->lat,'lng'=>$val->lng])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro')
            //     ->orderBy('DATA_SOPRALLUOGO','desc')
            //     // ->orderBy('SOPRALLUOGO','desc')
            //     ->get();

            //     $val->total = $total->count();
            //     $val->sinisters = count($sinisters);
            //     $val->diferents = $sinisters;
            // }
        }else if ($r->daassegnare == 'yes') {

            session(['perito2' => $r->perito2]);

            $mi = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->orderBy('DATA_SOPRALLUOGO','desc')->

            // where(function($q) use($r){
            //     $q->where('SOPRALLUOGO',$r->perito2)->orWhere('SOPRALLUOGO',"");
            // })



            where(function($q) use($r){
                if ($r->datepicker && $r->datepicker != "") {
                    $dt = Carbon::createFromFormat('d/m/Y',$r->datepicker)->startOfDay();
                    $dtc = $dt->copy()->addDay()->subSecond();

                    $q->where(function($q) use($r,$dt,$dtc){
                        $q->where('PERITO_GESTORE',$r->perito2)->whereBetween('DATA_SOPRALLUOGO',[$dt->format('Y-m-d H:i:s'),$dtc->format('Y-m-d H:i:s')]);
                    })
                    ->orWhere('PERITO_GESTORE',"");

                }else{
                    $q->where('PERITO_GESTORE',$r->perito2)
                    ->orWhere('PERITO_GESTORE',"");
                }
            })

            ->where('INDIRIZZO','!=',"")

            ->groupBy('lat','lng')->get();

            foreach ($mi as $key => $val) {
                $total = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(['lat'=>$val->lat,'lng'=>$val->lng])->orderBy('DATA_SOPRALLUOGO','desc')->get();
                
                $sinisters = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->

                where(function($q) use($r){
                    
                    $q->where(function($q) use($r){
                        $q->where('PERITO_GESTORE',$r->perito2)
                        ->orWhere('PERITO_GESTORE',"");
                    })

                    ->where(function($q) use($r){
                        if ($r->datepicker && $r->datepicker != "") {
                            $dt = Carbon::createFromFormat('d/m/Y',$r->datepicker)->startOfDay();
                            $dtc = $dt->copy()->addDay()->subSecond();
                            $q->where('DATA_SOPRALLUOGO','')->orWhereBetween('DATA_SOPRALLUOGO',[$dt->format('Y-m-d H:i:s'),$dtc->format('Y-m-d H:i:s')]);
                        }
                    });
                })->
                where(['lat'=>$val->lat,'lng'=>$val->lng])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro')
                ->orderBy('DATA_SOPRALLUOGO','desc')

                ->where('INDIRIZZO','!=',"")
                // ->orderBy('SOPRALLUOGO','desc')
                ->get();

                $val->total = $total->count();
                $val->sinisters = count($sinisters);
                $val->diferents = $sinisters;
            }
        }else{
            if ($r->compagnia || $r->perito || $r->provincia || $r->stato || $r->tp || $r->specific) {

                $mi = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->
                where(function($q) use($r){
                    if ($r->compagnia) {
                        foreach ($r->compagnia as $key => $value) {
                            $q->orWhere('COMPAGNIA','like','%'.$value.'%');
                        }
                    }
                })->
                where(function($q) use($r){
                    if ($r->perito) {
                        if ($r->perito == ['none']) {
                            $q->where('SOPRALLUOGO','');
                        }else{
                            foreach ($r->perito as $key => $value) {
                                $q->orWhere('SOPRALLUOGO','like','%'.$value.'%');
                            }
                        }
                    }
                })->
                /**/
                where(function($q) use($r){
                    if ($r->perito3) {
                        if ($r->perito3 == ['none']) {
                            $q->where('PERITO_GESTORE','');
                        }else{
                            foreach ($r->perito3 as $key => $value) {
                                $q->orWhere('PERITO_GESTORE','like','%'.$value.'%');
                            }
                        }
                    }
                })->
                /**/
                where(function($q) use($r){
                    if ($r->provincia) {
                        foreach ($r->provincia as $key => $value) {
                            $q->orWhere('PROVINCIA','like','%'.$value.'%');
                        }
                    }
                })->
                where(function($q) use($r){
                    if ($r->stato) {
                        if ($r->stato == ['none']) {
                            $q->where('Stato','not like','%FISSATO%');
                        }else{
                            foreach ($r->stato as $key => $value) {
                                $q->orWhere('Stato','like','%'.$value.'%');
                            }
                        }
                    }
                })->
                where(function($q) use($r){
                    if ($r->tp) {
                        foreach ($r->tp as $key => $value) {
                            $q->orWhere('TP','like','%'.$value.'%');
                        }
                    }
                })->
                where(function($q) use($r){
                    if ($r->specific) {
                        $q->where('N_P','like','%'.$r->specific.'%');
                    }
                })
                // ->select('*', DB::raw("count(CONCAT(map_informations.lat,' ',map_informations.lng)) as total"))
                ->with('diferents')

                ->where('INDIRIZZO','!=',"")

                ->groupBy('lat','lng')
                ->orderBy('DATA_SOPRALLUOGO','desc')
                ->get();

            }else{

                if ($r->ignore == 'si') {
                    $mi = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)
                    ->with('diferents')->get();
                }else{
                    $mi = MapInformation::whereIn('Stato',['000APERTA','020FISSATO'])->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->
                    // all();
                    // select('*', DB::raw("count(CONCAT(map_informations.lat,' ',map_informations.lng)) as total"))->
                    with('diferents')->
                    groupBy('lat','lng')
                    ->where('INDIRIZZO','!=',"")
                    ->orderBy('DATA_SOPRALLUOGO','desc')->get();

                }
            }

            if ($r->ignore != 'si') {

                foreach ($mi as $key => $val) {

                //     $total = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(['lat'=>$val->lat,'lng'=>$val->lng])->orderBy('DATA_SOPRALLUOGO','desc')->get();

                //     $sinisters = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->
                //     where(function($q) use($r){
                //         if ($r->compagnia) {
                //             foreach ($r->compagnia as $key => $value) {
                //                 $q->orWhere('COMPAGNIA','like','%'.$value.'%');
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->perito) {
                //             if ($r->perito == ['none']) {
                //                 $q->where('SOPRALLUOGO','');
                //             }else{
                //                 foreach ($r->perito as $key => $value) {
                //                     $q->orWhere('SOPRALLUOGO','like','%'.$value.'%');
                //                 }
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->perito3) {
                //             if ($r->perito3 == ['none']) {
                //                 $q->where('PERITO_GESTORE','');
                //             }else{
                //                 foreach ($r->perito3 as $key => $value) {
                //                     $q->orWhere('PERITO_GESTORE','like','%'.$value.'%');
                //                 }
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->provincia) {
                //             foreach ($r->provincia as $key => $value) {
                //                 $q->orWhere('PROVINCIA','like','%'.$value.'%');
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->stato) {
                //             if ($r->stato == ['none']) {
                //                 $q->where('Stato','not like','%FISSATO%');
                //             }else{
                //                 foreach ($r->stato as $key => $value) {
                //                     $q->orWhere('Stato','like','%'.$value.'%');
                //                 }
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->tp) {
                //             foreach ($r->tp as $key => $value) {
                //                 $q->orWhere('TP','like','%'.$value.'%');
                //             }
                //         }
                //     })->
                //     where(function($q) use($r){
                //         if ($r->specific) {
                //             $q->where('N_P','like','%'.$r->specific.'%');
                //         }
                //     })->
                //     where(['lat'=>$val->lat,'lng'=>$val->lng])
                //     ->select('*', DB::raw('count(N_Sinistro) as total'))
                //     ->groupBy('N_Sinistro')
                //     ->orderBy('DATA_SOPRALLUOGO','desc')
                //     ->get();

                //     $val->total = $total->count();
                //     $val->sinisters = count($sinisters);
                //     $val->diferents = $sinisters;

                    if ($r->excel == 'true') {

                        // for($i=1;$i<count($val->diferents);$i++)
                        // {
                        //         for($j=0;$j<count($val->diferents)-$i;$j++)
                        //         {
                        //                 if($val->diferents[$j]['DATA_SOPRALLUOGO']>$val->diferents[$j+1]['DATA_SOPRALLUOGO'])
                        //                 {$k=$val->diferents[$j+1]; $val->diferents[$j+1]=$val->diferents[$j]; $val->diferents[$j]=$k;}
                        //         }
                        // }

                        foreach ($val->diferents as $key => $_g) {
                            $temp = [];

                            $temp["N.P."] = (int)$val->N_P;
                            $temp["TP"] = $val->TP;
                            $temp["Assicurato"] = $val->Assicurato;
                            $temp["NOME"] = $val->Danneggiato;
                            $temp["COMUNE"] = $val->COMUNE;
                            $temp["CAP"] = (int)$val->CAP;
                            $temp["PROVINCIA"] = $val->PROVINCIA;
                            $temp["INDIRIZZO"] = $val->INDIRIZZO;
                            $temp["TELEFONO"] = $val->TELEFONO;
                            $temp["CELLULARE"] = $val->CELLULARE;
                            $temp["EMAIL"] = $val->EMAIL;
                            $temp["Stato"] = $val->Stato;
                            $temp["DATA_SOPRALLUOGO"] = $val->DATA_SOPRALLUOGO ? Carbon::parse($val->DATA_SOPRALLUOGO)->format('d/m/Y H:i') : "";
                            $temp["PERITO"] = $val->SOPRALLUOGO;
                            $temp["Riserva"] = $val->RISERVA;
                            $temp["N.Sinistro"] = $val->N_Sinistro;
                            $temp["DT Sinistro"] = $val->DT_Sinistro ? Carbon::parse($val->DT_Sinistro)->format('d/m/Y H:i') : "";
                            $temp["DT Incarico"] = $val->DT_Incarico ? Carbon::parse($val->DT_Incarico)->format('d/m/Y H:i') : "";
                            $temp["DT Assegnata"] = $val->DT_ASSEGNATA ? Carbon::parse($val->DT_ASSEGNATA)->format('d/m/Y H:i') : "";
                            $temp["DT Riconsegna"] = $val->DT_CONSEGNA ? Carbon::parse($val->DT_CONSEGNA)->format('d/m/Y H:i') : "";
                            $temp["COMPAGNIA"] = $val->COMPAGNIA;
                            $temp["AGENZIA"] = $val->AGENZIA;

                            $_excel[] = $temp;
                        }
                    }
                }
            }
        }
        if ($r->excel == 'true') {

            $filename = 'Mappa Filtro - '.Carbon::now()->format('d-m-Y H:i:s');

            $ex = Excel::create($filename, function($excel) use($_excel) {

                $excel->sheet('1', function($sheet) use($_excel) {

                    $sheet->setColumnFormat(array(
                        "M" => "dd/mm/yyyy H:mm",
                        "Q" => "dd/mm/yyyy H:mm",
                        "R" => "dd/mm/yyyy H:mm",
                        "S" => "dd/mm/yyyy H:mm",
                        "T" => "dd/mm/yyyy H:mm",
                    ));

                    $sheet->fromArray($_excel);

                });

            })->store('csv', public_path('maps/exports'));

            $t = fopen(public_path('maps/exports').'/'.$filename.'.csv', "r");
            $read = fread($t,filesize(public_path('maps/exports').'/'.$filename.'.csv'));

            $w = fopen(public_path('maps/exports').'/'.$filename.'.csv', "w");
            fwrite($w, "sep=,\n".$read);
            fclose($w);

            return [url('maps/exports/',$filename.'.csv')];
        }else{
            $e = (ExcelFile::orderBy('id','desc')->first() ? ExcelFile::orderBy('id','desc')->first() : ["name"=>"","updated_at"=>Carbon::now()]);
            return [$e,$mi];
        }
    }

    public function exportExcel(Request $r)
    {
        $_excel = [];
        $file = "Mappa Filtro - ";

        if ($r->ids) {
            $r->collection = explode(",",$r->ids);
        }

        if ($r->collection) {
            $data = [];
            foreach ($r->collection as $key => $value) {
                $val = MapInformation::find($value);
                $data[] = $val;
            }

            for($i=1;$i<count($data);$i++)
            {
                for($j=0;$j<count($data)-$i;$j++)
                {
                        if($data[$j]["DATA_SOPRALLUOGO"]>$data[$j+1]["DATA_SOPRALLUOGO"])
                        {$k=$data[$j+1]; $data[$j+1]=$data[$j]; $data[$j]=$k;}
                }
            }

            foreach ($data as $key => $val) {
                $temp = [];

                $temp["N.P."] = (int)$val->N_P;
                $temp["TP"] = $val->TP;
                $temp["Assicurato"] = $val->Assicurato;
                $temp["NOME"] = $val->Danneggiato;
                $temp["COMUNE"] = $val->COMUNE;
                $temp["CAP"] = (int)$val->CAP;
                $temp["PROVINCIA"] = $val->PROVINCIA;
                $temp["INDIRIZZO"] = $val->INDIRIZZO;
                $temp["TELEFONO"] = $val->TELEFONO;
                $temp["CELLULARE"] = $val->CELLULARE;
                $temp["EMAIL"] = $val->EMAIL;
                $temp["Stato"] = $val->Stato;
                $temp["DATA_SOPRALLUOGO"] = $val->DATA_SOPRALLUOGO ? Carbon::parse($val->DATA_SOPRALLUOGO)->format('d/m/Y H:i') : "";
                if ($r->_type && $r->_type == 'gestion') {
                    $temp["PERITO_GESTORE"] = $val->PERITO_GESTORE;
                    $temp["SOPRALLUOGHISTA"] = $val->SOPRALLUOGO;
                }else{
                    $temp["PERITO"] = $val->SOPRALLUOGO;
                }
                $temp["Riserva"] = $val->RISERVA;
                $temp["N.Sinistro"] = $val->N_Sinistro;
                $temp["DT Sinistro"] = $val->DT_Sinistro ? Carbon::parse($val->DT_Sinistro)->format('d/m/Y H:i') : "";
                $temp["DT Incarico"] = $val->DT_Incarico ? Carbon::parse($val->DT_Incarico)->format('d/m/Y H:i') : "";
                $temp["DT Assegnata"] = $val->DT_ASSEGNATA ? Carbon::parse($val->DT_ASSEGNATA)->format('d/m/Y H:i') : "";
                $temp["DT Riconsegna"] = $val->DT_CONSEGNA ? Carbon::parse($val->DT_CONSEGNA)->format('d/m/Y H:i') : "";
                $temp["COMPAGNIA"] = $val->COMPAGNIA;
                $temp["AGENZIA"] = $val->AGENZIA;

                $_excel[] = $temp;
            }
        }else{

            if ($r->type == 'without') {
                $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where(function($q){
                    $q->where(['lat'=>'','lng'=>''])
                      ->orWhere(['lat'=>null,'lng'=>null]);
                })->orderBy('DATA_SOPRALLUOGO','asc')->get();
                $file = "Mappa sem posizione - ";
            }else if($r->type == 'past'){
                $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->where('DATA_SOPRALLUOGO','<',Carbon::today())->where('DATA_SOPRALLUOGO','!=','')->get();
                $file = "Mappa già effettuato - ";
            }

            if ($mi) {
                foreach ($mi as $key => $val) {

                    $temp = [];

                    $temp["N.P."] = (int)$val->N_P;
                    $temp["TP"] = $val->TP;
                    $temp["Assicurato"] = $val->Assicurato;
                    $temp["NOME"] = $val->Danneggiato;
                    $temp["COMUNE"] = $val->COMUNE;
                    $temp["CAP"] = (int)$val->CAP;
                    $temp["PROVINCIA"] = $val->PROVINCIA;
                    $temp["INDIRIZZO"] = $val->INDIRIZZO;
                    $temp["TELEFONO"] = $val->TELEFONO;
                    $temp["CELLULARE"] = $val->CELLULARE;
                    $temp["EMAIL"] = $val->EMAIL;
                    $temp["Stato"] = $val->Stato;
                    $temp["DATA_SOPRALLUOGO"] = $val->DATA_SOPRALLUOGO ? Carbon::parse($val->DATA_SOPRALLUOGO)->format('d/m/Y H:i') : "";
                    if ($r->_type && $r->_type == 'gestion') {
                        $temp["PERITO_GESTORE"] = $val->PERITO_GESTORE;
                        $temp["SOPRALLUOGHISTA"] = $val->SOPRALLUOGO;
                    }else{
                        $temp["PERITO"] = $val->SOPRALLUOGO;
                    }
                    $temp["Riserva"] = $val->RISERVA;
                    $temp["N.Sinistro"] = $val->N_Sinistro;
                    $temp["DT Sinistro"] = $val->DT_Sinistro ? Carbon::parse($val->DT_Sinistro)->format('d/m/Y H:i') : "";
                    $temp["DT Incarico"] = $val->DT_Incarico ? Carbon::parse($val->DT_Incarico)->format('d/m/Y H:i') : "";
                    $temp["DT Assegnata"] = $val->DT_ASSEGNATA ? Carbon::parse($val->DT_ASSEGNATA)->format('d/m/Y H:i') : "";
                    $temp["DT Riconsegna"] = $val->DT_CONSEGNA ? Carbon::parse($val->DT_CONSEGNA)->format('d/m/Y H:i') : "";
                    $temp["COMPAGNIA"] = $val->COMPAGNIA;
                    $temp["AGENZIA"] = $val->AGENZIA;

                    $_excel[] = $temp;
                }
            }
        }

        $filename = $file.Carbon::now()->format('d-m-Y H:i:s');
        $format = [];

        if ($r->_type && $r->_type == 'gestion') {
            $format = [
                    "M" => "dd/mm/yyyy H:mm",
                    "R" => "dd/mm/yyyy H:mm",
                    "S" => "dd/mm/yyyy H:mm",
                    "T" => "dd/mm/yyyy H:mm",
                    "U" => "dd/mm/yyyy H:mm",
                ];
        }else{
            $format = [
                    "M" => "dd/mm/yyyy H:mm",
                    "Q" => "dd/mm/yyyy H:mm",
                    "R" => "dd/mm/yyyy H:mm",
                    "S" => "dd/mm/yyyy H:mm",
                    "T" => "dd/mm/yyyy H:mm",
                ];
        }

        $ex = Excel::create($filename, function($excel) use($_excel,$format) {

            $excel->sheet('1', function($sheet) use($_excel,$format) {

                $sheet->setColumnFormat($format);

                $sheet->rows($_excel,true);

                $sheet->fromArray($_excel);

            });

        })->store('csv', public_path('maps/exports'));

        $t = fopen(public_path('maps/exports').'/'.$filename.'.csv', "r");
        $read = fread($t,filesize(public_path('maps/exports').'/'.$filename.'.csv'));

        $w = fopen(public_path('maps/exports').'/'.$filename.'.csv', "w");
        fwrite($w, "sep=,\n".$read);
        fclose($w);

        return [url('maps/exports/',$filename.'.csv')];
    }

    public function multipleModal(Request $r)
    {
        $m = MapInformation::find($r->N_Sinistro);

        $N_Sinistro = $m->N_Sinistro;
        $damaged = MapInformation::
        whereIn('Stato',['000APERTA','020FISSATO'])
        ->where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->
        where(function($q) use($r){
            if ($r->compagnia) {
                foreach ($r->compagnia as $key => $value) {
                    $q->orWhere('COMPAGNIA','like','%'.$value.'%');
                }
            }
        })->
        where(function($q) use($r){
            if ($r->perito) {
                if ($r->perito == ['none']) {
                    $q->where('SOPRALLUOGO','');
                }else{
                    foreach ($r->perito as $key => $value) {
                        $q->orWhere('SOPRALLUOGO','like','%'.$value.'%');
                    }
                }
            }
        })->
        /**/
        where(function($q) use($r){
            if ($r->perito3) {
                if ($r->perito3 == ['none']) {
                    $q->where('PERITO_GESTORE','');
                }else{
                    foreach ($r->perito3 as $key => $value) {
                        $q->orWhere('PERITO_GESTORE','like','%'.$value.'%');
                    }
                }
            }
        })->
        /**/
        where(function($q) use($r){
            if ($r->provincia) {
                foreach ($r->provincia as $key => $value) {
                    $q->orWhere('PROVINCIA','like','%'.$value.'%');
                }
            }
        })->
        where(function($q) use($r){
            if ($r->stato) {
                if ($r->stato == ['none']) {
                    $q->where('Stato','not like','%FISSATO%');
                }else{
                    foreach ($r->stato as $key => $value) {
                        $q->orWhere('Stato','like','%'.$value.'%');
                    }
                }
            }
        })->
        where(function($q) use($r){
            if ($r->tp) {
                foreach ($r->tp as $key => $value) {
                    $q->orWhere('TP','like','%'.$value.'%');
                }
            }
        })->
        where("N_Sinistro",$N_Sinistro)->get();

        return view('admin.allDamaged',compact('damaged'))->render();
    }

    public function dataModal($id)
    {
        $data = MapInformation::find($id);
        // $statos = State::where('order',$data->Stato)->get();
        $statos = State::where('idav','<',30)->where('idav','!=',19)->get();
        $peritos = Expert::where('society',$data->society)->get();
        $gestore = Expert::where('society',$data->society)->get();

        return [view('admin.allData',compact('data','statos','peritos','gestore'))->render(), " - ".$data->N_P." | ".($data->society == "Z" ? "Studio Zappa" : "Renova")];
    }


    public function deleteSms($id)
    {
        $s = SMS::find($id);
        $s->delete();
        return back();
    }
    public function index()
    {
    	return redirect('admin/requests');
    	// return view('admin.index');
    }
    public function expressTechClose($id)
    {
        $c = Claim::find($id);
        $c->status = 2;
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

        $this->curlClose($json);

        return back();
    }

    public function curlClose($json)
    {
        sleep ( 2 );
        
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "93.45.47.193:50801/perizia",
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

        // echo $response;

        $res = json_decode($response,true);
    }

    public function expressTech()
    {
        return view('admin.express-tech');
    }
    public function expressTechChiusi()
    {
        return view('admin.express-tech-chiusi');
    }
    public function expressTechMediaView($id, Request $r)
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

                $i = ClaimFile::whereIn('sin_number',$ids)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
                $v = ClaimFile::whereIn('sin_number',$ids)->where('type','video')->get();
                $a = ClaimFile::whereIn('sin_number',$ids)->where('type','audio')->get();
            }else{
                $i = ClaimFile::where('sin_number',$s->sin_number)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
                $v = ClaimFile::where('sin_number',$s->sin_number)->where('type','video')->get();
                $a = ClaimFile::where('sin_number',$s->sin_number)->where('type','audio')->get();
            }
            $sin_number = $id;


            foreach ($i as $key => $_i) {
                $path = public_path().'/uploads/operator/'.$_i->user_id.'/'.$_i->sin_number.'/images/';
                if (file_exists($path.$_i->file)) {

                    // if (!file_exists($path.'t_'.$_i->file)) {
                        $img = _Image::make($path.$_i->file);

                        $img->resize(200,null,function($c){
                            $c->aspectRatio();
                        });
                        $img->save($path.'t_'.$_i->file);
                    // }
                }
            }

            $society = strtolower($s->society);

            $r->session()->forget('hour');

            return view('admin.express-media',compact('i','v','a','sin_number','society','s'));
        }

        return redirect('/');
    }

    public function reloadAll($id)
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

                $i = ClaimFile::whereIn('sin_number',$ids)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
            }else{
                $i = ClaimFile::where('sin_number',$s->sin_number)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
            }
            $sin_number = $id;

            return view('admin.template-images',compact('i','sin_number'));
        }
    }

    public function expressTechMediaView2($id)
    {
        $s = Claim::where('sin_number',$id)->first();

        if ($s) {
            if ($s->claim_id == -1) {
                $ids = [$s->sin_number];

                $claims = Claim::where('claim_id',$s->id)->get();

                foreach ($claims as $key => $claim) {
                    $ids[] = $claim->sin_number;
                }

                $i = ClaimFile::whereIn('sin_number',$ids)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
                $v = ClaimFile::whereIn('sin_number',$ids)->where('type','video')->get();
                $a = ClaimFile::whereIn('sin_number',$ids)->where('type','audio')->get();
            }else{
                $i = ClaimFile::where('sin_number',$s->sin_number)->where('type','image')/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
                $v = ClaimFile::where('sin_number',$s->sin_number)->where('type','video')->get();
                $a = ClaimFile::where('sin_number',$s->sin_number)->where('type','audio')->get();
            }
            $sin_number = $id;


            foreach ($i as $key => $_i) {
                $path = public_path().'/uploads/operator/'.$_i->user_id.'/'.$_i->sin_number.'/images/';
                if (file_exists($path.$_i->file)) {

                    if (!file_exists($path.'t_'.$_i->file)) {
                        $img = _Image::make($path.$_i->file);

                        $img->resize(200,null,function($c){
                            $c->aspectRatio();
                        });
                        $img->save($path.'t_'.$_i->file);
                    }
                }
            }

            $society = strtolower($s->society);

            return view('admin.out-media',compact('i','v','a','sin_number','society','s'));
        }

        return "NON vi sono fotografie scattate con Express Tech.";
    }

    public function videoperiziaMediaView2($id)
    {
        $res = Reservation::where('sin_number',$id)->first();
        if (!$res) {
            return "NON vi sono fotografie scattate con Express Claims.";
        }
        $name = User::find($res->customer_id)->name;
        // $i = File::where('reservation_id',$id)->get();
        $i = Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$res->id])
        // ->orderBy('type','desc')->orderBy('id','desc')
        ->orderBy('order','asc')->get();
        $reservation_id = $id;

        foreach ($i as $key => $_i) {

            $res = Reservation::find($_i->reservation_id);

            $path = public_path().'/uploads/users/'.$_i->user_id.'/'.$res->sin_number.'/images/';
            if (file_exists($path.$_i->imagen)) {

                if (!file_exists($path.'t_'.$_i->imagen)) {
                    $img = _Image::make($path.$_i->imagen);
                    $img->resize(200,null,function($c){
                        $c->aspectRatio();
                    });
                    $img->save($path.'t_'.$_i->imagen);
                }
            }

        }

        return view('admin.out-images',compact('i','name','res','reservation_id'));
    }

    public function deleteClaimFile($id)
    {
        $cf = ClaimFile::find($id);
        $path = public_path().'/uploads/operator/'.$cf->user_id.'/'.$cf->sin_number.'/images/';
        @unlink($path.'/'.$cf->file);
        @unlink($path.'/t_'.$cf->file);
        $cf->delete();

        return back();
    }

    public function deleteFile($id)
    {
        $cf = Image::find($id);
        $res = Reservation::find($cf->reservation_id);
        $path = public_path().'/uploads/users/'.$cf->user_id.'/'.$res->sin_number.'/images/';
        @unlink($path.'/'.$cf->file);
        @unlink($path.'/t_'.$cf->file);
        $cf->delete();

        return back();
    }

    public function expressTechExportFull(Request $r)
    {
        $claim = Claim::where('sin_number',$r->sin_number)->first();

        if (isset($r->empresa)) {
            $logo = $r->empresa.'.png';
        }else{
            $logo = strtolower($claim->society).'.png';
        }


        $files = ClaimFile::find($r->ids);

        // for($i=1;$i<count($files);$i++)
        // {
        //     for($j=0;$j<count($files)-$i;$j++)
        //     {
        //         if($files[$j]->order>$files[$j+1]->order)
        //         {
        //             $k=$files[$j+1];
        //             $files[$j+1]=$files[$j];
        //             $files[$j]=$k;
        //         }
        //     }
        // }

        $pdf = PDF::loadView('admin.express-tech-pdf-full',compact('files','logo'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('foto '.$r->sin_number.'.pdf');
    }

    public function setHour($h, Request $r)
    {
        if ($h == '0') {
            $r->session()->forget('hour');
        }else{
            $r->session()->put('hour', '1');
        }

        return session('hour');
    }

    public function expressTechExport(Request $r)
    {
        $location = $r->location;
        $claim = Claim::where('sin_number',$r->sin_number)->first();

        if (isset($r->empresa)) {
            $logo = $r->empresa.'.png';
        }else{
            $logo = strtolower($claim->society).'.png';
        }

        // $files = [];

        $files = ClaimFile::whereIn('id',$r->ids)->orderBy('order','asc')->get();

        // for($i=1;$i<count($files);$i++)
        // {
        //     for($j=0;$j<count($files)-$i;$j++)
        //     {
        //         if($files[$j]->order>$files[$j+1]->order)
        //         {
        //             $k=$files[$j+1];
        //             $files[$j+1]=$files[$j];
        //             $files[$j]=$k;
        //         }
        //     }
        // }

        // foreach ($_files as $key => $value) {
        //     $files[] = $value;
        // }

        // foreach ($_files as $key => $value) {
        //     $files[] = $value;
        // }

        // return view('admin.express-tech-pdf',compact('files'));
        $pdf = PDF::loadView('admin.express-tech-pdf',compact('files','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('foto '.$r->sin_number.'.pdf');
    }

    public function changeOrder(Request $r)
    {
        $a = 0;
        foreach ($r->ids as $key => $id) {
            $c = ClaimFile::find($id);
            $c->order = $a;
            $c->save();

            $a++;
        }
        return $r->all();
    }

    public function changeOrderClaims(Request $r)
    {
        $a = 0;
        foreach ($r->ids as $key => $id) {
            $c = Image::find($id);
            $c->order = $a;
            $c->save();

            $a++;
        }
        return $r->all();
    }

    public function changeName(Request $r)
    {
        $c = Claim::find($r->id);

        $info = json_decode($c->information,true);

        $info['typology'] = $r->typology;

        $c->information = json_encode($info);

        $c->save();
    }

    public function expressTechExportAll($sin_number,$location = null,$empresa = null)
    {
        $claim = Claim::where('sin_number',$sin_number)->first();

        if (isset($empresa)) {
            $logo = $empresa.'.png';
        }else{
            $logo = strtolower($claim->society).'.png';
        }

        if ($claim->claim_id == -1) {
            $ids = [$claim->sin_number];

            $claims = Claim::where('claim_id',$claim->id)->get();

            foreach ($claims as $key => $claim) {
                $ids[] = $claim->sin_number;
            }
            $files = ClaimFile::whereIn('sin_number',$ids)/*->orderBy('id','asc')*/->orderBy('order','asc')->get();

        }else{
            $files = ClaimFile::where('sin_number',$sin_number)/*->orderBy('id','asc')*/->orderBy('order','asc')->get();
        }

        /*for($i=1;$i<count($files);$i++)
        {
            for($j=0;$j<count($files)-$i;$j++)
            {
                if($files[$j]->order>$files[$j+1]->order)
                {
                    $k=$files[$j+1];
                    $files[$j+1]=$files[$j];
                    $files[$j]=$k;
                }
            }
        }*/
        // return view('admin.express-tech-pdf',compact('files'));
        $pdf = PDF::loadView('admin.express-tech-pdf',compact('files','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('foto '.$sin_number.'.pdf');
    }

    public function expressClaimsExport(Request $r)
    {
        $location = $r->location;
        $files = Image::whereIn('id',$r->ids)->orderBy('order','asc')->get();
        $sin_number = Reservation::find($r->reservation_id)->sin_number;

        // $claim = Claim::where('sin_number',$sin_number)->first();

        $logo = strtolower($r->empresa).'.png';
        
        // return view('admin.express-claims-pdf',compact('files','sin_number','logo'));
        $pdf = PDF::loadView('admin.express-claims-pdf',compact('files','sin_number','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function expressClaimsExportFull(Request $r)
    {
        $files = Image::whereIn('id',$r->ids)->orderBy('order','asc')->get();
        $sin_number = Reservation::find($r->reservation_id)->sin_number;

        // $claim = Claim::where('sin_number',$sin_number)->first();

        $logo = strtolower($r->empresa).'.png';
        
        // return view('admin.express-claims-pdf-full',compact('files','sin_number','logo'));
        $pdf = PDF::loadView('admin.express-claims-pdf-full',compact('files','sin_number','logo'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function expressClaimsExportAll(Request $r, $id)
    {
        $location = $r->location;
        $files = Image::where('reservation_id',$id)->orderBy('order','asc')->get();
        $sin_number = Reservation::find($id)->sin_number;

        // $claim = Claim::where('sin_number',$sin_number)->first();

        $logo = strtolower($r->empresa).'.png';
        
        // return view('admin.express-claims-pdf',compact('files','sin_number','logo'));
        $pdf = PDF::loadView('admin.express-claims-pdf',compact('files','sin_number','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function expressClaimsZip($id)
    {
        $z = new ZipArchive;

        $files = Image::where('reservation_id',$id)->orderBy('order','asc')->get();
        $res = Reservation::find($id);

        $u = User::find($res->customer_id);

        $n = $u->name." - ".Carbon::now()->format("d-m-Y h_i_s").".zip";

        if ($z->open(public_path().'/'.$n, ZipArchive::CREATE) === TRUE) {
            // Add File in ZipArchive
            foreach ($files as $key => $f) {
                $z->addFile(public_path().'/uploads/users/'.$f->user_id.'/'.$res->sin_number.'/images/'.$f->imagen,$f->imagen);
            }
            // Close ZipArchive     
            $z->close();
        }
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $p=public_path().'/'.$n;
        // Create Download Response
        if(file_exists($p)){
            return response()->download($p,$n,$headers);
        }
    }


    public function autoperiziaExport(Request $r)
    {
        $location = $r->location;
        
        $files = SelfManagementImage::whereIn('id',$r->ids)->get();

        $sin_number = $r->sin_number;

        $logo = strtolower($r->empresa).'.png';
        
        $pdf = PDF::loadView('admin.autoperizia-pdf.autoperizia-pdf',compact('files','sin_number','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function autoperiziaExportFull(Request $r)
    {
        $files = SelfManagementImage::whereIn('id',$r->ids)->get();
        $sin_number = $r->sin_number;

        $logo = strtolower($r->empresa).'.png';
        
        $pdf = PDF::loadView('admin.autoperizia-pdf.autoperizia-pdf-full',compact('files','sin_number','logo'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function autoperiziaExportAll(Request $r, $id)
    {
        $location = $r->location;
        $files = SelfManagementImage::where('self_management_id',$id)->get();
        $sin_number = $r->sin_number;

        $logo = strtolower($r->empresa).'.png';
        
        $pdf = PDF::loadView('admin.autoperizia-pdf.autoperizia-pdf',compact('files','sin_number','logo','location'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }
    public function autoperiziaZip($id)
    {
        $z = new ZipArchive;

        $files = SelfManagementImage::where('self_management_id',$id)->get();
        $res = Reservation::where('customer_id',SelfManagement::find($id)->user_id)->first();

        $u = User::find($res->customer_id);

        $n = $u->name." - Autoperizia - ".Carbon::now()->format("d-m-Y h_i_s").".zip";

        if ($z->open(public_path().'/'.$n, ZipArchive::CREATE) === TRUE) {
            // Add File in ZipArchive
            foreach ($files as $key => $f) {
                $z->addFile(public_path().'/uploads/autoperizia/'.$f->image,$f->image);
            }
            // Close ZipArchive     
            $z->close();
        }
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $p=public_path().'/'.$n;
        // Create Download Response
        if(file_exists($p)){
            return response()->download($p,$n,$headers);
        }
    }






















    public function expressTechZip($id)
    {
        $z = new ZipArchive;

        $c = Claim::where('sin_number',$id)->first();
        if ($c) {
            if ($c->claim_id == -1) {
                $ids = [];

                $claims = Claim::where('claim_id',$c->id)->get();

                foreach ($claims as $key => $claim) {
                    $ids[] = $claim->sin_number;
                }

                $files = ClaimFile::whereIn('sin_number',$ids)->where('type','image')->orderBy('order','asc')->get();
            }else{
                $files = ClaimFile::where('sin_number',$c->sin_number)->where('type','image')->orderBy('order','asc')->get();
            }

            $n = $c->sin_number." - ".Carbon::now()->format("d-m-Y h_i_s").".zip";

            if ($z->open(public_path().'/'.$n, ZipArchive::CREATE) === TRUE) {
                // Add File in ZipArchive
                foreach ($files as $key => $f) {
                    $z->addFile(public_path().'/uploads/operator/'.$f->user_id.'/'.$f->sin_number.'/images/'.$f->file,$f->file);
                }
                // Close ZipArchive     
                $z->close();
            }
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            $p=public_path().'/'.$n;
            // Create Download Response
            if(file_exists($p)){
                return response()->download($p,$n,$headers);
            }
        }
    }
    public function push()
    {
    	return view('admin.push');
    }
    public function my_customers()
    {
        return view('admin.my-customers');
    }
    public function view_customer($id)
    {
        $u = User::find($id);
        // $m = Message::where(function($q) use($id) {
        //     $q->where('from_id',$id)->where('to_id',Auth::user()->id);
        // })->orWhere(function($q) use($id) {
        //     $q->where('from_id',Auth::user()->id)->where('to_id',$id);
        // })
        // ->with('from','to')->paginate(10);

        // $i = Image::where('user_id',$id)->get();
        // $m = [];
        // $u = [];
        // $i = [];
        return view('admin.detail',compact('u'/*,'m','i'*/));
    }
    public function send_push(Request $r)
    {
    	$this->validate($r,[
    		'title' => 'required',
    		'message' => 'required',
    	]);
    	$ids = [];
    	$content = [
            "en" => $r->message
        ];
        $heading = array(
            "en" => $r->title
        );
    	if (!$r->all) {
    		if (!$r->send) {
    			return Response::json(['Select at least 1 user to send push'],422);
    		}
	    	foreach (Customer::whereIn('id',$r->send)->select('device_id')->get() as $key => $value) {
	    		$ids[] = $value->device_id;
	    	}
	    	$fields = [
	            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111",
	            'include_player_ids' => $ids,
	            'contents' => $content,
	            'headings' => $heading
	        ];
    	}else{
    		$ids[] = 'All';

    		$fields = [
	            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111",
	            'included_segments' => $ids,
	            'contents' => $content,
	            'headings' => $heading
	        ];
    	}
        
        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
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
        
        $p = new Push;
        $p->title = $r->title;
        $p->message = $r->message;
        $p->to = json_encode($ids);
        $p->save();

        return $response;
    }

    // public function send_msg_notification(Request $r)
    public function send_msg_notification($device_id,$sin_number)
    {
        $content = [
            "en" => 'Ti è stato assegnato il nuovo incarico n.: '.$sin_number
        ];
        $heading = array(
            "en" => 'Express Tech'
        );

        $fields = [
            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111",
            'include_player_ids' => [$device_id],
            'contents' => $content,
            'headings' => $heading
        ];

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
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
    }

    public function send_call_notification(Request $r)
    {
        $c = Customer::where('user_id',$r->id)->first();

        $content = [
            "en" => "Chiamata in arrivo: apri l'applicazione per vedere i dettagli..."
        ];
        $heading = array(
            "en" => 'Express Claims'
        );

        $fields = [
            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111",
            'include_player_ids' => [$c->device_id],
            'contents' => $content,
            'headings' => $heading
        ];

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
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

        return $response;
    }
    public function sms()
    {
        $pred = Predefined::all();
    	return view('admin.sms',compact('pred'));
    }

    public function send_sms(Request $r)
    {
    	$this->validate($r,[
    		'number' => 'required',
    		'message' => 'required',
    	]);

        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);

        $twilio_number = "EXPclaims";
        // $twilio_number = getenv("TWILIO_NUMBER");
        $message = $client->messages->create("+".$r->code.$r->number, 
                ['from' => $twilio_number, 'body' => $r->message]);

        if ($r->data_reminder) {
            $u = User::find($r->user_id);

            if ($u) {
                $sm = SelfManagement::where('user_id',$u->id)->first();
                if ($sm) {
                    $sm->data_reminder = Carbon::now()->format('d-m-Y H:i:s');
                    $sm->save();
                }
            }
        }

        // return $message->sid;

    	/*$xml = '<?xml version="1.0" encoding="UTF-8"?>
	    <sms>
	      <recipient>
	        <msisdn>'.$r->code.$r->number.'</msisdn>
	      </recipient>
	      <message>'.$r->message.'</message>
	      <tpoa>EXPclaims</tpoa>
	    </sms>';

    	$p = SMSPassword::first();

        if ($p) {
            $password = $p->password;
        }else{
            $password = '';
        }
        
        $ch = curl_init('http://api.labsmobile.com/clients/');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'giorgio.zappa@studiozappa.com'.':'.$password);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'XmlData='.$xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$result = curl_exec($ch);*/

		$p = new SMS;
        $p->to = $r->code.$r->number;
        $p->message = $r->message;
        $p->save();

		return json_encode($message->sid);
    }

    public function requests()
    {
        return view('admin.requests');
    }
    public function historial()
    {
        return view('admin.history');
    }
    public function sinister()
    {
        $res = Reservation::where('status',0)->with('user','user.webapp')->get();

        foreach ($res as $key => $value) {
            $diff = Carbon::parse($value->made)->diffInDays(Carbon::today());
            if ($diff > 14) {
                $value->status = 1;
                $value->save();
            }
        }

        return view('admin.sinister');
    }

    public function allSinister()
    {
        $res = Reservation::where('status',0)->with('user','user.webapp')->get();

        foreach ($res as $key => $value) {
            $diff = Carbon::parse($value->made)->diffInDays(Carbon::today());
            if ($diff > 14) {
                $value->status = 1;
                $value->save();
            }
        }

        return view('admin.sinister',['all'=>true]);
    }

    public function link_user(Request $r, $id)
    {
        $c = Customer::where('user_id',$id)->first();
        $c->operator_id = $r->operator_id;
        $c->save();

        $device_id = $c->device_id;

        $content = [
            "en" => "Ora puoi scrivere all'operatore ".Auth::user()->name
        ];
        $heading = array(
            "en" => "Richiesta accettata"
        );
        
        $ids[] = 'All';

        $fields = [
            'app_id' => "18f7db09-4143-4d1f-a828-a4e2124cb111",
            'include_player_ids' => [$device_id],
            'contents' => $content,
            'headings' => $heading
        ];
        
        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
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

        $other = Reservation::where('sin_number',$r->sin_number)->where('customer_id','!=',$id)->first();
        if ($other) {
            return response()->json('Il numero di sinistro è già in uso',422);
        }
        
        $s = new Reservation;
        $s->message = "";
        $s->sin_number = $r->sin_number;
        $s->customer_id = $id;
        $s->status = 0;
        $s->save();
        $s->made = $s->created_at;
        $s->save();

        return back();
    }

    public function save_sinister(Request $r)
    {
        $s = Reservation::find($r->sinister_id);
        $s->sin_number = $r->sin_number;
        $s->save();

        return back();
    }

    public function create_sinister(Request $r)
    {
        $other = Reservation::where('sin_number',$r->sin_number)->where('customer_id','!=',$r->user_id)->first();
        if ($other) {
            return response()->json('Il numero di sinistro è già in uso',422);
        }
            $s = new Reservation;
            $s->message = "";
            $s->sin_number = $r->sin_number;
            $s->customer_id = $r->user_id;
            $s->status = 0;
            $s->save();
            $s->made = $s->created_at;
            $s->save();

        return back();
    }

    public function deleteSinister($id)
    {
        Reservation::find($id)->delete();
        Record::where('reservation_id',$id)->delete();
        Image::where('reservation_id',$id)->delete();
        Video::where('reservation_id',$id)->delete();

        return back();
    }

    public function edit_sinister(Request $r)
    {
        $other = Reservation::where('sin_number',$r->sin_number)->where('customer_id','!=',$r->user_id)->first();
        if ($other) {
            return response()->json('Il numero di sinistro è già in uso',422);
        }
            $s = Reservation::find($r->id);
            $s->sin_number = $r->sin_number;
            $s->save();

        return back();
    }

    public function change_can_call(Request $r)
    {
        $c = Customer::where('user_id',$r->id)->first();
        if ($c->can_call == 1) {
            $c->can_call = 0;
        }else{
            $c->can_call = 1;
        }
        $c->save();
    }
    public function videos($id){
        $res = Reservation::find($id);
        if (!$res) {
            return back();
        }
        $name = User::find($res->customer_id)->name;
        // $v = Video::where('reservation_id',$id)->get();
        $v = Video::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])->orderBy('id','desc')->get();
        $rc = Record::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])->orderBy('id','desc')->get();
        return view('admin.videos',compact('v','name','res','rc'));
    }
    public function images($id){
        $res = Reservation::find($id);
        if (!$res) {
            return back();
        }
        $name = User::find($res->customer_id)->name;
        // $i = File::where('reservation_id',$id)->get();
        $i = Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])
        // ->orderBy('type','desc')->orderBy('id','desc')
        ->orderBy('order','asc')->get();
        $reservation_id = $id;

        foreach ($i as $key => $_i) {

            $res = Reservation::find($_i->reservation_id);

            $path = public_path().'/uploads/users/'.$_i->user_id.'/'.$res->sin_number.'/images/';
            if (file_exists($path.$_i->imagen)) {

                if (!file_exists($path.'t_'.$_i->imagen)) {
                    $img = _Image::make($path.$_i->imagen);
                    $img->resize(200,null,function($c){
                        $c->aspectRatio();
                    });
                    $img->save($path.'t_'.$_i->imagen);
                }
            }

        }

        return view('admin.images',compact('i','name','res','reservation_id'));
    }

    public function videosU($sha1,$id){
        $res = Reservation::find($id);
        if (!$res) {
            return back();
        }
        $u = User::find($res->customer_id);
        $name = $u->name;
        if ($sha1 != sha1($id.$u->email)) {
            return back();
        }
        // $v = Video::where('reservation_id',$id)->get();
        $rc = Record::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])->get();
        $v = Video::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])->get();
        return view('videos',compact('v','name','res','rc'));
    }
    public function imagesU($sha1,$id){
        $res = Reservation::find($id);
        if (!$res) {
            return back();
        }
        $u = User::find($res->customer_id);
        $name = $u->name;
        if ($sha1 != sha1($id.$u->email)) {
            return back();
        }
        // $i = File::where('reservation_id',$id)->get();
        $i = Image::where(['user_id'=>$res->customer_id,'reservation_id'=>$id])->get();
        return view('images',compact('i','name','res'));
    }

    public function uploadVideo(Request $r)
    {
        $u = User::find($r->user_id);

        $res = Reservation::where('customer_id',$u->id)->where('status',0)->first();

        $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d_m_Y-h_i_s').'.mp4';

        $rec = new Record;
        $rec->user_id = $r->user_id;
        $rec->duration = "0:00";
        // $rec->size = $r->size;
        // $rec->name = $name;
        $rec->name = $name;
        $rec->remote_url = $r->remote_url;

        $rec->address = $r->address;
        $rec->lat = $r->lat;
        $rec->lon = $r->lon;
        $rec->reservation_id = $res->id;

        $rec->save();

        return $rec;

        // $records = Record::where(['user_id'=>$r->user_id,'reservation_id'=>$res->id])->with('user')->get();

        // foreach ($records as $key => $value) {
        //     $value->created = $value->created_at->format('d-m-Y H:i:s');
        // }

        // return [$records, url('uploads/videos')];
    }

    public function saveDuration(Request $r)
    {
        $rec = Record::find($r->id);
        $rec->duration = $r->duration;
        $rec->save();

        return $rec;
    }

    public function downloadVideo(Request $r)
    {
        $rec = Record::where('remote_url',$r->remote_url)->first();

        if ($rec) {
            $dest = public_path().'/uploads/videos/' . $rec->name;
            copy($r->remote_url, $dest);
            $rec->remote_url = null;
            $rec->save();
        }
        return "Completado";
    }

    // public function uploadVideo(Request $r)
    // {
    //     $u = User::find($r->user_id);

    //     $res = Reservation::where('customer_id',$u->id)->where('status',0)->first();

    //     if ($r->hasFile('data')) {
    //         $file = $r->file('data');
    //         $path = public_path().'/uploads/videos';
    //         $name = str_slug($u->name,'-').'-'.Carbon::now()->format('d_m_Y-h_i_s').'.webm';
    //         $file->move($path,$name);

    //         /**/

    //         // $cloudconvert = new CloudConvert([
    //         //     'api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNiNTRlZGRjYjk3ZDJjYmEzOTdkNzg0ZmNhYjc1Mzc1ZGU1NWMxNzlmNDNmNDk4MzMwZDJmNDNjZDhjMmFjYWMwZTcxZGYwODliYWNiZDg3In0.eyJhdWQiOiIxIiwianRpIjoiM2I1NGVkZGNiOTdkMmNiYTM5N2Q3ODRmY2FiNzUzNzVkZTU1YzE3OWY0M2Y0OTgzMzBkMmY0M2NkOGMyYWNhYzBlNzFkZjA4OWJhY2JkODciLCJpYXQiOjE1ODg2OTQ0NTQsIm5iZiI6MTU4ODY5NDQ1NCwiZXhwIjo0NzQ0MzY4MDU0LCJzdWIiOiI0MTk2NjgyMiIsInNjb3BlcyI6WyJ1c2VyLnJlYWQiLCJ1c2VyLndyaXRlIiwidGFzay5yZWFkIiwidGFzay53cml0ZSIsIndlYmhvb2sud3JpdGUiLCJwcmVzZXQucmVhZCIsInByZXNldC53cml0ZSIsIndlYmhvb2sucmVhZCJdfQ.TmeMPwiHzsA3BQv3CJfm1nLeYK-dk_eO1tWQWMXF-EawZYdw-RuRTRobjOSKSGXkAikoSoGGSL1iD59paJb8tAB-7klXcs4mIkuNb-gWO1Q-nA9DdrS78HqE7s_x9c43W1ZiK81UbLdzWRPWG9zGHAacrBryXKm2tURhMNdQ4LIbmk2JWM4DQxbc_dQaFenINuyXlOoRrUPWUYW5cRjR9GeQh7yz9Wt44J1Q8o4LNxS-Ht_YTrW68zQQmHjMvdhZo4aCZZGCabO2KwvZ55ojlRXeNm8Ook59RgRzpx5OO5C2HEYww2zjRb3DOHmKChywNJWtQM4T0HBiq21XKm5xGpmHszfygTPjCwpdmGUx5yPD0SUEcoOw_Y5gL-CfksWAPwZi2bGkZ4_9YHjkpXOP2TtbsGFZC8SavgBFq_AUAkymBeSYg0wWt3hQQH2D5qS1P2DmbKC5jX3tPr7FcSFYeiXFK5udP3nPSKS5YuWxkfEa17dF0JfzrtqcsSUDJyVkjdPIXyGQMqd6AfMf9UieOQnz9YEjB64IHdERb2KIo6PgGbE5MZ3HnRwac17U4Tn2xyW29HX1yyzaZFT445YZbWILk4zjX0hXreGLB9qESyxCnHFN0mXqMdT4OlP4zoJ58I82lU6bPdOig-PxBjrsOcDjo0eego04rQdZSx1b3NM',
    //         //     'sandbox' => false
    //         // ]);

    //         // $job = (new Job())
    //         //     ->addTask(
    //         //         (new Task('import/url', 'import-my-file'))
    //         //             // ->set('url', url('/uploads/videos/zappa-giorgio-19032020-20_04_2020-11_47_40.webm'))
    //         //             ->set('url', url('/uploads/videos',$name))
    //         //     )
    //         //     ->addTask(
    //         //         (new Task('convert', 'convert-my-file'))
    //         //             ->set('input', 'import-my-file')
    //         //             ->set('output_format', 'mp4')
    //         //             ->set('preset', 'ultrafast')
    //         //             ->set('video_codec', 'copy')
    //         //     )
    //         //     ->addTask(
    //         //         (new Task('export/url', 'export-my-file'))
    //         //             ->set('input', 'convert-my-file')
    //         //             ->set('inline', false)
    //         //     );

    //         // $cloudconvert->jobs()->create($job);

    //         // $cloudconvert->jobs()->wait($job);

    //         // $file = $job->getExportUrls()[0];

    //         // $source = $cloudconvert->getHttpTransport()->download($file->url)->detach();

    //         $dest = fopen(public_path().'/uploads/videos/' . $file->filename, 'w');
            
    //         stream_copy_to_stream($source, $dest);

    //         // @unlink($path.'/'.$name);

    //         // $rec->name = str_replace('.webm','.mp4',$rec->name);
    //         // $rec->save();

    //         // @unlink($path.'/'.$name);

    //         $rec = new Record;
    //         $rec->user_id = $r->user_id;
    //         $rec->duration = $r->duration;
    //         // $rec->size = $r->size;
    //         // $rec->name = $name;
    //         $rec->name = str_replace('.webm','.mp4',$name);

    //         $rec->address = $r->address;
    //         $rec->lat = $r->lat;
    //         $rec->lon = $r->lon;
    //         $rec->reservation_id = $res->id;

    //         $rec->save();

    //         $records = Record::where(['user_id'=>$r->user_id,'reservation_id'=>$res->id])->with('user')->get();

    //         foreach ($records as $key => $value) {
    //             $value->created = $value->created_at->format('d-m-Y H:i:s');
    //         }

    //         return [$records, url('uploads/videos')];
    //     }
    // }

    public function open_chat(Request $r)
    {
        $messages = null;
        if (Auth::user()->role_id == -1) {
            $messages = 
            Message::where(function($q) use($r) {
                $q->where('from_id',$r->id)
                ->orWhere('to_id',$r->id);
            })
            ->where('reservation_id',$r->res)
            ->with('from','to')->get();
        }else{
            $messages = 
            Message::where('reservation_id',$r->res)
            ->where(function($q) use($r) {
                $q->where(function($q) use($r){
                    $q->where('from_id',$r->id)->where('to_id',Auth::user()->id);
                })->orWhere(function($q) use($r){
                    $q->where('from_id',Auth::user()->id)->where('to_id',$r->id);
                });
            })
            ->where('reservation_id',$r->res)
            ->with('from','to')->get();
        }

        foreach ($messages as $key => $value) {
            $value->created = $value->created_at->format('d M, H:i');
        }

        return $messages;
    }
    public function utente($id,$o,$res,$sha1)
    {
        $res = Reservation::find($res);
        $u = User::find($id);
        $o = User::find($o);
        $s = sha1(sha1($u->email.$o->email));
        if ($s != $sha1) {
            return back();
        }
        if (!$u || !$o || !$res) {
            return back();
        }
        return view('details-offline',compact('o','u','res'));
    }

    public function share(Request $r)
    {
        Mail::send('condivisione', ['url'=>$r->url], function ($message) use ($r) {
            $message->from('no_reply@expressclaims.it', 'Studio Zappa');
            $message->to($r->email, $r->name);
            $message->subject('Express Claims – files accertamenti effettuati');
        });
    }

    public function uploadFileChat(Request $r)
    {
        $u = User::find($r->id);
        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/chats';
            $name = str_slug($u->name,'-').'-'.Auth::user()->name.'-'.Carbon::now()->format('d-m-Y h_i_s').'.'.$file->getClientOriginalExtension();
            $file->move($path,$name);

            return url('/uploads/chats',$name);
        }
    }

    public function getTime()
    {
        return gmdate("d M, H:i",time()+7200);
    }

    public function predefiniti($id = null)
    {
        if ($id != null) {
            $pred = Predefined::find($id);
            return view('admin.predefined',compact('pred'));
        }else{
            return view('admin.predefined');
        }
    }

    public function sms_update(Request $r, $id)
    {
        $this->validate($r,[
            'title' => 'required',
            'message' => 'required'
        ],$this->messages);
        
        $p = Predefined::find($id);
        $p->title = $r->title;
        $p->message = $r->message;
        $p->save();
    }
    public function sms_create(Request $r)
    {
        $this->validate($r,[
            'title' => 'required',
            'message' => 'required'
        ],$this->messages);

        $p = new Predefined;
        $p->title = $r->title;
        $p->message = $r->message;
        $p->save();
    }

    public function delete_sms($id)
    {
        Predefined::find($id)->delete();

        return back();
    }

    public function preassign($id = null)
    {
        $pre = null;
        if ($id != null) {
            $pre = Preassign::find($id);
        }

        return view('admin/preassign',compact('pre'));
    }

    public function savePreassign(Request $r, $id = null)
    {
        $this->validate($r,[
            'phone' => 'required',
            'sin_number' => 'required|unique:preassigns,sin_number,'.$id,
            'operator_id' => 'required'
        ],$this->messages);

        $other = Reservation::where('sin_number',$r->sin_number)->first();
        if ($other) {
            return response()->json(['Il numero di sinistro è già in uso'],422);
        }

        $c = Customer::where('phone',$r->code.$r->phone)->first();

        if ($c) {
            if ($c->user) {
                $res = Reservation::where(['customer_id'=>$c->user_id,'status'=>0])->first();

                if ($res) {
                    // return Response::json(['Il numero di telefono è già assegnato a un cliente'],422);
                    return Response::json(['Il cliente ha un sinistro attivo'],422);
                }
            }
            $c->operator_id = Auth::user()->id;
            $c->save();
        }

        $pr = Preassign::where('code',$r->code)->where('phone',$r->phone)->first();

        if ($pr) {
            return Response::json(['Il numero di telefono inserito ha già un preabbinamento'],422);
        }

        if ($id != null) {
            $p = Preassign::find($id);
        }else{
            $p = new Preassign;
        }


        /**/

        $p->code = $r->code;
        $p->phone = $r->phone;
        /**/
        $p->fullphone = $r->code.$r->phone;
        /**/
        $p->sin_number = $r->sin_number;
        $p->operator_id = $r->operator_id;
        $p->status = 0;
        $p->save();
    }

    public function deletePreassign($id)
    {
        Preassign::find($id)->delete();

        return back();
    }

    public function reopen(Request $r)
    {
        $res = Reservation::where('customer_id',$r->id)->where('status',0)->first();

        if ($res) {
            return Response::json(["C'è già un incidente aperto per questo utente"],422);
        }

        $res = Reservation::find($r->res);
        $res->status = 0;
        $res->save();

        $u = User::find($$r->id);
        if ($u->webapp) {
            $u->webapp->expiration = Carbon::now()->addHours(3)->format('Y-m-d H:i:s');
            $u->webapp->save();

            return $u->webapp;
        }
    }

    //*****//

    public function compagnia($id = null)
    {
        $company = null;
        if ($id != null) {
            $company = Company::find($id);
        }

        return view('admin/companies',compact('company'));
    }

    public function modellodipolizza($id = null)
    {
        $policy = null;
        if ($id != null) {
            $policy = PolicyModel::find($id);
        }

        return view('admin/policies',compact('policy'));
    }

    public function tipologiadidanno($id = null)
    {
        $typology = null;
        if ($id != null) {
            $typology = Damage::find($id);
        }

        return view('admin/tipologia',compact('typology'));
    }

    public function compagniaPost(Request $r, $id = null)
    {
        $company = null;
        if ($id != null) {
            $company = Company::find($id);
        }else{
            $company = new Company;
        }
        $company->name = $r->name;
        $company->save();
    }

    public function modellodipolizzaPost(Request $r, $id = null)
    {
        $policy = null;
        if ($id != null) {
            $policy = PolicyModel::find($id);
        }else{
            $policy = new PolicyModel;
        }
        $policy->name = $r->name;
        $policy->company_id = $r->company_id;
        $policy->save();
    }

    public function tipologiadidannoPost(Request $r, $id = null)
    {
        $typology = null;
        if ($id != null) {
            $typology = Damage::find($id);
        }else{
            $typology = new Damage;
        }
        $typology->name = $r->name;
        $typology->save();
    }

    public function compagniaDelete($id = null)
    {
        Company::find($id)->delete();
        return back();
    }

    public function modellodipolizzaDelete($id = null)
    {
        PolicyModel::find($id)->delete();
        return back();
    }

    public function tipologiadidannoDelete($id = null)
    {
        Damage::find($id)->delete();
        return back();
    }

    public function saveInformation(Request $r)
    {
        $d = Detail::where('user_id',$r->user_id)->first();
        $res = Reservation::where(['customer_id' => $r->user_id, 'status' => 0])->first();

        if (!$d) {
            $d = new Detail;
        }
        $d->user_id = $r->user_id;
        $d->sin_number = $r->sin_number;
        $d->company = $r->company;
        $d->policy = $r->policy;
        $d->policy_model = $r->policy_model;
        $d->damage = $r->damage;
        $d->insurance = $r->insurance;
        $d->franchise = $r->franchise;
        $d->limit = $r->limit;
        $d->quantification1 = $r->quantification1;
        $d->quantification2 = $r->quantification2;

        $d->phone_model = $r->phone_model;
        $d->phone_works = $r->phone_works;

        $d->notes = $r->notes;
        $d->save();
        $d->_sin_number = $res->sin_number;

        $pm = PhoneModel::where('name',$r->phone_model)->first();
        $new = null;

        if (!$pm) {
            $pm = new PhoneModel;
            $pm->name = $r->phone_model;
            $pm->save();

            $new = $pm;
        }

        if ($r->ajax()) {
            return [$d,$new];
        }

        return back();
    }

    public function smspassword(Request $r)
    {
        $sms = SMSPassword::first();

        if (!$sms) {
            $sms = new SMSPassword;
        }
        $sms->password = $r->password;
        $sms->save();

        return back();
    }

    public function find_company(Request $r)
    {
        $company = Company::where('name',$r->company)->first();
        $policies = PolicyModel::where('company_id',$company->id)->get();
        return $policies;
    }

    public function updateAddress(Request $r)
    {
        $c = ClaimFile::find($r->id);
        $c->address = $r->address;
        $c->save();
    }

    public function updateAddressClaims(Request $r)
    {
        $c = Image::find($r->id);
        $c->address = $r->address;
        $c->save();
    }

    public function updateAddressAutoperizia(Request $r)
    {
        $c = SelfManagementImage::find($r->id);
        $c->address = $r->address;
        $c->save();
    }

    /**/

    public function emails()
    {
        return view('admin.emails');
    }
    public function editemails($id)
    {
        $pr = PredefinedMail::find($id);
        return view('admin.emails',compact('pr'));
    }
    public function saveemail(Request $r)
    {
        $this->validate($r,[
            'title' => 'required',
            'predefined' => 'required',
        ]);

        $m = new PredefinedMail;
        $m->title = $r->title;
        $m->predefined = $r->predefined;
        $m->status = $r->status ? 1 : 0;
        $m->save();
    }
    public function updateemail(Request $r)
    {
        $this->validate($r,[
            'title' => 'required',
            'predefined' => 'required',
        ]);

        $m = PredefinedMail::find($r->id);
        $m->title = $r->title;
        $m->predefined = $r->predefined;
        $m->status = $r->status ? 1 : 0;
        $m->save();
    }

    public function delete_mail($id)
    {
        $m = PredefinedMail::find($id);
        $m->delete();
        return back();
    }

    public function assegna(Request $r)
    {
        $r->idperizia = $r->soc.$r->idperizia;
        // return Claim::where('sin_number',$r->idperizia)->get();
        $soc = ["Z","G","R"];
        $soc_name = ["Z"=>"Studio Zappa","G"=>"Gespea","R"=>"Renova"];

        $v = Validator::make($r->all(),[
            "soc" => "required|in:".implode(",",$soc),
            "idperizia" => "required|unique:claims,sin_number",
            "idperito" => "required|exists:users,id",
            "ass" => "required",
            "ids" => "required|exists:users,id"
            //|not_in:".$r->idperito
        ],[
            "soc.required" => "Society is required",
            "soc.in" => "Society must be Z,G or R",

            "idperizia.required" => "Idperizia is required",
            "idperizia.unique" => "Idperizia must be unique",

            "idperito.required" => "Idperito is required",
            "idperito.exists" => "idperito must exists in database",

            "ass.required" => "Assicurato is required",

            "ids.required" => "Id supervisor required",
            "ids.exists" => "Id supervisor must exists",
            "ids.not_in" => "Id supervisor cannot be the same idperito",
        ]);

        $s = User::find($r->ids);

        if (!$s) {
            return "KO|".'ID:'.$r->ids.', user not found';
        }

        if ($s->supervisor != 1) {
            return "KO|".'ID:'.$r->ids.', user is not supervisor';
        }

        if ($v->fails()) {
            return "KO|".$v->errors();
        }

        if (Claim::where('sin_number',$r->idperizia)->count() > 0) {
            return "KO|".'sin number already exists';
        }

        $c = Claim::where('sin_number',$r->idperizia)->first();

        if (!$c) {
            $c = new Claim;
        }

        $c->sin_number = $r->idperizia;
        $c->user_id = $r->idperito;
        $c->name = $r->ass;
        $c->society = $soc_name[$r->soc];
        $c->status = 0;
        $c->email1 = $r->email1 ? $r->email1 : "";
        $c->email2 = $r->email2 ? $r->email2 : "";
        $c->supervisor = $r->ids;
        $c->mail_text = "";
        $c->save();

        $u = User::find($r->idperito);

        $this->send_msg_notification($u->device_id,$c->sin_number);

        return "OK";
    }

    public function saveModalData(Request $r)
    {

        $mi = MapInformation::find($r->id);

        $st = State::where('idav',$r->Stato)->first();
        $perito1 = Expert::where('society',$mi->society)->where('name',$r->SOPRALLUOGO)->first();
        $perito2 = Expert::where('society',$mi->society)->where('name',$r->PERITO_GESTORE)->first();
        $perito3 = Expert::where('society',$mi->society)->where('name',$r->SOPRALLUOGO_2)->first();

        $mi->DATA_SOPRALLUOGO = $r->DATA_SOPRALLUOGO ? Carbon::createFromFormat('d-m-Y H:i',$r->DATA_SOPRALLUOGO)->format('Y-m-d H:i:s') : "";
        $mi->DATA_SOPRALLUOGO_2 = $r->DATA_SOPRALLUOGO_2 ? Carbon::createFromFormat('d-m-Y H:i',$r->DATA_SOPRALLUOGO_2)->format('Y-m-d H:i:s') : "";

        $mi->SOPRALLUOGO = $perito1 ? $perito1->name : "";
        $mi->SOPRALLUOGO_2 = $perito3 ? $perito3->name : "";
        $mi->PERITO_GESTORE = $perito2 ? $perito2->name : "";
        $mi->Stato = $st ? $st->order : "";
        $mi->note = $r->daily;
        $mi->VDP = $r->vdp ? 1 : "";
        $mi->AUT = $r->aut ? 1 : "";
        // $mi->society = $r->society;

        if ($mi->DATA_SOPRALLUOGO && $mi->DATA_SOPRALLUOGO != "") {
            if (Carbon::parse($mi->DATA_SOPRALLUOGO) < Carbon::now()) {
                response()->json(["Error"],422);
            }
        }

        if ($mi->DATA_SOPRALLUOGO_2 && $mi->DATA_SOPRALLUOGO_2 != "") {
            if (Carbon::parse($mi->DATA_SOPRALLUOGO_2) < Carbon::now()) {
                response()->json(["Error"],422);
            }
        }

        $json = [
            "operation" => null,
            "idperizia" => (int)$mi->N_P,
            "society" => $mi->society,
            "stato" => null,
            "dtperizia" => null,
            "dtperizia2" => null,
            "idsopralluogo1" => null,
            "idsopralluogo2" => null,
            "idgestore" => null,
            "dtt1" => null,
            "note" => null,
            "VDP" => null,
            "AUT" => null
        ];

        $json['operation'] = $r->operation;

        $json['dtperizia'] = ($mi->DATA_SOPRALLUOGO || $mi->DATA_SOPRALLUOGO != "") ? $mi->DATA_SOPRALLUOGO : null;
        $json['dtperizia2'] = ($mi->DATA_SOPRALLUOGO_2 || $mi->DATA_SOPRALLUOGO_2 != "") ? $mi->DATA_SOPRALLUOGO_2 : null;
        $json['society'] = $mi->society;
        $json['dtt1'] = Carbon::now()->format('Y-m-d H:i:s');
        $json['idgestore'] = $perito2 ? $perito2->idp : null;
        $json['idsopralluogo1'] = $perito1 ? $perito1->idp : null;
        $json['idsopralluogo2'] = $perito3 ? $perito3->idp : null;
        $json['stato'] = $st ? $st->idav : null;
        $json['note'] = $mi->note;
        $json['VDP'] = $r->vdp ? 1 : null;
        $json['AUT'] = $r->aut ? 1 : null;

        // return response()->json($json,422);

        /*foreach ($mi->getDirty() as $key => $value) {
            if ($key == 'DATA_SOPRALLUOGO') {
                $json['dtperizia'] = $mi->DATA_SOPRALLUOGO;
            }
            if ($key == 'PERITO_GESTORE') {
                $json['dtt1'] = Carbon::now()->format('Y-m-d H:i');
                $json['idgestore'] = $perito2->idp;
            }
            if ($key == 'SOPRALLUOGO') {
                $json['idsopralluogo1'] = $perito1->idp;
            }
            if ($key == 'Stato') {
                $json['stato'] = $st->idav;
            }
            if ($key == 'note') {
                $json['note'] = $mi->note;
            }
            if ($key == 'VDP') {
                $json['VDP'] = 1;
            }
            if ($key == 'AUT') {
                $json['AUT'] = 1;
            }
        }*/

        if ($r->operation == 'close') {
            $st = State::where('idav',30)->first();
            $mi->Stato = $st ? $st->order : null;
        }

        $dty = $mi->getDirty();
        // return response()->json($dty,422);

        // $responses = [];

        // // if ($st->idav == 30) {
        // //     // $json['operation'] = 'close';
        // //     $this->sendCurl($json);
        // // }

        // if (array_key_exists('SOPRALLUOGO', $dty)) {
        //     // $json['operation'] = 'ass1';
        //     // $responses[] = $this->sendCurl($json);
        // }

        // // if (array_key_exists('SOPRALLUOGO_2', $dty)) {
        //     // $json['operation'] = 'ass2';
        //     // $responses[] = $this->sendCurl($json);
        // // }

        $responses = $this->sendCurl($json);

        if ($responses['result'] == "OK") {

            if (array_key_exists('DATA_SOPRALLUOGO', $dty) && $r->DATA_SOPRALLUOGO != "" && $perito1) {

                $event = new Event;

                $dt = Carbon::createFromFormat('d-m-Y H:i',$r->DATA_SOPRALLUOGO);

                $event->name = 'PERIZIA N: '.$mi->N_P.' - SOPRALLUOGHISTA: '.$perito1->name;
                $event->startDateTime = $dt;
                $event->endDateTime = $dt->copy()->addHour();

                $event->save();


                // $json['operation'] = 'fix1';
                // $responses[] = $this->sendCurl($json);
            }

            if (array_key_exists('DATA_SOPRALLUOGO_2', $dty) && $r->DATA_SOPRALLUOGO_2 != "" && $perito2) {

                $event = new Event;

                $dt = Carbon::createFromFormat('d-m-Y H:i',$r->DATA_SOPRALLUOGO_2);

                $event->name = 'PERIZIA N: '.$mi->N_P.' - SOPRALLUOGHISTA: '.$perito2->name;
                $event->startDateTime = $dt;
                $event->endDateTime = $dt->copy()->addHour();

                $event->save();


                // $json['operation'] = 'fix2';
            }

            // $json['operation'] = 'read';
            // $responses[] = $this->sendCurl($json);

            $mi->save();
        }
        return [$responses];
    }

    public function sendCurl($json)
    {
        sleep ( 2 );
        
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "93.45.47.193:50801/perizia",
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

        // echo $response;

        $res = json_decode($response,true);

        return ["operation" => $json["operation"],"result" => $res["result"], "error" => (array_key_exists('error', $res) ? $res["error"] : null)];
    }

    public function changeMIData(Request $r)
    {
        $st = State::find($r->stato);
        $sopralluogo = Expert::where('idp',$r->idsopralluogo)->first();
        $gestore = Expert::where('idp',$r->idgestore)->first();

        if (!$r->idperizia) {
            return "KO|".'Idperizia vuoto';
        }
        if (!$sopralluogo) {
            return "KO|".'ID:'.$r->idsopralluogo.', sopralluogo not found';
        }
        if (!$gestore) {
            return "KO|".'ID:'.$r->idgestore.', gestore not found';
        }
        if (!$st) {
            return "KO|".'ID:'.$r->stato.', stato not found';
        }

        $mi = MapInformation::where('N_P',$r->idperizia)->first();

        if ($mi) {
            $mi->DATA_SOPRALLUOGO = $r->dtsopralluogo ? Carbon::createFromFormat('d-m-Y H:i',$r->dtsopralluogo) : "";
            $mi->PERITO_GESTORE = $gestore->name;
            $mi->SOPRALLUOGO = $sopralluogo->name;
            $mi->Stato = $st->description;
            $mi->VDP = $r->flag == 'vdp' ? 1 : null;
            $mi->AUT = $r->flag == 'aut' ? 1 : null;
            $mi->save();
        }else{
            return "KO|".'Perizia not found';
        }

        return "OK";
    }

    public function saveExcelData(Request $r)
    {
        $ex = ExcelFile::orderBy('id','desc')->first();

        if ($ex) {
            $ex->all = $r->all;
            $ex->l20 = $r->l20;
            $ex->l40 = $r->l40;
            $ex->l60 = $r->l60;
            $ex->p60 = $r->p60;

            $ex->mall = $r->mall;
            $ex->ml20 = $r->ml20;
            $ex->ml40 = $r->ml40;
            $ex->ml60 = $r->ml60;
            $ex->mp60 = $r->mp60;

            $ex->fiss = $r->fiss;
            $ex->nonf = $r->nonf;
            $ex->gmfs = $r->gmfs;
            $ex->gmnf = $r->gmnf;
            
            $ex->save();
        }
    }

    public function exportTable()
    {
        // return view("admin.export-table");

        $filename = 'Mappa Tabella - '.Carbon::now()->format('d-m-Y H:i:s');

        $ex = Excel::create($filename, function($excel) {

            $excel->sheet('1', function($sheet) {

                $sheet->setColumnFormat(array(
                    "A" => "@"
                ));

                $sheet->loadView("admin.export-table");

            });

        })->export('xlsx');
    }

    public function reopenSinister($id)
    {
        $res = Reservation::where('customer_id',$id)->where('status','!=',0)->get();

        foreach ($res as $key => $value) {
            $value->status = 0;
            $value->reopen = 1;
            $value->save();
            $value->made = $value->updated_at;
            $value->save();

            $u = User::find($id);
            if ($u->webapp) {
                $u->webapp->expiration = Carbon::now()->addHours(3)->format('Y-m-d H:i:s');
                $u->webapp->save();

                // return $u->webapp;
            }
        }

        return back()->with('message',"Il sinistro è stato riaperto. Il link da inviare al cliente è: <a href='".$u->webapp->url."'>".$u->webapp->url."</a>");
    }

    public function startSearch(Request $r)
    {
        return view('admin.template-search', compact('r'))->render();
    }

    public function videochiamateMensili()
    {
        return view('admin.videochiamateMensili');
    }
    public function exportRecord(Request $r)
    {
        $start = Carbon::createFromFormat('d-m-Y',$r->start);
        $name = $r->operator != 'all' ? User::find($r->operator)->fullname().' - '.$r->start : $r->start;
        $filename = 'Videochiamate Mensili - '.$name;

        // $ex = Excel::create($filename, function($excel) use($r,$start) {

        //     $excel->sheet('1', function($sheet) use($r,$start) {

        //         $bucle = Record::where('created_at','>=',$start)->where('created_at','<',$start->copy()->addMonth())->whereExists(function($q) use($r){
        //             if ($r->operator != 'all') {
        //                 $q->from('users')
        //                   ->whereRaw('users.id = records.user_id')
        //                   ->whereRaw('users.operator_call_id = '.$r->operator);
        //             }
        //         })->orderBy('user_id','asc')->get();

        //         // $sheet->setColumnFormat(array(
        //         //     "B" => "@",
        //         //     "D" => "0",
        //         //     "E" => "d/m/y h:mm",
        //         //     "F" => "h:mm:ss",
        //         // ));

        //         // $sheet->loadView('admin.exportMensili',compact('bucle','r'));

        //     });

        // // })->store('csv', public_path('maps/exports'));


        // $t = fopen(public_path('maps/exports').'/'.$filename.'.csv', "r");

        // // $csvData = [];
        // // while (($row = fgetcsv($t, 0, ",")) !== FALSE) {
        // //     $csvData[] = $row;
        // // }
        // // return json_encode($csvData);

        // $read = fread($t,filesize(public_path('maps/exports').'/'.$filename.'.csv'));

        $read = '';
        if($r->operator == 'all'){
            $read .="\"Operatori\";\"Rif. Interno\";\"Nominativo\";\"Num. telefono\";\"Data e ora inizio\";\"Durata\"\n";
        }else{
            $read .="\"Rif. Interno\";\"Nominativo\";\"Num. telefono\";\"Data e ora inizio\";\"Durata\"\n";
        }

        $bucle = Record::where('records.created_at','>=',$start)->where('records.created_at','<',$start->copy()->addMonth())->whereExists(function($q) use($r){
            if ($r->operator != 'all') {
                $q->from('users')
                  ->whereRaw('users.id = records.user_id')
                  ->whereRaw('users.operator_call_id = '.$r->operator);
            }
        })
        ->join('reservations','reservations.id','records.reservation_id')
        ->join('users','users.id','records.user_id')
        ->join('users as operator','operator.id','users.operator_call_id')
        ->select(
            'operator.name as operatorName',
            'records.created_at as created_at',
            'records.duration',
            'records.user_id',
            'records.reservation_id'
        )
        ->orderBy('operatorName','asc')->orderBy('created_at','asc')
        ->get();

        foreach ($bucle as $key => $rec) {
            $temp = "";

                if($r->operator == 'all'){
                    $temp.="\"".(User::find(@$rec->user->operator_call_id) ? User::find(@$rec->user->operator_call_id)->fullname() : '' )."\";";
                }
                $temp.="=\"".$rec->reservation->sin_number."\";";
                $temp.="\"".$rec->user->name()."\";";

                    if ($rec->user->webapp){
                        $temp.="=\"".$rec->user->webapp->code.$rec->user->webapp->phone."\";";
                    }elseif($rec->user->customer){
                        $temp.="=\"".$rec->user->customer->phone."\";";
                    }
                
                $temp.="\"".$rec->created_at->format('d-m-Y H:i')."\";";
                $temp.="\"00:".$rec->duration."\"";


            $read.=$temp."\n";
        }

        $w = fopen(public_path('maps/exports').'/'.$filename.'.csv', "w");
        fwrite($w, /*"sep=,\n".*/$read);
        fclose($w);

        return [url('maps/exports/',$filename.'.csv')];
    }

    public function desactivarLink($id)
    {
        $res = Reservation::where('customer_id',$id)->get();
        foreach ($res as $key => $value) {
            $value->status = 1;
            $value->save();
        }
        $u = User::find($id);
        if ($u->webapp) {
            $u->webapp->expiration = Carbon::now()->format('Y-m-d H:i:s');
            $u->webapp->save();

            return $u->webapp;
        }
    }

    public function changeParameter($id,$parameter)
    {
        $u = User::find($id);
        $label = "";
        if ($parameter == 'sp') {
            $u->supervisor = $u->supervisor === 1 ? null : 1;
            $label = $u->supervisor === 1 ? '<label onclick="changeParameter(\'sp\','.$id.')" class="label label-success">Si</label>' : '<label onclick="changeParameter(\'sp\','.$id.')" class="label label-danger">No</label>';
        }else{
            $u->operator[$parameter] = $u->operator[$parameter] === 1 ? null : 1;
            $label = $u->operator[$parameter] === 1 ? '<label onclick="changeParameter(\''.$parameter.'\','.$id.')" class="label label-success">Si</label>' : '<label onclick="changeParameter(\''.$parameter.'\','.$id.')" class="label label-danger">No</label>';
        }
        $u->operator->save();
        $u->save();

        return $label;
    }

    public function exportOperators($status)
    {
        $filename = 'Operatori - '.Carbon::now()->format('d-m-Y H:i:s');

        $ex = Excel::create($filename, function($excel) use($status) {

            $excel->sheet('1', function($sheet) use($status) {

                $sheet->setColumnFormat(array(
                    "B" => "@"
                ));

                $sheet->loadView("admin.street-operators.export", compact('status'));

            });

        })->export('xlsx');
    }

    /**/

    public function setCompanySession(Request $r)
    {
        if ($r->company == "0") {
            $r->session()->forget('company');
        }else{
            session(['company'=>$r->company]);
        }

        return session('company');
    }







    public function getMapInformationG(Request $r)
    {
        $_excel = [];
        if ($r->compagnia || $r->perito || $r->provincia || $r->stato || $r->tp || $r->specific) {

            $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->
            where(function($q) use($r){
                if ($r->compagnia) {
                    foreach ($r->compagnia as $key => $value) {
                        $q->orWhere('COMPAGNIA','like','%'.$value.'%');
                    }
                }
            })->
            where(function($q) use($r){
                if ($r->perito) {
                    if ($r->perito == ['none']) {
                        $q->where('SOPRALLUOGO','');
                    }else{
                        foreach ($r->perito as $key => $value) {
                            $q->orWhere('SOPRALLUOGO','like','%'.$value.'%');
                        }
                    }
                }
            })->
            /**/
            where(function($q) use($r){
                if ($r->perito3) {
                    if ($r->perito3 == ['none']) {
                        $q->where('PERITO_GESTORE','');
                    }else{
                        foreach ($r->perito3 as $key => $value) {
                            $q->orWhere('PERITO_GESTORE','like','%'.$value.'%');
                        }
                    }
                }
            })->
            /**/
            where(function($q) use($r){
                if ($r->provincia) {
                    foreach ($r->provincia as $key => $value) {
                        $q->orWhere('PROVINCIA','like','%'.$value.'%');
                    }
                }
            })->
            where(function($q) use($r){
                if ($r->stato) {
                    if ($r->stato == ['none']) {
                        $q->where('Stato','not like','%FISSATO%');
                    }else{
                        foreach ($r->stato as $key => $value) {
                            $q->orWhere('Stato','like','%'.$value.'%');
                        }
                    }
                }
            })->
            where(function($q) use($r){
                if ($r->tp) {
                    foreach ($r->tp as $key => $value) {
                        $q->orWhere('TP','like','%'.$value.'%');
                    }
                }
            })->
            where(function($q) use($r){
                if ($r->specific) {
                    $q->where('N_P','like','%'.$r->specific.'%');
                }
            })
            ->with('diferentsG')
            ->groupBy('lat','lng')
            ->orderBy('DATA_SOPRALLUOGO','desc')
            ->get();

        }else{

            if ($r->ignore == 'si') {
                $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)
                ->with('diferentsG')->get();
            }else{
                $mi = MapInformation::where(function($q){if (session('company')) {$q->where('COMPAGNIA',session('company'));}})->where('status',1)->whereIn('type',$r->data_type)->
                with('diferentsG')->
                groupBy('lat','lng')->orderBy('DATA_SOPRALLUOGO','desc')->get();
            }
        }
        
        $e = (ExcelFile::orderBy('id','desc')->first() ? ExcelFile::orderBy('id','desc')->first() : ["name"=>"","updated_at"=>Carbon::now()]);

        return [$e,$mi];
    }






































    public function mapI(Request $r)
    {
        $req = json_decode(request()->getContent(), true);

        if (!isset($req['index'])) {
            $req['index'] = 1;
        }

        if (isset($req['operation']) && $req['index'] !== null) {
            
            if ($req['operation'] == "normal") {

                if ($req['n_p']) {
                    
                    $mi = MapInformation::where('N_P',$req['n_p'])->get();

                    if (isset($mi[$req['index']-1])) {
                        $mi = $mi[$req['index']-1];
                    }else{
                        $mi = new MapInformation;
                        $mi->N_P = $req['n_p'];
                    }

                    if(isset($req['tp']))
                        {$mi->TP = $req['tp'] ? $req['tp'] : '';}
                    if(isset($req['assicurato']))
                        {$mi->Assicurato = $req['assicurato'] ? $req['assicurato'] : '';}
                    if(isset($req['nome']))
                        {$mi->Danneggiato = $req['nome'] ? $req['nome'] : '';}
                    if(isset($req['comune']))
                        {$mi->COMUNE = $req['comune'] ? $req['comune'] : '';}
                    if(isset($req['cap']))
                        {$mi->CAP = $req['cap'] ? $req['cap'] : '';}
                    if(isset($req['provincia']))
                        {$mi->PROVINCIA = $req['provincia'] ? $req['provincia'] : '';}
                    if(isset($req['indirizzo']))
                        {$mi->INDIRIZZO = $req['indirizzo'] ? $req['indirizzo'] : '';}
                    if(isset($req['telefono']))
                        {$mi->TELEFONO = $req['telefono'] ? $req['telefono'] : '';}
                    if(isset($req['cellulare']))
                        {$mi->CELLULARE = $req['cellulare'] ? $req['cellulare'] : '';}
                    
                    if((isset($req['email']) || $req['email'] != ''))
                        {$mi->EMAIL = ($req['email'] || $req['email'] != '') ? $req['email'] : null;}
                    
                    if(isset($req['stato']))
                        {$mi->Stato = $req['stato'] ? $req['stato'] : '';}
                    
                    if(isset($req['Stato']))
                        {$mi->Stato = $req['Stato'] ? $req['Stato'] : '';}

                    if(isset($req['sopralluoghista']))
                        {$mi->SOPRALLUOGO = $req['sopralluoghista'] ? $req['sopralluoghista'] : '';}
                    if(isset($req['data_sopralluogo']))
                        {$mi->DATA_SOPRALLUOGO = $req['data_sopralluogo'] ? $req['data_sopralluogo'] : '';}
                    if(isset($req['riserva']))
                        {$mi->RISERVA = $req['riserva'] ? $req['riserva'] : '';}
                    if(isset($req['n_sinistro']))
                        {$mi->N_Sinistro = $req['n_sinistro'] ? $req['n_sinistro'] : '';}
                    if(isset($req['dt_sinistro']))
                        {$mi->DT_Sinistro = $req['dt_sinistro'] ? $req['dt_sinistro'] : '';}
                    if(isset($req['dt_incarico']))
                        {$mi->DT_Incarico = $req['dt_incarico'] ? $req['dt_incarico'] : '';}
                    
                    if((isset($req['dt_assegnata']) || $req['dt_assegnata'] != ''))
                        {$mi->DT_ASSEGNATA = ($req['dt_assegnata'] || $req['dt_assegnata'] != '') ? $req['dt_assegnata'] : null;}
                    if((isset($req['dt_riconsegna']) || $req['dt_riconsegna'] != ''))
                        {$mi->DT_CONSEGNA = ($req['dt_riconsegna'] || $req['dt_riconsegna'] != '') ? $req['dt_riconsegna'] : null;}

                    if(isset($req['compagnia']))
                        {$mi->COMPAGNIA = $req['compagnia'] ? $req['compagnia'] : '';}
                    if(isset($req['agenzia']))
                        {$mi->AGENZIA = $req['agenzia'] ? $req['agenzia'] : '';}
                    if(isset($req['tipo']))
                        {$mi->type = $req['tipo'] ? $req['tipo'] : '';}
                    if(isset($req['perito_gestore']))
                        {$mi->PERITO_GESTORE = $req['perito_gestore'] ? $req['perito_gestore'] : '';}
                    if(isset($req['note']))
                        {$mi->note = $req['note'] ? $req['note'] : '';}
                    if(isset($req['vdp']))
                        {$mi->VDP = $req['vdp'] ? $req['vdp'] : '';}
                    if(isset($req['aut']))
                        {$mi->AUT = $req['aut'] ? $req['aut'] : '';}
                    if(isset($req['society']))
                        {$mi->society = $req['society'] ? $req['society'] : '';}
                    
                    if((isset($req['ET']) || $req['ET'] != ''))
                        {$mi->ET = ($req['ET'] || $req['ET'] != '') ? $req['ET'] : null;}

                    $mi->project = 1;

                    if (isset($req['lat'])) {
                        $mi->lat = ($req['lat'] || $req['lat'] != '') ? $req['lat'] : $mi->lat;
                    }
                    if (isset($req['lng'])) {
                        $mi->lng = ($req['lng'] || $req['lng'] != '') ? $req['lng'] : $mi->lng;
                    }
                    if (isset($req['lat']) && isset($req['lng'])) {
                        $mi->latlng = $mi->lat.','.$mi->lng;
                    }

                    $mi->status = 1;
                    $mi->save();

                    $mi = MapInformation::where('DATA_SOPRALLUOGO',null)->get();

                    foreach ($mi as $m)
                    {
                        $m->DATA_SOPRALLUOGO = "";
                        $m->DATA_SOPRALLUOGO_2 = "";
                        $m->save();
                    }

                    return ["OK",$mi];
                    
                }else{
                    return "KO: No n_p especified";
                }

            }

            else if (isset($req['operation']) && $req['operation'] == "delete") {
                $mi = MapInformation::where('N_P',$req['n_p'])->first();

                if (!$mi) {
                    return "KO: n_p not_found";
                }

                return ["OK",$req['n_p']." Deleted"];

            }

            else if ($req['operation'] == "all") {

                $mi = MapInformation::where('society',$req['soc'])->select(
                    "N_P",
                    "TP",
                    "Assicurato",
                    "Danneggiato",
                    "COMUNE",
                    "CAP",
                    "PROVINCIA",
                    "INDIRIZZO",
                    // "TELEFONO",
                    // "CELLULARE",
                    "EMAIL",
                    "Stato",
                    // "SOPRALLUOGO",
                    // "DATA_SOPRALLUOGO",
                    // "RISERVA",
                    "N_Sinistro",
                    "DT_Sinistro",
                    "DT_Incarico",
                    "DT_ASSEGNATA",
                    "DT_CONSEGNA",
                    "COMPAGNIA",
                    "AGENZIA",
                    "type",
                    "PERITO_GESTORE",
                    "note",
                    "society",
                )->skip($req['offset'])->take($req['limit'])->get();

                return $mi;
            }

        }

        if ($req['operation'] == "update") {

            if ($req['n_p']) {
                
                $mis = MapInformation::where('society',$req['soc'])->where('N_P',$req['n_p'])->get();

                foreach ($mis as $mi) 
                {
                    if(isset($req['tp'])) {$mi->TP = $req['tp'] ? $req['tp'] : '';}
                    if(isset($req['assicurato'])) {$mi->Assicurato = $req['assicurato'] ? $req['assicurato'] : '';}
                    if(isset($req['nome'])) {$mi->Danneggiato = $req['nome'] ? $req['nome'] : '';}
                    if(isset($req['comune'])) {$mi->COMUNE = $req['comune'] ? $req['comune'] : '';}
                    if(isset($req['cap'])) {$mi->CAP = $req['cap'] ? $req['cap'] : '';}
                    if(isset($req['provincia'])) {$mi->PROVINCIA = $req['provincia'] ? $req['provincia'] : '';}
                    if(isset($req['indirizzo'])) {$mi->INDIRIZZO = $req['indirizzo'] ? $req['indirizzo'] : '';}
                    if(isset($req['telefono'])) {$mi->TELEFONO = $req['telefono'] ? $req['telefono'] : '';}
                    if(isset($req['cellulare'])) {$mi->CELLULARE = $req['cellulare'] ? $req['cellulare'] : '';}
                    
                    if((isset($req['email']) && $req['email'] != '')) {$mi->EMAIL = ($req['email'] || $req['email'] != '') ? $req['email'] : null;}
                    
                    if(isset($req['stato'])) {$mi->Stato = $req['stato'] ? $req['stato'] : '';}
                    if(isset($req['Stato'])) {$mi->Stato = $req['Stato'] ? $req['Stato'] : '';}

                    if(isset($req['sopralluoghista'])) {$mi->SOPRALLUOGO = $req['sopralluoghista'] ? $req['sopralluoghista'] : '';}
                    if(isset($req['data_sopralluogo'])) {$mi->DATA_SOPRALLUOGO = $req['data_sopralluogo'] ? $req['data_sopralluogo'] : '';}
                    if(isset($req['riserva'])) {$mi->RISERVA = $req['riserva'] ? $req['riserva'] : '';}
                    if(isset($req['n_sinistro'])) {$mi->N_Sinistro = $req['n_sinistro'] ? $req['n_sinistro'] : '';}
                    if(isset($req['dt_sinistro'])) {$mi->DT_Sinistro = $req['dt_sinistro'] ? $req['dt_sinistro'] : '';}
                    if(isset($req['dt_incarico'])) {$mi->DT_Incarico = $req['dt_incarico'] ? $req['dt_incarico'] : '';}
                    
                    if((isset($req['dt_assegnata']) && $req['dt_assegnata'] != '')) {$mi->DT_ASSEGNATA = ($req['dt_assegnata'] && $req['dt_assegnata'] != '') ? $req['dt_assegnata'] : null;}
                    if((isset($req['dt_riconsegna']) && $req['dt_riconsegna'] != '')) {$mi->DT_CONSEGNA = ($req['dt_riconsegna'] && $req['dt_riconsegna'] != '') ? $req['dt_riconsegna'] : null;}

                    if(isset($req['compagnia'])) {$mi->COMPAGNIA = $req['compagnia'] ? $req['compagnia'] : '';}
                    if(isset($req['agenzia'])) {$mi->AGENZIA = $req['agenzia'] ? $req['agenzia'] : '';}
                    if(isset($req['tipo'])) {$mi->type = $req['tipo'] ? $req['tipo'] : '';}
                    if(isset($req['perito_gestore'])) {$mi->PERITO_GESTORE = $req['perito_gestore'] ? $req['perito_gestore'] : '';}
                    if(isset($req['note'])) {$mi->note = $req['note'] ? $req['note'] : '';}
                    if(isset($req['vdp'])) {$mi->VDP = $req['vdp'] ? $req['vdp'] : '';}
                    if(isset($req['aut'])) {$mi->AUT = $req['aut'] ? $req['aut'] : '';}
                    if(isset($req['society'])) {$mi->society = $req['society'] ? $req['society'] : '';}
                    
                    if((isset($req['ET']) && $req['ET'] != '')) {$mi->ET = ($req['ET'] && $req['ET'] != '') ? $req['ET'] : null;}

                    $mi->project = 1;

                    if (isset($req['lat'])) {
                        $mi->lat = ($req['lat'] && $req['lat'] != '') ? $req['lat'] : $mi->lat;
                    }
                    if (isset($req['lng'])) {
                        $mi->lng = ($req['lng'] && $req['lng'] != '') ? $req['lng'] : $mi->lng;
                    }
                    if (isset($req['lat']) && isset($req['lng'])) {
                        $mi->latlng = $mi->lat.','.$mi->lng;
                    }

                    $mi->status = 1;
                    $mi->save();
                }

                $mi = MapInformation::where('DATA_SOPRALLUOGO',null)->get();

                foreach ($mi as $m)
                {
                    $m->DATA_SOPRALLUOGO = "";
                    $m->DATA_SOPRALLUOGO_2 = "";
                    $m->save();
                }

                return ["OK",$mis];
            }else{
                return "KO: No n_p especified";
            }

        }

        if ($req['operation'] == "read") {
            $mi = MapInformation::where('society',$req['soc'])->where('N_P',$req['n_p'])->select(
                "N_P",
                "TP",
                "Assicurato",
                "Danneggiato",
                "COMUNE",
                "CAP",
                "PROVINCIA",
                "INDIRIZZO",
                // "TELEFONO",
                // "CELLULARE",
                "EMAIL",
                "Stato",
                // "SOPRALLUOGO",
                // "DATA_SOPRALLUOGO",
                // "RISERVA",
                "N_Sinistro",
                "DT_Sinistro",
                "DT_Incarico",
                "DT_ASSEGNATA",
                "DT_CONSEGNA",
                "COMPAGNIA",
                "AGENZIA",
                "type",
                "PERITO_GESTORE",
                "note",
                "society",
            )->get();

            return $mi;
        }

        return "0 results";
    }

    public function calendario()
    {
        $d1 = Carbon::now()->startOfMonth();
        $d2 = $d1->copy()->addMonth();
        $events = Event::get($d1,$d2);

        return view('admin.calendar',compact('events'));
    }

    public function changeMonthFull(Request $r)
    {
        $month = Carbon::parse($r->month);

        if ($r->action == 'add') {
            
            $d1 = $month->copy()->addMonth();
            $d2 = $d1->copy()->addMonth();

            $backMonth = $month->addMonth()->format('Y-n');
        }elseif($r->action == 'sub'){

            $d1 = $month->copy()->subMonth();
            $d2 = $d1->copy()->addMonth();

            $backMonth = $month->subMonth()->format('Y-n');
        }else{
            $d1 = $month->copy();
            $d2 = $d1->copy()->addMonth();

            $backMonth = $month->format('Y-n');

        }

        $events = Event::get($d1,$d2);

        return view('admin.include_calendar',compact('backMonth','events'))->render();

    }

    // public function inviteEvent(Request $r)
    // {
    //     $e = Event::find($r->id);

    //     $e->addAttendee(['email' => $r->email]);

    //     $e->save();
    // }

    public function deleteEvent(Request $r)
    {
        $e = Event::find($r->id);
        $e->delete();
    }
}



/*Para poder crear o actualizar una asignación en el sistema de gespea es necesario enviar un json a la siguiente ruta:

https://webges.gespea.it/api/mapI

El json debe contener los datos del mismo tipo que los que se guardan en el archivo excel que se sube al sistema de gestion de mapas:
    
{
    "operation":"normal", // se crea o actualiza un registro
    "n_p":null, // fila "N.P." en excel
    "tp":null, // fila "TP" en excel
    "assicurato":null, // fila "Assicurato" en excel
    "nome":null, // fila "NOME" en excel
    "comune":null, // fila "COMUNE" en excel
    "cap":null, // fila "CAP" en excel
    "provincia":null, // fila "PROVINCIA" en excel
    "indirizzo":null, // fila "INDIRIZZO" en excel
    "telefono":null, // fila "TELEFONO" en excel
    "cellulare":null, // fila "CELLULARE" en excel
    "email":null, // fila "EMAIL" en excel
    "stato":null, // fila "Stato" en excel
    "sopralluoghista":null, // fila "SOPRALLUOGHISTA" en excel
    "data_sopralluogo":null, // fila "DATA_SOPRALLUOGO" en excel
    "riserva":null, // fila "Riserva" en excel
    "n_sinistro":null, // fila "N.Sinistro" en excel
    "dt_sinistro":null, // fila "DT Sinistro" en excel
    "dt_incarico":null, // fila "DT Incarico" en excel
    "dt_assegnata":null, // fila "DT Assegnata" en excel
    "dt_riconsegna":null, // fila "DT Riconsegna" en excel
    "compagnia":null, // fila "COMPAGNIA" en excel
    "agenzia":null, // fila "AGENZIA" en excel
    "tipo":null, // fila "TIPO" en excel
    "perito_gestore":null, // fila "PERITO_GESTORE" en excel
    "note":null, // fila "NOTE" en excel
    "vdp":null, // 1/null
    "aut":null, // 1/null
    "index":0
}

De allí el campo n_p es el que se utilizará para ver si una "pratica" existe por lo tanto, si se desea actualizar, basta con pasar en el n_p un valor ya existente en el gestional y los demás datos se actualizarán, si el n_p es nuevo, se creará una nueva entrada.

Para borrar una "pratica" se debe pasar en "operation" el valor "delete" y solo es necesario el campo "n_p"*/