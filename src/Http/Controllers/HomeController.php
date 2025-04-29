<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Models\Book;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home($translation="gnt",$book=1,$chapter=1,$verse=1){
        $data['translation']=$translation;
        $data['book']=Book::find($book);
        if ($chapter>1){
            $data['prev_chap']=$chapter-1;
            $data['prev_book']=$book;
        } elseif ($book>1){
            $prevbook=Book::find($book-1);
            $data['prev_chap']=$prevbook->chapters;
            $data['prev_book']=$book-1;
        } else {
            $data['prev_chap']=0;
            $data['prev_book']=$book;
        }
        if ($chapter<$data['book']->chapters){
            $data['next_chap']=$chapter+1;
            $data['next_book']=$book;
        } elseif ($book<66){
            $data['next_chap']=1;
            $data['next_book']=$book+1;
        } else {
            $data['next_chap']=0;
            $data['next_book']=$book;
        }
        $data['verses']=DB::table($translation . '_verses')->where('book_id',$book)->where('chapter',$chapter)->orderBy('verse','ASC')->get();
        return view('bible::web.home',$data);
    }
}
