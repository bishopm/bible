<div>
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
            <span style="font-weight:bold; font-size:180%; bottom: -.2em; position:relative;">{{$verse->chapter}}</span> {{$verse->words}}
        @else
            <sup>{{$verse->verse}}</sup> {{$verse->words}}
        @endif
    @endforeach
</div>