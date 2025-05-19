<?php

namespace Bishopm\Bible\Livewire;

use Bishopm\Bible\Models\Book;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $prev_chap, $next_chap, $prev_book, $allbooks, $book_id, $book, $next_book, $chapter, $translations, $translation, $verse, $verses;

    public function mount()
    {
        $this->translation="niv";
        $this->chapter=1;
        $this->book_id=1;
        $this->translations=[
            'gnt'=>'Good News Translation',
            'niv'=>'New International Version',
            'msg'=>'The Message'
        ];
        $this->book=Book::find($this->book_id);
        $this->allbooks=Book::all();
        $this->prev_chap=0;
        $this->next_chap=2;
        /*
        if ($this->chapter>1){
            $this->prev_chap=$this->chapter-1;
            $this->prev_book=$this->book;
        } elseif ($this->book>1){
            $prevbook=Book::find($this->book-1);
            $this->prev_chap=$prev_book->chapters;
            $this->prev_book=$this->book-1;
        } else {
            $this->prev_chap=0;
            $this->prev_book=$this->book;
        }
        if ($this->chapter<$this->book->chapters){
            $this->next_chap=$this->chapter+1;
            $this->next_book=$this->book;
        } elseif ($this->book<66){
            $this->next_chap=1;
            $this->next_book=$this->book+1;
        } else {
            $this->next_chap=0;
            $this->next_book=$this->book;
        }*/
        $this->verses=DB::table($this->translation . '_verses')->where('book_id',$this->book_id)->where('chapter',$this->chapter)->orderBy('verse','ASC')->get();        dd($this->verses);
    }

    public function render(){
        return view('bible::livewire.dashboard');
    }
}
