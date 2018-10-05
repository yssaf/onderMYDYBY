<?php

namespace App\Http\Controllers;


use App\Certificates;
use App\Formats;
use App\Cast;
use App\Crew;
use App\Forms;
use App\Genres;
use App\Keywords;
use App\Movies;
use App\Viewing;
use App\Persons;
use App\Studios;
use App\Traits\AdminChecks;
use App\Traits\SharedFunctions;
use Faker\Provider\Image;
//use App\Http\Requests\Request;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ValidateCreateMovie;

class MovieController extends Controller
{

    use SharedFunctions, AdminChecks;

    private $isAdmin;


    public function __construct()
    {
        $this->middleware('web');
        $this->isAdmin = $this->checkUserDetails();
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $movies = Movies::orderBy('sort_name')
            ->orderBy('released')
            ->paginate(96);
        $user = $this->isAdmin;
        return view('movies.index', compact('movies', 'user'));
    }



    public function strip()
    {
        $movies = Movies::all();
        foreach($movies as $movie)
        {
            $data['id'] = $movie['id'];
            $data['search_name'] = preg_replace('/[^A-Za-z0-9\s]/', '', html_entity_decode($movie['name'], ENT_QUOTES));
            $movie->update($data);
        }
    }




    /**
     *
     * Show selected movie details
     * @param integer $movie_id
     * @return Response
     *
     */
    public function show($movie_id)
    {

        $movie = Movies::findOrFail($movie_id);
        Session::put('movie_id', $movie_id);
        $viewings = $movie->viewings()->select('created_at')->orderBy('created_at', 'desc')->first();
        $movie->last_viewed = $viewings ? date("jS F Y @ g:ia", strtotime($viewings->created_at)) : null;
        $movie->cover = $this->checkImageExists($movie->image, $movie->sort_name, 'covers');
        $movie->cover_count = strlen($movie->cover);
        $movie->rating_display = $this->makeRatingStars($movie->rating);

        $user = $this->isAdmin;
        return view('movies.show', compact('movie', 'user'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        //        if(!$this->isAdmin) return view('auth.login');
        $fields = Forms::getFormFields('create_movie', true);

        $app = app();
        $options = $app->make('stdClass');
        $options->certificates = Certificates::pluck('title', 'certificate_id')->toArray();
        $options->studios = Studios::orderBy('name', 'asc')->pluck('name', 'studio_id')->toArray();
        $options->formats = Formats::pluck('type', 'format_id')->toArray();

        $user = $this->isAdmin;

        return view('movies.create', compact('fields', 'options', 'user'));

    }

    /**
     *
     * Store new movie if the validation passes
     * @param array $request
     * @return Response
     *
     */
    public function store(ValidateCreateMovie $request)
    {
//        if(!$this->isAdmin) return view('auth.login');
        $data = $request->all();
        $data['user_id']=Auth::id();
        $data['sort_name'] = $data['sort_name'] == '' ? trim($data['name']) : trim($data['sort_name']);
        if($request->image)
        {
            $content = file_get_contents($request->image);
            $image_name = $this->createImageName(trim($data['sort_name']));
            $fp = fopen('images/covers/'.$image_name, "w");
            fwrite($fp, $content);
            fclose($fp);

            $img = Image::make('images/covers/'.$image_name);
            $img->resize(300, 450);
            $img->save('images/covers/'.$image_name);
            $data['image'] = $image_name;

        }
        else if($request->hasFile('image_upload'))
        {
            if ($request->file('image_upload')->isValid())
            {
                $image_name = $this->createImageName($data['sort_name']);
                $image = $request->file('image_upload')->move('images/covers', $image_name);
                $data['image'] = $image_name;
            }
        }
        if($data['studio_id']) $data['studio_id'] = is_numeric($data['studio_id']) ? $data['studio_id'] : $this->createNewStudio($data['studio_id']);
        else $data['studio_id'] = 21;
        $data['duplicate'] = $this->checkForDuplicateTitle($request->name);
        $data['purchased'] = date("Y-m-d", strtotime($data['purchased'] ));

        foreach($data as &$value) $value = htmlentities(trim($value), ENT_QUOTES);
        unset($value);

        $created = Movies::create($data);

        return redirect()->action('MovieController@edit', [$created->movie_id])->with('status', 'Movie Added Successfully');
//        return view('me', compact('data'));
    }



    /**
     *
     * Show form to edit existing movie
     * @param integer $movie_id
     * @return Response
     *
     */
    public function edit($movie_id)
    {
//        if(!$this->isAdmin) return view('auth.login');
        Session::put('movie_id', $movie_id);

        $movie = Movies::findOrFail($movie_id);
        $movie->genres;
        $movie->purchased = date("d-m-Y", strtotime($movie->purchased));
        $movie->cover = $this->checkImageExists($movie->image, $movie->sort_name, 'covers');
        $movie->cover_count = strlen($movie->cover);
        $values = json_decode($movie);
//
        $movie->genres = DB::table('categories')->where('movie_id', $movie_id)->pluck('genre_id');
        $movie->tags = DB::table('tags')->where('movie_id', $movie_id)->pluck('keyword_id');
        $fields = Forms::getFormFields('create_movie', true);
//
        $app = app();
        $options = $app->make('stdClass');
        $options->movies = Movies::orderBy('sort_name')->pluck('name', 'movie_id')->toArray();
        $options->certificates = Certificates::pluck('title', 'certificate_id')->toArray();
        $options->studios = Studios::orderBy('name', 'asc')->pluck('name', 'studio_id')->toArray();
        $options->formats = Formats::pluck('type', 'format_id')->toArray();
        $options->actors = Persons::select(DB::raw("CONCAT(forename, ' ', surname) AS full_name"), 'person_id')
            ->whereNotIn('person_id', function($query) use ($movie_id) {
                $query->select('person_id')
                    ->from('casts')
                    ->where('movie_id', $movie_id);
            })
            ->orderBy('forename')
            ->pluck('full_name', 'person_id')->all();
//
        $options->crew = Persons::select(DB::raw("CONCAT(forename, ' ', surname) AS full_name"), 'person_id')
            ->orderBy('forename')
            ->pluck('full_name', 'person_id')->all();
//
        $options->keywords = Keywords::orderBy('word')->get();
        $x = array();
        foreach ($movie->tags as $tag){
            $x[]= $tag;
        }

        foreach($options->keywords as $keyword)
        {
            $keyword->selected = in_array($keyword->keyword_id, $x) ? true : false;
        }

        $options->genres = Genres::all();

        $y = array();
        foreach ($movie->genres as $genre){
            $y[]= $genre;
        }

        foreach($options->genres as $genre)
        {
            $genre->selected = in_array($genre->genre_id, $y) ? true : false;
        }
//
        $user = $this->isAdmin;

        return view('movies.edit', compact('movie', 'fields', 'values', 'options', 'user'));
    }



    /**
     *
     * Update movie with any changes made
     * @param integer $movie_id
     * @param array $request
     * @return Response
     *
     */
    public function update($movie_id, ValidateCreateMovie $request)
    {
//        if(!$this->isAdmin) return view('auth.login');

        $movie = Movies::findOrFail($movie_id);
        $data = $request->all();
        $data['sort_name'] = $data['sort_name'] =='' ? $data['name'] : $data['sort_name'];
//        $data['search_name'] = preg_replace('/[^A-Za-z0-9\s]/', '', $data['name']);
        if($request->hasFile('image_upload'))
        {
            if($request->file('image_upload')->isValid())
            {
                $image_name = $this->createImageName(preg_replace("/[^a-zA-Z0-9]/", '_', $data['sort_name']));
                $image = $request->file('image_upload')->move('images/covers', $image_name);
                $data['image'] = $image_name;
                $this->unlinkExistingImage('covers', $movie->image);
            }
        }
        if($data['studio_id']) $data['studio_id'] = is_numeric($data['studio_id']) ? $data['studio_id'] : $this->createNewStudio($data['studio_id']);
        else $data['studio_id'] = 21;
        $data['purchased'] = date("Y-m-d", strtotime($data['purchased'] ));
        $data['user_id'] = Auth::id();

        $movie->update($data);
//
        if(isset($data['genres']))
        {
            $movie->genres()->sync($data['genres']);
        }
        else
        {
            $movie->genres()->detach();
        }
//
        if(isset($data['tags']))
        {
            $movie->tags()->sync($data['tags']);
        }
        else
        {
            $movie->tags()->detach();
        }

        return redirect()->action('MovieController@edit', [$movie_id])->with('status', 'Movie Updated Successfully');

    }


    /**
     *
     * Delete selected movie from the database
     * @param integer $movie_id
     * @return Response
     *
     */
    public function destroy($movie_id)
    {
        Movies::where('movie_id', '=', $movie_id)->delete();
        return redirect()->action('MovieController@index')->with('status', 'Movie Deleted');
    }


    public function filterMovies($request)
    {
        $data = $request->all();
        $search_string = trim($data['val']);
        if($search_string!="")
        {
            $movies = Movies::select('movies.*')
                ->where('name', 'LIKE', '%'.$search_string.'%')
                ->orderBy('sort_name')
                ->get();

            $people = Persons::where(DB::raw("CONCAT(`forename`, ' ', `surname`)"), 'LIKE', '%'.$search_string.'%')
                ->orderBy('forename')
                ->get();

            $user = $this->isAdmin;
            $quote = count($movies) ? "" : $this->getRandomQuote();

            return view('ajax.movie_filter', compact('movies', 'people', 'quote', 'user'));
        }
    }

    /**
     *
     * Add actor and character name to cast pivot table
     * @return Response
     *
     */
    public function addCastMember()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['movie'];
                $person_id = $data['person'];
                $character_name = $data['character'];
                $star = $data['star'];
                $movie = Movies::findOrFail($movie_id);
                $movie->cast()->attach($person_id, array('character' => $character_name, 'star' => $star));
                return (String) view('movies.existing_cast', compact('movie'));
            }
//        }
//        return "error";
    }


