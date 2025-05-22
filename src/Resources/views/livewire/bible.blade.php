<div class="row">
    <div class="col-md-9">    
        <div class="row">
            <div class="col-1">
                @if($prev_chap>0)
                    <a href="#" wire:click="changeChapter({{$prev_chap}},{{$prev_book}})"><i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i></a> 
                @else
                    <i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i>
                @endif
            </div>
            <div class="col-4">
            <select name="book" class="form-control" wire:model="book_id" wire:change="loadpage()">
                @foreach ($allbooks as $thisbook)
                    @if ($thisbook->id==$book_id)
                        <option selected value="{{$thisbook->id}}"><small>{{$thisbook->book}}</small></option>
                    @else
                        <option value="{{$thisbook->id}}"><small>{{$thisbook->book}}</small></option>
                    @endif
                @endforeach
            </select>
            </div>
            <div class="col-2">
                <select name="chapter" class="form-control" wire:model="chapter" wire:change="loadpage()">
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
            </div>
            <div class="col-4">
                <select name="translation" class="form-control" wire:model="translation" wire:change="loadpage()">
                    @foreach ($translations as $ttt=>$thistranslation)
                        @if ($ttt==$translation)
                            <option selected value="{{$ttt}}"><small>{{$thistranslation}}</small></option>
                        @else
                            <option value="{{$ttt}}"><small>{{$thistranslation}}</small></option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-1">
                @if($next_chap > 0)
                    <a href="#" wire:click="changeChapter({{$next_chap}},{{$next_book}})"><i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i></a>
                @else
                    <i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i>
                @endif
            </div>
        </div>
        @foreach ($verses as $verse)
            @if ($verse->verse==1)
                <a wire:click="shownote({{$verse->verse}})" style="text-decoration:none" href="#"><span style="font-weight:bold; font-size:180%; bottom: -.2em; position:relative;">{{$verse->chapter}}</span></a> {{$verse->words}}
            @else
                <a wire:click="shownote({{$verse->verse}})" style="text-decoration:none" href="#"><sup>{{$verse->verse}}</sup></a> {{$verse->words}}
            @endif
            <br>
        @endforeach
    </div>
    <div class="col-md-3">
      <h3 class="text-center">Notes</h3>
      <div class="text-center">
        @if (!$user)
            <input class="form-control" wire:model="email" placeholder="Email address" wire:change="checkname()">
            <input type="password" class="my-2 form-control" wire:model="password" placeholder="Password">
            @if ($button<>"")
                <input class="my-2 form-control" wire:model="name" placeholder="Name">
                <button class="form-control" wire:click="admituser('{{$button}}')">{{$button}}</button>
            @endif
        @else 
            <h5>{{$user->name}}</h5>
            {{$book->abbreviation}} 
            <select>
                @if ($chapter>1)
                    <option value="{{$chapter-1}}">{{$chapter-1}}</option>
                @endif
                <option selected value="{{$chapter}}">{{$chapter}}</option>
                @if ($chapter<$book->chapters)
                    <option value="{{$chapter+1}}">{{$chapter+1}}</option>
                @endif
            </select>
            <select>
                @php
                    for ($v=1;$v<=count($verses);$v++){
                        print "<option value=\"" . $v . "\">" . $v . "</option>";
                    }
                @endphp
            </select>
            - {{$book->abbreviation}} 
            <select>
                @if ($chapter>1)
                    <option value="{{$chapter-1}}">{{$chapter-1}}</option>
                @endif
                <option selected value="{{$chapter}}">{{$chapter}}</option>
                @if ($chapter<$book->chapters)
                    <option value="{{$chapter+1}}">{{$chapter+1}}</option>
                @endif
            </select>
            <select>
                @php
                    for ($v=1;$v<=count($verses);$v++){
                        print "<option value=\"" . $v . "\">" . $v . "</option>";
                    }
                @endphp
            </select>
            <textarea class="form-control my-2" rows="5" placeholder="New note"></textarea>
        @endif
      </div>
      <div class="text-left">
        @forelse ($notes as $note)
            <b>
                {{$note->start_chapter}}:{{$note->start_verse}}@if ($note->end_chapter)-{{$note->end_chapter}}:{{$note->end_verse}}@elseif ($note->end_verse)-{{$note->end_verse}}@endif
            </b> {{$note->note}}
        @empty
            No notes for this chapter
        @endforelse
      </div>
    </div>
</div>