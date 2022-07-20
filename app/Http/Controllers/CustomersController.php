<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Customer;

use App\Message;
use App\Image;
use App\Video;
use App\File;
use App\Reservation;
use App\Record;
use App\Test;
use App\SMS;

use Response;
use Validator;
use Auth;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->role_id != -1) {
            return back();
        }
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //
        $this->validate($r,[
            'email' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required'
        ]);

        $u = new User;
        $u->name = $r->name;
        $u->email = $r->email;
        $u->role_id = 0;
        $u->status = 1;
        $u->password = bcrypt($r->password);
        $u->save();

        $c = new Customer;
        $c->user_id = $u->id;
        $c->phone = $r->phone;
        $c->address = $r->address;
        $c->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $e_c = Customer::where('id',$id)->whereExists(function($q){
                    $q->from('users')
                      ->whereRaw('users.id = customers.user_id')
                      ->whereRaw('users.status = 1');
                })->first();

        return view('admin.customers.index',compact('e_c'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        //
        $this->validate($r,[
            'email' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $c = Customer::find($id);

        $u = User::find($c->user_id);
        $u->name = $r->name;
        $u->email = $r->email;
        if (isset($r->password)) {   
            $u->password = bcrypt($r->password);
        }
        $u->save();

        $c->phone = $r->phone;
        $c->address = $r->address;
        $c->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = Customer::find($id);
        $u = User::find($c->user_id);

        Message::where('to_id',$u->id)->orWhere('from_id',$u->id)->delete();
        Image::where('user_id',$u->id)->delete();
        Video::where('user_id',$u->id)->delete();
        Reservation::where('customer_id',$u->id)->delete();
        Record::where('user_id',$u->id)->delete();

        SMS::where('to','like','%'.$c->phone.'%')->delete();
        $u->delete();
        $c->delete();

        return back();
    }
}
