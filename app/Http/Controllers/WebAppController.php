<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebAppUser;

use App\SelfManagement;
use App\SelfManagementImage;
use App\SelfManagementDocument;

use App\User;
use App\Operator;
use App\Reservation;

use App\Message;
use App\Image;
use App\Video;
use App\Record;
use App\Question;
use App\Short;
use Carbon\Carbon;
use _Image;
use Auth;
use Bitly;

use Imagick;
use Mail;

class WebAppController extends Controller
{
    //
    public function index($id = null)
    {
        $wapp = null;
    	if ($id) {
    		$wapp = WebAppUser::find($id);
    	}
    	return view('admin.webapp',compact('wapp'));
    }
    public function index2($id = null)
    {
        return view('admin.customers.webapp');
    }

    public function indexSML($id = null)
    {
        $sm = null;
        if ($id) {
            $sm = SelfManagement::find($id);
        }
        return view('admin.selfmanagement',compact('sm'));
    }
    public function indexSML2($id = null)
    {
        return view('admin.customers.selfmanagement');
    }

    public function indexSM($id = null)
    {
        return view('admin.self-management-users');
    }
    public function indexSMC($id = null)
    {
        return view('admin.self-management-closed');
    }

    public function indexSMD($id = null)
    {

        // $sm = SelfManagement::all();

        // foreach ($sm as $key => $value) {
        //     foreach ($value->images as $key => $_i) {
        //         $path = public_path().'/uploads/autoperizia/';

        //         $img = _Image::make($path.$_i->image);
        //         $img->resize(1280,null,function($c){
        //             $c->aspectRatio();
        //         });
        //         $img->save($path.$_i->image);
        //     }
        // }

        $sm = selfmanagement::where('user_id',$id)->first();
        if ($sm) {

            $res = Reservation::where('customer_id',$id)->first();

            foreach ($sm->images as $key => $_i) {

                $path = public_path().'/uploads/autoperizia/';

                // $img = _Image::make($path.$_i->image);
                // $img->resize(1280,null,function($c){
                //     $c->aspectRatio();
                // });
                // $img->save($path.$_i->image);

                if (file_exists($path.$_i->image)) {

                    // if (!file_exists($path.'thumbs')) {
                    //     mkdir($path.'thumbs', 777, true);
                    // }
                    if (!file_exists($path.'t_'.$_i->image)) {
                        $img = _Image::make($path.$_i->image);

                        $img->resize(200,null,function($c){
                            $c->aspectRatio();
                        });
                        $img->save($path.'t_'.$_i->image);
                    }
                }
            }


            return view('admin.self-management-data',compact('sm','res'));
        }
    }


