<?php

namespace App\Http\Controllers;

use App\Keywords;
use App\Traits\AdminChecks;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    //
    use AdminChecks;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $keywords = Keywords::all();
        $user = $this->checkUserDetails();
        return view( 'admin.keywords', compact('keywords','user'));
    }

}
