<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Models\Book;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home(){
        return view('bible::web.home');
    }

    public function login(){
        return view('bible::web.login');
    }
}