    public function webapp(Request $r)
    {
        $d = explode('/',$r->token);
        if (!isset($d[0])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
        if (!isset($d[1])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
        if (!isset($d[2])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
    	if (sha1($d[1]) != $d[0]) {
    		return view('error-webapp',["msg"=>"Il link a cui stai tentando di accedere non è corretto!"]);
    	}
    	if (Auth::check()) {
    		return view('error-webapp',["msg"=>"Ha una sessione attiva come amministratore!"]);
    	}

    	$w = WebAppUser::find($d[2]);

        if (!$w) {
            return view('error-webapp',["msg"=>"Il link inserito non esiste più o è scaduto!"]);
        }

        if (!$w->expiration) {
            return view('error-webapp',["msg"=>"Il link è scaduto!!"]);
        }

        if ($w->expiration < Carbon::now()) {
            return view('error-webapp',["msg"=>"Il link è scaduto!"]);
        }

    	if ($w->status == 0) {
    		return back();
    	}

        $img = $w->society;

    	$call_id = $d[1];

        $id = $w->id;

        $sin = $w->user->lastSinister();

        $company = $w->company;

        $name = $w->user->name;

        $o_id = $w->user->operator_call_id;

    	return view('webapp',compact('call_id','img','id','sin','company','name','o_id'));
    }

    public function saveWebappUserLocation(Request $r)
    {
        $w = WebAppUser::find($r->id);
        $w->lat = $r->lat;
        $w->lng = $r->lng;
        $w->save();
    }

    public function saveAutoperiziaLocation(Request $r)
    {
        $sm = SelfManagement::find($r->id);
        $sm->lat = $r->lat;
        $sm->lng = $r->lng;
        $sm->save();
    }

    public function save(Request $r, $id = null)
    {
    	if ($id) {
    		$w = WebAppUser::find($id);
    		$u = User::find($w->user_id);
    		$s = Reservation::where(['customer_id' => $w->user_id, 'status' => 0])->first();

            // return response()->json([$s],422);

            $this->validate($r,[
                // 'sin_number' => 'required|unique:reservations,sin_number,'.$s->id,
                'sin_number' => 'required',
            ],[
                'sin_number.required' => 'è richiesto un riferimento interno',
            ]);

            $res = Reservation::where('sin_number',$r->sin_number)->where('id','!=',$s->id)->first();

    	}else{
    		$u = new User;
    		$w = new WebAppUser;
    		$s = new Reservation;
    		$w->call_id = uniqid();

            $this->validate($r,[
                // 'sin_number' => 'required|unique:reservations',
                'sin_number' => 'required',
            ],[
                'sin_number.required' => 'è richiesto un riferimento interno',
            ]);

            $res = Reservation::where('sin_number',$r->sin_number)->first();
    	}

        if ($res) {
            return response()->json([$res,$res->user,$res->user->webapp],422);
        }

        function changeDate($date)
        {
            $all = explode(" ",$date);
            $date = $all[0];
            $hour = $all[1];

            $t = explode("-",$date);
            $aux = $t[2];
            $t[2] = $t[0];
            $t[0] = $aux;

            $f = implode("-",$t)." ".$hour.":00";

            return $f;
        }

    	$u->name = $r->name ? $r->name : "";
    	$u->email = $r->email ? $r->email : "";
    	$u->password = "";
    	$u->role_id = 0;
    	$u->status = $r->status ? $r->status : 0;
        if (Auth::user()->role_id == -1) {
           $u->operator_call_id = $r->operator_call_id ? $r->operator_call_id : Auth::user()->id;
        }else{
           $u->operator_call_id = Auth::user()->id;
        }
    	$u->save();

    	$w->user_id = $u->id;
        $w->company = $r->company ? $r->company : "";
        $w->society = $r->society ? $r->society : "";
    	$w->status = 1;
        $w->code = $r->code ? $r->code : "39";
        $w->phone = $r->phone ? $r->phone : "";
        $w->fullphone = $r->code.$r->phone;
        $w->expiration = $r->expiration ? changeDate($r->expiration) : "";
        if (!$id) {
            $w->url = "";
        }
        $w->save();

        if (!$id) {
            $sh = new Short;
            $sh->url = url('webapp?token='.sha1($w->user_id).'/'.$w->user_id.'/'.$w->id);
            $sh->save();
            // $w->url = Bitly::getUrl(url('webapp?token='.sha1($w->user_id).'/'.$w->user_id.'/'.$w->id));
            $w->url = url('short',$sh->id);
        	$w->save();
        }

        $s->message = "";
        $s->sin_number = $r->sin_number ? $r->sin_number : "";
        $s->customer_id = $u->id;
        $s->status = 0;
        $s->save();
        if (!$id) {
            $s->made = $s->created_at;
            $s->save();
        }
    }

    public function delete($id)
    {
        $w = WebAppUser::find($id);

        $u = User::find($w->user_id);

        Message::where('to_id',$u->id)->orWhere('from_id',$u->id)->delete();
        Image::where('user_id',$u->id)->delete();
        Video::where('user_id',$u->id)->delete();
        Reservation::where('customer_id',$u->id)->delete();
        Record::where('user_id',$u->id)->delete();

        $u->delete();
        $w->delete();

        return back();
    }

    public function sendPoll(Request $r,$id)
    {
        $w = WebAppUser::find($id);
        $q = new Question;
        $q->user_id = $w->user_id;
        $q->reservation_id = $w->user->lastSinister()->id;
        $q->rate = $r->rate;
        $q->email = $r->email;
        $q->comment = $r->comment;
        $q->save();
    }

    public function short($id)
    {
        $s = Short::find($id);
        return redirect($s->url);
    }

    /**/

    public function autoperizia(Request $r)
    {
        $d = explode('/',$r->token);
        if (!isset($d[0])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
        if (!isset($d[1])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
        if (!isset($d[2])) {
            return view('error-webapp',["msg"=>"Malformed access link, please verify"]);
        }
        if (sha1($d[1]) != $d[0]) {
            return view('error-webapp',["msg"=>"Il link a cui stai tentando di accedere non è corretto!"]);
        }
        Auth::logout();
        if (Auth::check()) {
            return view('error-webapp',["msg"=>"Ha una sessione attiva come amministratore!"]);
        }

        $w = SelfManagement::find($d[2]);

        if (!$w) {
            return view('error-webapp',["msg"=>"Il link inserito non esiste più o è scaduto!"]);
        }
        
        $status = $w->status;

        if (!$w->expiration) {
            $status = 0;
        }
        if ($w->expiration < Carbon::now()) {
            $status = 0;
        }
        // if ($w->status == 0) {
        //     return back();
        // }

        $img = $w->society;

        $call_id = $d[1];

        $id = $w->id;

        $sin = $w->user->lastSinister();

        $company = $w->company;

        $name = $w->user->name;

        $o_id = $w->user->operator_call_id;

        return view('autoperizia',compact('call_id','img','id','sin','company','name','o_id','status'));
    }

    public function preUploadImage(Request $r)
    {
        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $path = public_path().'/uploads/autoperizia/';
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move($path,$name);

            // $img = _Image::make($path.$name);
            // $img->resize(1280,null,function($c){
            //     $c->aspectRatio();
            // });
            // $img->save($path.$name);

            $im = new Imagick;

            if (strstr(mime_content_type($path.$name),'image')) {
                
                $im->readImage($path.$name);

                $im->commentImage($r->lat.','.$r->lng);
                // print($im->getImageProperty('comment'));
                file_put_contents ($path.$name, $im);
                // $im->imageWriteFile (fopen (public_path().'/test.jpg', "wb"));


                return ["url"=>url('uploads/autoperizia',$name),"name"=>$name,"confirm"=>true];
            }

            return ["url"=>url('file.png'),"name"=>$name,"confirm"=>true,'real'=>url('uploads/autoperizia',$name)];
        }
    }

    public function saveSM(Request $r, $id = null)
    {
        if ($id) {
            $m = SelfManagement::find($id);
            $u = User::find($m->user_id);
            $s = Reservation::where(['customer_id' => $m->user_id])->first();

            // return response()->json([$s],422);

            $this->validate($r,[
                'sin_number' => 'required|unique:reservations,sin_number,'.$s->id,
            ]);

        }else{
            $u = new User;
            $m = new SelfManagement;
            $s = new Reservation;
            $m->call_id = uniqid();

            $this->validate($r,[
                'sin_number' => 'required|unique:reservations',
            ]);
        }

        $u->name = $r->name ? $r->name : "";
        $u->email = $r->email ? $r->email : "";
        $u->password = "";
        $u->role_id = 0;
        $u->status = 1;
        $u->operator_call_id = $r->operator_call_id ? $r->operator_call_id : Auth::user()->id;
        // if (Auth::user()->role_id == -1) {
        // }else{
        //    $u->operator_call_id = Auth::user()->id;
        // }
        $u->save();

        $m->user_id = $u->id;
        $m->company = $r->company ? $r->company : "";
        $m->society = $r->society ? $r->society : "";
        $m->status = 1;
        $m->code = $r->code ? $r->code : "39";
        $m->phone = $r->phone ? $r->phone : "";
        $m->fullphone = $r->code.$r->phone;
        $m->expiration = $r->expiration ? Carbon::createFromFormat('d-m-Y H:i',$r->expiration)->format('Y-m-d H:i') : "";
        if (!$id) {
            $m->url = "";
        }
        $m->save();

        if (!$id) {
            $sh = new Short;
            $sh->url = url('autoperizia?token='.sha1($m->user_id).'/'.$m->user_id.'/'.$m->id);
            $sh->save();
            // $m->url = Bitly::getUrl(url('webapp?token='.sha1($m->user_id).'/'.$m->user_id.'/'.$m->id));
            $m->url = url('short',$sh->id);
            $m->save();
        }

        $s->message = "";
        $s->sin_number = $r->sin_number ? $r->sin_number : "";
        $s->customer_id = $u->id;
        $s->status = 0;
        $s->save();
        if (!$id) {
            $s->made = $s->created_at;
            $s->save();
        }
    }

    public function saveAutoperiziaData(Request $r)
    {
        $sm = SelfManagement::find($r->id);
        $sm->type_iban = $r->iban[0]['url'] ? 'url' : 'string';
        $sm->iban = $r->iban[0]['name'];
        $sm->typology = $r->typology;
        $sm->date = $r->date;
        $sm->ammount = $r->ammount;
        $sm->address = $r->address;
        $sm->status = 0;
        $sm->save();

        if ($r->images) {
            foreach ($r->images as $key => $value) {
                if ($value['confirm']) {
                    $i = new SelfManagementImage;
                    $i->self_management_id = $sm->id;
                    $i->lat = $sm->lat;
                    $i->lng = $sm->lng;
                    $i->address = $r->address;
                    $i->image = $value['name'];
                    $i->save();
                }else{
                    // colocar unlink a imagenes no confirmadas
                }
            }
        }

        if ($r->documents) {
            foreach ($r->documents as $key => $value) {
                $i = new SelfManagementDocument;
                $i->self_management_id = $sm->id;
                $i->lat = $sm->lat;
                $i->lng = $sm->lng;
                $i->address = $r->address;
                $i->document = $value['name'];
                $i->save();
            }
        }

        $o = User::find($sm->user->operator_call_id);

        if ($o) {

            try {
                Mail::send('admin.autoperizia-pdf.email', ['sm' => $sm], function ($message) use($o,$sm) {
                    $message->from('no_reply@expressclaims.it', 'Studio Zappa');
                
                    $message->to($o->email, $o->fullname());
                    // $message->cc('jorgesolano92@gmail.com', $o->fullname());
                 
                    $message->subject('SelfClaims completato da '.$sm->user->fullname());
                });

            } catch(Throwable $e){
                report($e);

                return false;
            }
        }
    }

    public function closeSM($id)
    {
        $sm = SelfManagement::find($id);
        $sm->status = 0;
        $sm->save();

        return back();
    }
}
