<div class="row">
    <div class="col-md-9">    
        <div class="row">
            <div class="col-12 input-group">
                @if($prev_chap>0)
                    <a href="#" wire:click="changeChapter({{$prev_chap}},{{$prev_book}})"><i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i></a> 
                @else
                    <i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i>
                @endif
                <select name="book" class="form-control" wire:model="book_id" wire:change="loadpage()"  style="width:90px; margin-left:10px;">
                    @foreach ($allbooks as $thisbook)
                        @if ($thisbook->id==$book_id)
                            <option selected value="{{$thisbook->id}}"><small>{{$thisbook->abbreviation}}</small></option>
                        @else
                            <option value="{{$thisbook->id}}"><small>{{$thisbook->abbreviation}}</small></option>
                        @endif
                    @endforeach
                </select>
                <select name="chapter" class="form-control" wire:model="chapter" wire:change="loadpage()" style="width:65px;">
                    @php
                        for ($i=1;$i<=$book->chapters;$i++){
                            if ($i==$chapter){
                                print "<option selected value=\"" . $i . "\">" . $i . "</option>";
                            } else {
                                print "<option value=\"" . $i . "\">" . $i . "</option>";
                            }
                        }
                    @endphp
                </select>
                <select name="translation" class="form-control" wire:model="translation" wire:change="loadpage()" style="width:70px; margin-right:10px;">
                    @foreach ($translations as $ttt=>$thistranslation)
                        @if ($ttt==$translation)
                            <option selected value="{{$ttt}}"><small>{{strtoupper($ttt)}}</small></option>
                        @else
                            <option value="{{$ttt}}"><small>{{strtoupper($ttt)}}</small></option>
                        @endif
                    @endforeach
                </select>
                @if($next_chap > 0)
                    <a href="#" wire:click="changeChapter({{$next_chap}},{{$next_book}})"><i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i></a>
                @else
                    <i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i>
                @endif
            </div>
        </div>
        @foreach ($verses as $thisverse)
            @if ($thisverse->verse==1)
                <a wire:click="shownote({{$thisverse->verse}})" style="text-decoration:none" href="#"><span style="font-weight:bold; font-size:180%; bottom: -.2em; position:relative;">{{$thisverse->chapter}}</span></a> {{$thisverse->words}}
            @else
                <a wire:click="shownote({{$thisverse->verse}})" style="text-decoration:none" href="#"><sup>{{$thisverse->verse}}</sup></a> {{$thisverse->words}}
            @endif
            <br>
        @endforeach
    </div>
    <div class="col-md-3" style="border-style:solid; border-width:1px;">
        <ul class="nav nav-pills justify-content-center py-3">
            <li class="nav-item">
                <button class="nav-link active" id="notes-tab" data-bs-toggle="pill" data-bs-target="#notes" type="button" role="tab">Notes</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="user-tab" data-bs-toggle="pill" data-bs-target="#user" type="button" role="tab"><i class="bi bi-person-fill"></i></button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                @if ($showform)
                    <div class="text-center">
                        @if ($user)
                            {{$book->abbreviation}} 
                            <select wire:model="startchap">
                                @if ($chapter>1)
                                    <option value="{{$chapter-1}}">{{$chapter-1}}</option>
                                @endif
                                <option selected value="{{$chapter}}">{{$chapter}}</option>
                                @if ($chapter<$book->chapters)
                                    <option value="{{$chapter+1}}">{{$chapter+1}}</option>
                                @endif
                            </select>
                            <select wire:model="startverse">
                                @php
                                    for ($v=1;$v<=count($verses);$v++){
                                        if ($startverse==$v){
                                            print "<option selected value=\"" . $v . "\">" . $v . "</option>";
                                        } else {
                                            print "<option value=\"" . $v . "\">" . $v . "</option>";
                                        }
                                    }
                                @endphp
                            </select>
                            - {{$book->abbreviation}} 
                            <select wire:model="endchap">
                                @if ($chapter>1)
                                    <option value="{{$chapter-1}}">{{$chapter-1}}</option>
                                @endif
                                <option selected value="{{$chapter}}">{{$chapter}}</option>
                                @if ($chapter<$book->chapters)
                                    <option value="{{$chapter+1}}">{{$chapter+1}}</option>
                                @endif
                            </select>
                            <select wire:model="endverse">
                                @php
                                    for ($v=1;$v<=count($verses);$v++){
                                        if ($endverse==$v){
                                            print "<option selected value=\"" . $v . "\">" . $v . "</option>";
                                        } else {
                                            print "<option value=\"" . $v . "\">" . $v . "</option>";
                                        }
                                    }
                                @endphp
                            </select>
                            <input type="hidden" wire:model="note_id">
                            <textarea wire:model="note" class="form-control my-2" rows="5" placeholder="New note"></textarea>
                            <div class="btn-group" role="group">
                                <button class="form-control" wire:click="saveform">Save</button>
                                <button class="form-control" wire:click="toggleform(false)">Cancel</button>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="text-left">
                    <ul class="list-unstyled">
                        @forelse ($notes as $note)
                            <li>
                                <b>
                                    @if ($note->start_chapter>=$note->end_chapter and $note->start_verse>=$note->end_verse)
                                        <a style="text-decoration: none;" href="#" wire:click="editnote({{$note->id}})"><sup>{{$note->start_verse}}</sup></a>
                                    @elseif ($note->start_chapter==$note->end_chapter)
                                        <a style="text-decoration: none;" href="#" wire:click="editnote({{$note->id}})"><sup>{{$note->start_verse}}-{{$note->end_verse}}</sup></a>
                                    @else                                    
                                        <a style="text-decoration: none;" href="#" wire:click="editnote({{$note->id}})"><sup>{{$note->start_chapter}}:{{$note->start_verse}}</sup></a>
                                    @endif
                                </b> {{$note->note}}
                            </li>
                        @empty
                            No notes for this chapter
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                @if (!$user)
                    <input class="form-control" wire:model="email" placeholder="Email address" wire:change="checkname()">
                    <input type="password" class="my-2 form-control" wire:model="password" placeholder="Password">
                    @if ($button<>"")
                        <input class="my-2 form-control" wire:model="name" placeholder="Name">
                        <button class="form-control" wire:click="admituser('{{$button}}')">{{$button}}</button>
                    @endif
                @else 
                    <h5>
                        {{$user->name}} 
                        <i style="font-size: 1rem;" class="bi-x-square-fill"></i>
                    </h5>
                @endif
            </div>
        </div>
    </div>
</div>