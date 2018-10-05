<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AdminChecks
{
    //
    private function checkUserDetails()
    {
        return Auth::check() ? ( Auth::user() ? Auth::user() : false ) : false;
    }
}