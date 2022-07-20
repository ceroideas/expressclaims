<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Operator;
use Response;
use Validator;
use Auth;

class StreetOperatorController extends Controller
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
        return view('admin.street-operators.index');
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
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);

        $u = new user;
        $u->name = $r->name.'|'.$r->lastname;
        $u->email = $r->email;
        $u->google_calendar_email = $r->google_calendar_email;
        $u->street_phone = $r->street_phone;
        $u->role_id = $r->supervisor ? 1 : 2;
        $u->status = 1;
        $u->supervisor = $r->supervisor ? 1 : NULL;
        $u->operator_call_id = "";
        $u->password = bcrypt($r->password);
        $u->visualPassword = $r->password;
        $u->save();

        $c = Operator::where('user_id',$u->id)->first();
        if (!$c) {
            $c = new Operator;
        }
        $c->user_id = $u->id;
        
        $c->ec = $r->ec ? 1 : null;
        $c->mp = $r->mp ? 1 : null;
        $c->et = $r->et ? 1 : null;

        $c->save();

        return ['send_message' => $u->id];
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
        $e_c = User::find($id);

        return view('admin.street-operators.index',compact('e_c'));
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
        ]);

        $u = User::find($id);
        $u->name = $r->name.'|'.$r->lastname;
        $u->email = $r->email;
        $u->google_calendar_email = $r->google_calendar_email;
        $u->role_id = $r->supervisor ? 1 : 2;
        $u->supervisor = $r->supervisor ? 1 : NULL;
        $u->street_phone = $r->street_phone;
        if (isset($r->password)) {   
            $u->password = bcrypt($r->password);
            $u->visualPassword = $r->password;
        }
        $u->save();

        // if ($r->supervisor) {
        $c = Operator::where('user_id',$u->id)->first();
        if (!$c) {
            $c = new Operator;
        }
        $c->user_id = $u->id;
        
        $c->ec = $r->ec ? 1 : null;
        $c->mp = $r->mp ? 1 : null;
        $c->et = $r->et ? 1 : null;

        $c->save();
        // }else{
        //     $c = Operator::where('user_id',$u->id)->first();
        //     if ($c) {
        //         $c->delete();
        //     }
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $u = User::find($id)->delete();
        // borrar registros?
        return redirect('admin/accertatore');
    }
    public function disable($id)
    {
        //
        $u = User::find($id);
        $u->status == 0 ? $u->status = 1 : $u->status = 0;
        $u->save();
        // borrar registros?
        return back();
    }
}
