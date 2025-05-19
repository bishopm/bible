<div>
    <form method="post">
        <div class="row">
            <div class="col-1">
            @if($prev_chap>0)
                <a href="{{url('/' . $translation . '/' . $prev_book . '/' . $prev_chap)}}"><i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i></a> 
            @else
                <i style="font-size: 1.65rem;" class="bi-arrow-left-square-fill"></i>
            @endif
            </div>
            <div class="col-4">
            <select name="book" class="form-control" onchange="this.form.submit()">
                @foreach ($allbooks as $thisbook)
                @if ($thisbook->id==$book_id)
                    <option selected value="{{$thisbook->id}}"><small>{{$thisbook->book}}</small></option>
                @else
                    <option value="{{$thisbook->id}}"><small>{{$thisbook->book}}</small></option>
                @endif
                @endforeach
            </select>
            </div>
            <div class="col-1">
            <select name="chapter" class="form-control" onchange="this.form.submit()">
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
            <div class="col-5">
            <select name="translation" class="form-control" onchange="this.form.submit()">
                @foreach ($translations as $ttt=>$thistranslation)
                <option value="{{$ttt}}"><small>{{$thistranslation}}</small></option>
                @endforeach
            </select>
            </div>
            <div class="col-1">
            @if($next_chap>0)
                <a href="{{url('/' . $translation . '/' . $next_book . '/' . $next_chap)}}"><i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i></a>
            @else
                <i style="font-size: 1.65rem;" class="bi-arrow-right-square-fill"></i>
            @endif
            </div>
        </div>
        </form>
        @foreach ($verses as $verse)
            <span style="font-weight:bold; font-size:180%; bottom: -.2em; position:relative;">{{$verse->chapter}}</span> {{$verse->words}}
        @endforeach
</div>
