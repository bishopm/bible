<?php

namespace Bishopm\Bible\Livewire;

use Bishopm\Bible\Models\Book;
use Bishopm\Bible\Models\Note;
use Bishopm\Bible\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Bible extends Component
{
    public $prev_chap, $next_chap, $prev_book, $allbooks, $book_id, $book, $next_book, $chapter, $translations, $translation, $verse, $verses;
    public $user, $name, $password, $email, $button, $notes, $startverse, $endverse, $showform, $note, $note_id;

    public function mount()
    {
        $this->button="";
        $this->translation="niv";
        $this->chapter=1;
        $this->book_id=1;
        $this->translations=[
            'gnt'=>'Good News Translation',
            'msg'=>'The Message',
            'niv'=>'New International Version'
        ];
        $this->loadpage();
        if (Auth::check()){
            $this->user=Auth::user();
        }
        $this->startverse=1;
        $this->endverse=1;
        $this->showform=false;
    }

    public function loadpage(){
        $this->book=Book::find($this->book_id);
        $this->allbooks=Book::all();
        if ($this->chapter > 1){
            $this->prev_chap=$this->chapter-1;
            $this->prev_book=$this->book_id;
        } elseif ($this->book_id>1){
            $this->prev_book=Book::find($this->book_id-1);
            $this->prev_chap=$this->prev_book->chapters;
            $this->prev_book=$this->book_id-1;
        } else {
            $this->prev_chap=0;
            $this->prev_book=$this->book_id;
        }
        if ($this->chapter < $this->book->chapters){
            $this->next_chap=$this->chapter+1;
            $this->next_book=$this->book_id;
        } elseif ($this->book_id<66){
            $this->next_chap=1;
            $this->next_book=$this->book_id+1;
        } else {
            $this->next_chap=0;
            $this->next_book=$this->book_id;
        }
        $this->verses=DB::table($this->translation . '_verses')->where('book_id',$this->book_id)->where('chapter',$this->chapter)->orderBy('verse','ASC')->get();
        $this->updatenotes();
    }

    public function changeChapter($chap,$bk){
        $this->chapter=$chap;
        $this->book_id=$bk;
        $this->loadpage();
    }
    
    public function checkname(){
        $user=User::where('email',$this->email)->first();
        if ($user){
            $this->name=$user->name;
            $this->button="Login";
        } else {
            $this->button="Register";
        }
    }

    public function admituser($action){
        if ($action=="Register"){
            $this->user=User::create([
                'email'=>$this->email,
                'name'=>$this->name,
                'password'=>Hash::make($this->password)
            ]);
            Auth::login($this->user);
        } else {
            $success = auth()->attempt([
                'email' => $this->email,
                'password' => $this->password
            ]);
            if ($success){
                $this->user=User::where('email',$this->email)->first();
                Auth::login($this->user);
            }
        }
    }

    public function shownote($verse){
        $this->startverse=intval($verse);
        $this->endverse=intval($verse);
        $this->toggleform(true);
    }

    public function toggleform($status){
        $this->showform=$status;
    }

    public function updatenotes(){
        $this->notes=Note::with('user')->where(function ($q) { $q->where('book_id',$this->book_id)->where('start_chapter',$this->chapter); })
            ->orWhere(function ($q) { $q->where('book_id',$this->book_id)->where('end_chapter',$this->chapter); })->get();
    }

    public function render(){
        return view('bible::livewire.bible');
    }

    public function saveform(){
        if ($this->note_id){
            dd('Updating an existing note with: ' . $this->note);
        } else {
            $new = Note:: create([
                'user_id'=>auth()->user()->id,
                'visibility'=>'public',
                'book_id'=>$this->book->id,
                'start_chapter'=>$this->chapter,
                'end_chapter'=>$this->chapter,
                'start_verse'=>intval($this->startverse),
                'end_verse'=>intval($this->endverse),
                'note'=>$this->note
            ]);
        }
        $this->showform=false;
        $this->updatenotes();
    }
}
