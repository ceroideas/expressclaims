<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkStreet($id)
    {
        return $a = Claim::where(['user_id'=>$this->id,'sin_number'=>$id])->first();
    }

    public function operator()
    {
        return $this->hasOne('App\Operator');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer');
    }
    public function webapp()
    {
        return $this->hasOne('App\WebAppUser');
    }
    public function selfmanagement()
    {
        return $this->hasOne('App\SelfManagement');
    }

    public function lastMessageAdmin()
    {
        $res = Reservation::where(['customer_id'=>$this->id,'status'=>1])->get()->last();
        if (!$res) {
            return '---';
        }
        $m = Message::where(['from_id'=>$this->id,'reservation_id'=>$res->id])->first();
        if ($m) {
            return $m->message;
        }
        return '---';
    }
    public function lastMessage()
    {
        $res = Reservation::where(['customer_id'=>$this->id,'status'=>1])->get()->last();
        if (!$res) {
            return '---';
        }
        $m = Message::where(['from_id'=>$this->id, 'to_id' => \Auth::user()->id,'reservation_id'=>$res->id])->first();
        if ($m) {
            return $m->message;
        }
        return '---';
    }
    public function lastMessageDateAdmin()
    {
        $res = Reservation::where(['customer_id'=>$this->id,'status'=>1])->get()->last();
        if (!$res) {
            return '---';
        }
        $m = Message::where(['from_id'=>$this->id,'reservation_id'=>$res->id])->first();
        if ($m) {
            return $m->created_at;
        }
        return '---';   
    }
    public function lastMessageDate()
    {
        $res = Reservation::where(['customer_id'=>$this->id,'status'=>1])->get()->last();
        if (!$res) {
            return '---';
        }
        $m = Message::where(['from_id'=>$this->id, 'to_id' => \Auth::user()->id,'reservation_id'=>$res->id])->first();
        if ($m) {
            return $m->created_at;
        }
        return '---';   
    }

    public function lastSinisterAmb()
    {
        $res = Reservation::where(['customer_id'=>$this->id])->get()->last();
        if ($res) {
            return $res;
        }
    }

    public function lastSinister()
    {
        $res = Reservation::where(['customer_id'=>$this->id, 'status'=>0])->get()->last();
        if ($res) {
            return $res;
        }
    }

    public function lastSinisterClose()
    {
        $res = Reservation::where(['customer_id'=>$this->id, 'status'=>1])->get()->last();
        if ($res) {
            return $res;
        }
    }

    public function lastSinisterAdmin()
    {
        $res = Reservation::where(['customer_id'=>$this->id,'status'=>0])->first();
        if ($res) {
            return $res;
        }
    }
    public function lastContact()
    {
        if ($this->webapp) {
            $r = Record::where('user_id',$this->id)->whereExists(function($q){
                $q->from('reservations')
                  ->whereRaw('reservations.id = records.reservation_id');
            })->get()->last();

            if ($r) {
                return $r->created_at->format('d-m-Y H:i:s');
            }
            
        }else{
            $r = Record::where('user_id',$this->id)->whereExists(function($q){
                $q->from('reservations')
                  ->whereRaw('reservations.id = records.reservation_id')
                  ->whereRaw('reservations.status = 0');
            })->get()->last();

            if ($r) {
                return $r->created_at->format('d-m-Y H:i:s');
            }
        }
        return "---";
    }

    public function name() {
        return @explode('|',$this->name)[0];
    }
    public function lastname() {
        return @explode('|',$this->name)[1];   
    }
    public function fullname() {
        return @explode('|',$this->name)[0].' '.@explode('|',$this->name)[1];
    }
    public function fullnameRev() {
        return @explode('|',$this->name)[1].' '.@explode('|',$this->name)[0];
    }

    public function checkTypeUser()
    {
        if ($this->webapp) {
            return 'WebApp';
        }
        if ($this->customer) {
            return 'Customer';
        }
        if ($this->selfmanagement) {
            return 'AUTOPerizia';
        }
    }

    public function checkTypeUser2($field)
    {
        if ($this->webapp) {
            return $this->webapp[$field];
        }
        if ($this->customer) {
            return $this->customer[$field];
        }
        if ($this->selfmanagement) {
            return $this->selfmanagement[$field];
        }
    }
    public function phone()
    {
        return $this->checkTypeUser2('phone');
    }
    public function address()
    {
        return $this->checkTypeUser2('address');
    }
}
