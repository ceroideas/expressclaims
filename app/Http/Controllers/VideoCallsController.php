<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use App\User;
use App\Customer;
use App\Message;
use App\Image;
use App\Record;
use App\Reservation;
use App\WebAppUser;
use Carbon\Carbon;
use _Image;

class VideoCallsController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->role_id == -1) {
            return back();
        }
    	return view('admin.operator');
    }

    public function user_status($id)
    {
    	$u = User::find($id);
        if ($u->customer) {
            $date = Carbon::parse($u->customer->updated_at)->format('d-m-Y H:i:s');
            $call_id = $u->customer->call_id;
            $lat = $u->customer->lat;
            $lng = $u->customer->lng;
        }else{
            $date = Carbon::parse($u->webapp->updated_at)->format('d-m-Y H:i:s');
            $call_id = $u->id;
            $lat = $u->webapp->lat ? $u->webapp->lat : 0;
            $lng = $u->webapp->lng ? $u->webapp->lng : 0;
        }

    	return ['call_id' => $call_id,'fake_call_id' => str_pad($u->id,5,0), 'lat' => $lat, 'lng' => $lng, 'user_id' => $u->id, 'date' => $date];
     //    if ($u->status == 1) {
    	// }

    	// return Response::json(['User offline'],422);
    }

    public function operator_call_id(Request $r)
    {
        Auth::user()->operator_call_id = $r->operator_call_id;
        Auth::user()->save();
        return [$r->operator_call_id, Customer::where('operator_id',Auth::user()->id)->select('call_id')->get()];
    }

    public function loadMessages(Request $r)
    {
        if ($r->res) {
            $res = Reservation::find($r->res);
        }else{
            $res = Reservation::where('customer_id',$r->to_id)->where('status',0)->first();
        }

        $c = Customer::where('user_id',$r->to_id)->first();
        $m = Message::where(function($q) use($r) {

            $q->where(function($q) use($r){
                $q->where('from_id',$r->from_id)->where('to_id',$r->to_id);
            })->orWhere(function($q) use($r){
                $q->where('from_id',$r->to_id)->where('to_id',$r->from_id);
            });

            //     $q->where('from_id',$r->from_id)->where('to_id',$r->to_id);
            // })->orWhere(function($q) use($r) {
            //     $q->where('from_id',$r->to_id)->where('to_id',$r->from_id);
        })
        ->where('reservation_id',$res->id)
        ->with('from','to')->get();

        foreach ($m as $key => $value) {
            $value->created = $value->created_at->format('d M, H:i');
        }

        $i = [Image::where(['user_id'=>$r->to_id,'reservation_id'=>$res->id,'type'=>1])->orderBy('id','desc')->get(),Image::where(['user_id'=>$r->to_id,'reservation_id'=>$res->id,'type'=>4])->orderBy('id','desc')->get()];


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


                $value->full_imagen = url('uploads/users/'.$r->to_id.'/'.$res->sin_number.'/images',$value->imagen);
                $value->imagen = url('uploads/users/'.$r->to_id.'/'.$res->sin_number.'/images','t_'.$value->imagen);
            }
        }

        return [$m,$i,isset($c) ? $c->can_call : 0];
    }

    public function receiveImage(Request $r)
    {
        $u = Customer::where('call_id',$r->senderId)->first();

        if (!$u) {
            $u = WebAppUser::where('user_id',$r->senderId)->first();
        }

        $res = Reservation::where('customer_id',$u->user_id)->where('status',0)->first();

        $i = [Image::where(['user_id'=>$u->user_id,'reservation_id'=>$res->id,'type'=>1])->orderBy('id','desc')->get(),Image::where(['user_id'=>$u->user_id,'reservation_id'=>$res->id,'type'=>4])->orderBy('id','desc')->get()];        

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

                $value->full_imagen = url('uploads/users/'.$u->user_id.'/'.$res->sin_number.'/images',$value->imagen);
                $value->imagen = url('uploads/users/'.$u->user_id.'/'.$res->sin_number.'/images','t_'.$value->imagen);
            }
        }

        return $i;
    }

    public function deleteImage(Request $r)
    {
        $i = Image::find($r->id);
        $i->delete();
    }

    public function saveMessage(Request $r)
    {
        $res = Reservation::where('customer_id',$r->to_id)->where('status',0)->first();
        if ($res) {
            $m = new Message;
            $m->from_id = $r->from_id;
            $m->to_id = $r->to_id;
            $m->message = $r->message;
            $m->reservation_id = $res->id;
            $m->save();
        }
    }

    public function inCallNull(Request $r){
        $u = User::find($r->id);
        $u->inCall = null;
        $u->save();

        return $u;
    }
    public function inCallTrue(Request $r){
        $u = User::find($r->id);
        $u->inCall = Auth::user()->id;
        $u->save();

        return $u;
    }
    public function findInCall(Request $r){
        $u = User::find($r->id);
        $i = User::find($u->inCall);

        return $i->name.' '.$i->lastname;
    }

    public function save_record_data(Request $r)
    {
        $rec = new Record;
        $rec->user_id = $r->user_id;
        $rec->duration = $r->duration;
        $rec->confId = $r->confId;
        $rec->userId1 = $r->userId1;
        $rec->userId2 = $r->userId2;

        $rec->address = $r->address;
        $rec->lat = $r->lat;
        $rec->lon = $r->lon;

        $rec->save();

        return Record::where('user_id',$r->user_id)->with('user')->get();
    }
    public function close_request(Request $r, $id)
    {
        foreach (Reservation::where('customer_id',$id)->get() as $key => $value) {
            $value->status = 1;
            $value->save();

            $u = User::find($id);
            if ($u->webapp) {
                $u->webapp->expiration = Carbon::now()->format('Y-m-d H:i:s');
                $u->webapp->save();
            }
        }

        return back();
    }

    public function loadRest()
    {
        // return User::where('role_id',0)->where(function($q){
        // $q->where('operator_call_id',Auth::user()->id)->orWhereExists(function($q){
        //     $q->from('customers')
        //       ->whereRaw('customers.user_id = users.id')
        //       ->whereRaw('operator_id = '.Auth::user()->id);
        // });
        // })->whereExists(function($q){
        //     $q->from('reservations')
        //       ->whereRaw('reservations.customer_id = users.id')
        //       ->whereRaw('reservations.status = 0')
        //       ->whereRaw('reservations.sin_number != ""');
        // })->orderBy('created_at','desc')->get();
        return view('admin.customers-list')->render();
    }
}