    /**
     *
     * Update character name for exising cast member
     * @return Response
     *
     */
    public function editCastMember()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['movie'];
                $person_id = $data['person'];
                $character_name = $data['character'];
                $star = $data['star'];
                $movie = Movies::findOrFail($movie_id);
                $movie->cast()->updateExistingPivot($person_id, array('character' => $character_name, 'star' => $star));
                return (String) view('movies.cast', compact('movie'));
            }
//        }
//        return "error";
    }


    /**
     *
     * Add crew member and position to crew pivot table
     * @return Response
     *
     */
    public function addCrewMember()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['movie'];
                $person_id = $data['person'];
                $crew_position = $data['position'];
                $movie = Movies::findOrFail($movie_id);
                $movie->crew()->attach($person_id, array('position' => $crew_position));
                return (String) view('movies.crew', compact('movie'));
            }
//        }
        return "error";
    }


    /**
     *
     * Remove cast member from movie
     * @return Response
     *
     */
    public function removeCastMember()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['movie'];
                $cast_id = $data['row'];
                $movie = Movies::findOrFail($movie_id);
                Cast::find($cast_id)->delete();
                return (String) view('movies.cast', compact('movie'));
            }
//        }
//        return "error";
    }


    /**
     *
     * Remove crew member from movie
     * @return Response
     *
     */
    public function removeCrewMember()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['movie'];
                $crew_id = $data['row'];
                $movie = Movies::findOrFail($movie_id);
                Crew::find($crew_id)->delete();
                return (String) view('movies.crew', compact('movie'));
            }
