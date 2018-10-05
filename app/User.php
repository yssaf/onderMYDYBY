<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password','level','active','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function role(){
        return $this->hasOne('App\Role', 'role_id', 'role_id');
    }

    private function checkIfUserHasRole($need_role){
        return (strtolower($need_role) == strtolower($this->role->name)) ? true : false;
    }

    public function hasRole($roles){
        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkIfUserHasRole($need_role)){
                    return true;
                }
            }
        }else{
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }



    public function isAdmin (){

        // return $this->role->name;

        if($this->role->name == 'administrator' && $this->is_active == 1){

            return true;
        }

        return false;
    }
}
