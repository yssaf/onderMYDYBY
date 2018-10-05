<?php

namespace App\Http\Controllers;

use App\Traits\AdminChecks;
use App\Traits\SharedFunctions;
use App\Viewing;
use Illuminate\Support\Facades\Request;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewingController extends Controller
{
    //

    use SharedFunctions, AdminChecks;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $viewings = Viewing::select('viewings.created_at', 'movies.name')
            ->join('movies', 'movies.movie_id', '=', 'viewings.movie_id')
            ->orderBy('viewings.created_at', 'desc')
            ->orderBy('movies.sort_name', 'asc')
            ->get();
        foreach($viewings as $viewing)
        {
            $viewing->viewed = $this->formatDate($viewing->created_at, 'display');
        }
        $user = $this->checkUserDetails();
        return view( 'admin.viewings', compact('viewings','user'));
    }



    public  function createMovieViewing()
    {
        if(Request::ajax())
        {
            return (String) view('modal.create_viewing');
        }
        return false;
    }

    /**
     * Store the movie viewing.
     *
     * @return Response
     */
    public function storeMovieViewing()
    {
        if(Request::ajax())
        {
            $data['movie_id'] = Session::get('movie_id');
            $update = Viewing::create($data);
            $app = app();
            $message = $app->make('stdClass');
            $message->type = 'success';
            $message->text = 'Viewing stored.';
            return (String) view('layouts.messages.message', compact('message'));
        }
        return false;
    }

}