//        }
//        return "error";
    }


    /**
     *
     * Create new tag in database and attach it to movie
     * @return Response
     *
     */
    public function addNewTag()
    {
//        if($this->isAdmin)
//        {
            if(Request::ajax())
            {
                $data = Request::all();
                $movie_id = $data['id'];
                $word = ucwords(strtolower(trim($data['word'])));
                if($word!=="")
                {
                    if(!Keywords::where('word', $word)->exists())
                    {
                        $created = Keywords::create(['word'=>$word]);
                        DB::table('tags')->insert(['movie_id'=>$movie_id, 'keyword_id'=>$created->keyword_id]);

                        $app = app();
                        $options = $app->make('stdClass');

                        $tags = DB::table('tags')->where('movie_id', $movie_id)->pluck('keyword_id');
                        $xx = array();
                        foreach ($tags as $tag){
                            $xx[]= $tag;
                        }
                        $options->keywords = Keywords::all();
                        foreach($options->keywords as $keyword)
                        {
                            $keyword->selected = in_array($keyword->keyword_id, $xx) ? true : false;
                        }
                        return (String) view('movies.tags', compact('options'));
                    }
                    return "exists";
                }
                return "blank";
            }
//        }
        return "error";
    }

    /**
     *
     * Return confirmation modal to copy cast from one movie to another
     * @return Response
     *
     */
    public function confirmDuplicateCast()
    {
        if(Request::ajax())
        {
            $data = $data = Request::all();
            return (String) view('modal.duplicate_cast', compact('data'));
        }
        return false;
    }

    /**
     *
     * Copy existing cast from one movie to another
     * @return View
     *
     */
    public function duplicateCast()
    {
//        if(!$this->isAdmin) return view('auth.login');
        $data = $data = Request::all();
        if(isset($data['id']))
        {
            $existing_movie = Movies::find($data['id']);
            $new_movie_id = Session::get('movie_id');
            $new_cast = [];
            $movie = Movies::findOrFail($new_movie_id);
            foreach($existing_movie->cast as $cast) {
                $new_cast[] = ['movie_id'=>$new_movie_id, 'person_id'=>$cast->pivot->person_id, 'character'=>$cast->pivot->character, 'star'=>$cast->pivot->star];
            }
            $movie->cast()->sync($new_cast);
            return (String) view('movies.cast', compact('movie'));
        }
        return " ";
    }


    /**
     *
     * Takes the given rating and converts it into stars
     * @param integer $rating
     * @return Response
     *
     */
    private function makeRatingStars($rating)
    {
        $html = '';
        $stars = floor($rating/2);
        for($x=0; $x<$stars; $x++) $html .= '<i class="ft icon-star"></i>';
        if($rating%2==1) $html .= '<i class="ft icon-star-half"></i>';
        return $html;
    }


    /**
     *
     * For duplicate titles, show year as well
     * @param string $name
     * @return Response
     *
     */
    private function checkForDuplicateTitle($name)
    {
        return Movies::where('name', $name)->count() > 0 ? true : false;
    }


    /**
     *
     * Check if name exists, if not add to the database
     * @param string $name
     * @return Response
     *
     */
    private function createNewStudio($name)
    {
        $existing = Studios::where('studio_name', $name)->first();
        if(count($existing)==0) {
            $values = ['studio_name'=>$name];
            $update = Studios::create($values);
            return $update->studio_id;
        }
        else return $existing->studio_id;
    }

} // end of class