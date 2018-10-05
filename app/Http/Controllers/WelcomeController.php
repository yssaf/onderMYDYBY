<?php

namespace App\Http\Controllers;

use App\Crew;
use App\Movies;
use App\Persons;
use App\Traits\SharedFunctions;
use App\Traits\AdminChecks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    //

    use SharedFunctions, AdminChecks;


    private $isAdmin;

    public function index(){

        $app = app();
        $details = $app->make('stdClass');

        // most recent purchases
        $details->most_recent = Movies::getMovieRecords('purchased', 'DESC', 20);

        // top rated movies
        $details->top_rated = Movies::getTopRated();
        foreach($details->top_rated as $movie)
        {
            $movie->rating_display = $this->makeRatingStars($movie->rating);
        }


        // get most popular actors
        $details->actors = Persons::getActorCount(24);

        // get most popular directors
        $details->directors = Persons::getDirectorCount(24);

        $details->birthdays = Persons::getTodaysBirthdays();
        foreach($details->birthdays as $birthday)
        {
            $birthday->age = $this->calculateAge($birthday->birthday, $birthday->deceased);
        }


        // highlight randomly selected movie
        $random_id = Movies::selectRandomFilm();
        $details->highlight = Movies::findorfail($random_id);
        $details->highlight->cast = $details->highlight->cast->take(3);
        $details->highlight->crew = Crew::where('movie_id', $random_id)
            ->select(DB::raw('GROUP_CONCAT(CONCAT(persons.forename, " ", persons.surname) SEPARATOR ", ") as list'))
            ->join('persons', 'persons.person_id', '=', 'crews.person_id')
            ->groupBy('movie_id')
            ->where('position', 'Director')->take(1)->get();
        $details->highlight->cover_count = strlen($details->highlight->cover);
        $details->highlight->rating_display = $this->makeRatingStars($details->highlight->rating);

        $details->decades = $this->makeDecades();

        $user = $this->isAdmin;


        return view('welcome', compact('details', 'user'));
    }


    /*
* --------------------------------------------------
* Private Functions
* --------------------------------------------------
*/


    private function makeRatingStars($rating)
    {
        $html = '';
        $stars = floor($rating/2);
        for($x=0; $x<$stars; $x++) $html .= '<i class="ft icon-star"></i>';
        if($rating%2==1) $html .= '<i class="ft icon-star-half"></i>';
        return $html;
    }

    private function makeDecades()
    {
        $decades = [];
        $start = 1920;
        $end = floor(date("Y")/10)*10;
        for($decade=$start; $decade<=$end; $decade+=10)
        {
            $decades[$decade] = $decade;
        }
        return $decades;
    }
}
