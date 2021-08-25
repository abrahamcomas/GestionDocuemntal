<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;

class Cerrar extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function index(Request $request)
    { 
        Auth::logout();
        Session::flush();
           return Redirect::to('/');
    }

public function NoLogin(Request $request)
    { 
        return Redirect::to('/');
    }
}
