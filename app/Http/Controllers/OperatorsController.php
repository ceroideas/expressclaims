<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Operator;
use Response;
use Validator;
use Auth;

class OperatorsController extends Controller
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
        return view('admin.operators.index');
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
        $u->name = $r->name;
        $u->email = $r->email;
        $u->role_id = $r->map ? 3 : 1;
        $u->status = 1;
        $u->operator_call_id = 0;
        $u->password = bcrypt($r->password);
        $u->visualPassword = $r->password;
        $u->save();

        $c = new Operator;
        $c->user_id = $u->id;
        $c->ec = $r->ec ? 1 : null;
        $c->mp = $r->mp ? 1 : null;
        $c->et = $r->et ? 1 : null;
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
        $e_c = Operator::where('id',$id)->whereExists(function($q){
                    $q->from('users')
                      ->whereRaw('users.id = operators.user_id')
                      ->whereRaw('users.status = 1');
                })->with('user')->first();

        // return $e_c;

        return view('admin.operators.index',compact('e_c'));
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
        $c = Operator::find($id);

        $this->validate($r,[
            'email' => 'required|unique:users,email,'.$c->user_id,
            'name' => 'required',
        ]);

        $u = User::find($c->user_id);
        $u->name = $r->name;
        $u->email = $r->email;
        $u->role_id = $r->map ? 3 : 1;
        if ($r->password) {
            $u->password = bcrypt($r->password);
            $u->visualPassword = $r->password;
        }
        $u->save();

        $c->ec = $r->ec ? 1 : null;
        $c->mp = $r->mp ? 1 : null;
        $c->et = $r->et ? 1 : null;

        $c->save();

        return $u;
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
    }
}
