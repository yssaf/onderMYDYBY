<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    //

    public function index()
    {
        $quotes = DB::table('quotes')
            ->select('movies.movie_id', 'movies.name', 'movies.released as released', 'quotes.text as text')
            ->join('movies', 'movies.movie_id', '=', 'quotes.movie_id')
            ->get();
        return view( 'admin.quotes', compact('quotes'));
    }

}
