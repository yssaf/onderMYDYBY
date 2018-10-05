<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Genres;
//use App\Http\Requests\Request;
use App\Traits\AdminChecks;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class GenreController extends Controller
{
    //
    use AdminChecks;
    protected $isAdmin;

    public function __construct()
    {
        $this->middleware('web');
        $this->isAdmin = $this->checkUserDetails();
    }



    public function index()
    {
        $genres = Genres::all();
        $user = $this->checkUserDetails();
        return view( 'admin.genres', compact('genres','user'));
    }

    public function show($id)
    {
        return $this->index();
    }



    public function createNewGenre()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $fields = Forms::getFormFields('create_genre', false);
                $app = app();
                $values = $app->make('stdClass');
                $values->movie_id = Session::get('movie_id');

                return (String) view('modal.create_genre', compact('fields', 'values'));
            }
//        }
        return false;
    }


    public function storeNewGenre()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $new_genre = trim(preg_replace("/[^A-Za-z\s]/", '', $data['name']));
//                $attach = $data['attach'];
                $genre_exist = $this->checkExistingGenres($new_genre);
                if(!$genre_exist)
                {
                    $update = Genres::create(['type'=>$new_genre]);
                    return "hello";

//                    return view('movies.genres');
                }
                return "exists";
//                return view('me', compact('data'));
            }
////        }
//        return false;
    }



    private function checkExistingGenres($genre)
    {
        $existing = Genres::where('type', $genre)->count();
        if($existing==0){
            return false;
        }
        else return $existing;
    }

}
