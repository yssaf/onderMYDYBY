<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    use AuthenticatesUsers;
    protected $username = 'email';
    protected $redirectTo = '/welcome';
    protected $guard = 'web';



    public function getLogin(){
        if(Auth::guard('web')->check()){
            return redirect()->route('welcome');
        }
        return view('login');
    }


    public function postLogin(Request $request){
        $auth = Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

        if($auth){
            return redirect()->route('/');
        }
        return redirect()->route('/');
    }

    public function getLogout(){
        Auth::guard('web')->logout();
        return redirect()->route('/');
    }
}
