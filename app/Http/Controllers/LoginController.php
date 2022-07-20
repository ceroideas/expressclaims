<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Operator;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class LoginController extends Controller
{
    //
    public function login()
    {   
        // Auth::loginUsingId(1);
        // return User::where('email','info@ceroideas.es')->get();
        // foreach (User::find([80]) as $key => $value) {
        //     $value->email = 'info'.$key.'@studiozappa.com';
        //     $value->save();
        // }
        // \App\Claim::get()->last()->delete();
        // return \App\User::where('email','street@mail.com')->first();

        // Schema::table('users', function($table) {
        //     //
        //     $table->string('visualPassword')->nullable();
        // });
        // Schema::table('users', function($table) {
        //     $table->string('device_id')->nullable();
        // });

        // Schema::table('claims', function($table) {
        //     $table->string('damage')->nullable()->before('name');
        // });
        // Schema::dropIfExists('claims');
        // Schema::create('claims', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('claim_id')->default(-1);
        //     $table->string('name');
        //     $table->string('sin_number');
        //     $table->integer('status');
        //     $table->string('email1');
        //     $table->string('email2');
        //     $table->text('information')->nullable();
        //     $table->string('society');
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('claim_files');
        // Schema::create('claim_files', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('sin_number');
        //     $table->integer('user_id');
        //     $table->string('type');
        //     $table->string('file');
        //     $table->string('lat');
        //     $table->string('lon');
        //     $table->text('map_canvas')->nullable();
        //     $table->string('address');
        //     $table->timestamps();
        // });

        // Schema::dropIfExists('claim_videos');

        // Schema::create('pushes', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('title');
        //     $table->text('message');
        //     $table->text('to');
        //     $table->timestamps();
        // });
        // Schema::create('s_m_s', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->text('message');
        //     $table->string('to');
        //     $table->timestamps();
        // });
        // Schema::table('customers', function(Blueprint $table){
        //     $table->string('can_call')->nullable();
        // });
        // Schema::dropIfExists('claims');
        // Schema::create('claims', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('operator_id')->nullable();
        //     $table->integer('customer_id');
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('reservations');
        // Schema::create('reservations', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('sin_number')->nullable();
        //     $table->integer('customer_id');
        //     $table->text('message');
        //     $table->string('status');
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('records');
        // Schema::create('records', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->string('duration');
        //     $table->string('size')->nullable();
        //     $table->string('name');
        //     $table->string('lat')->nullable();
        //     $table->string('lon')->nullable();
        //     $table->string('address')->nullable();
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('tests');
        // Schema::create('tests', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('control');
        //     $table->text('post');
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('videos');
        // Schema::create('videos', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('reservation_id');
        //     $table->string('lat')->nullable();
        //     $table->string('lon')->nullable();
        //     $table->string('address')->nullable();
        //     $table->string('video');
        //     $table->timestamps();
        // });
        // Schema::dropIfExists('files');
        // Schema::create('files', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('reservation_id');
        //     $table->string('lat')->nullable();
        //     $table->string('lon')->nullable();
        //     $table->string('address')->nullable();
        //     $table->longtext('file');
        //     $table->timestamps();
        // });
        // return \App\Test::all();

        // Schema::table('claims', function($table) {
        //     $table->string('reassingned')->nullable();
        // });
    	return view('admin.login');
    }

    public function auth(Request $r)
    {
        // return $r->all();
        // return User::where('email',$r->email)->first();

    	$this->validate($r,[
    		'email' => 'email|required',
    		'password' => 'required',
            'g-recaptcha-response' => 'required'
    	],[
            'g-recaptcha-response.required' => 'Il campo g-recaptcha-response è obbligatorio.',
        ]);

    	if (Auth::attempt(['email' => $r->email, 'password' => $r->password],true)) {
            
            // if (Auth::user()->role_id != 1 && Auth::user()->role_id != -1) {

            if (Auth::user()->status == 0) {
                Auth::logout();
                return back();
            }
            $role = Auth::user()->role_id;

            if ($role != -1) {
                if (!Auth::user()->operator) {
                    $c = new Operator;
                    $c->user_id = Auth::user()->id;
                    $c->save();
                }
            }
            
            return redirect('/admin/dashboard');

            // if ($role == 1) {
            //     return redirect('/admin/videocalls');
                
            // }
            // if ($role == 2) {
            //     return redirect('/admin/express-tech/elenco');
                
            // }
            // if ($role == 3) {
            //     return redirect('/admin/mappa');
                
            // }
            // if ($role == -1) {
            // }

    	}else{
            return back()->with('warning','It was not possible to log in, please check your data');
        }
    }
}
