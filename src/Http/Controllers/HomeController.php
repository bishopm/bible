<?php

namespace Bishopm\Bible\Http\Controllers;


class HomeController extends Controller
{
    public function home(){
        return view('bible::web.home');
    }
}
