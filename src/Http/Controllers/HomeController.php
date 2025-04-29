<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Models\Book;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home($book=1,$chapter=1,$verse=1){
        $data['book']=Book::find($book);
        $data['verses']=DB::table('gnt_verses')->where('book_id',$book)->where('chapter',$chapter)->orderBy('verse','ASC')->get();
        return view('bible::web.home',$data);
    }
}
