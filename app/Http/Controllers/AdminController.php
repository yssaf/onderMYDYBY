<?php

namespace App\Http\Controllers;

use App\Movies;
use App\Persons;
use App\Traits\AdminChecks;
use App\Traits\SharedFunctions;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    use SharedFunctions, AdminChecks;

    private $isAdmin;

    public function __construct(){
        $this->middleware('web');
//        $this->isAdmin = $this->checkUserDetails();
    }



    public function index()
    {
//        if(!$this->isAdmin) return redirect()->action('WelcomeController@index');
        $app = app();
        $data = $app->make('stdClass');
        $data->movie_total = Movies::all()->count();
        $data->person_total = Persons::all()->count();
        $data->running_total = Movies::all()->sum('running_time');
        $total_days = floor($data->running_total/1440) == 1 ? floor($data->running_total/1440)." day, " : floor($data->running_total/1440)." days, ";
        $total_hours = floor(($data->running_total%1440)/60) == 1 ? floor(($data->running_total%1440)/60)." hour and " : floor(($data->running_total%1440)/60)." hours and ";
        $total_minutes = (($data->running_total%1440)%60) ==1 ? (($data->running_total%1440)%60)." minute" : (($data->running_total%1440)%60)." minutes";
        $data->watching_time = $total_days.$total_hours.$total_minutes;

//        $user = $this->isAdmin;

        return view('admin.index', compact('data', 'user'));
//        return view('admin.index');
    }

}
