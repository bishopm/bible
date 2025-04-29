<x-bible::layouts.web pageName="Home">
  <style>
    .vno {
      vertical-align: text-top;
      font-weight: bold;
      position: relative;
      display: inline;
      line-height: normal;
      top: auto;
    }
  </style>
  <div class="row">
    <div class="col-md-8">
      @foreach ($verses as $verse)
        @if ($verse->verse==1)
          <h5>
            @if($prev_chap>0)
              <a href="{{url('/' . $translation . '/' . $prev_book . '/' . $prev_chap)}}"><i class="bi-arrow-left-square-fill"></i></a> 
            @else
              <i class="bi-arrow-left-square-fill"></i>
            @endif
            <select class="form-control">
              @foreach ($allbooks as $thisbook)
                <option value="{{$thisbook->id}}"><small>{{$thisbook->book}}</small></option>
              @endforeach
            </select>
            <select class="form-control">
              @foreach ($translations as $ttt=>$thistranslation)
                <option value="{{$ttt}}"><small>{{$thistranslation}}</small></option>
              @endforeach
            </select>
            @if($next_chap>0)
              <a href="{{url('/' . $translation . '/' . $next_book . '/' . $next_chap)}}"><i class="bi-arrow-right-square-fill"></i></a>
            @else
              <i class="bi-arrow-right-square-fill"></i>
            @endif
          </h5>
          <span style="font-weight:bold; font-size:180%; bottom: -.2em; position:relative;">{{$verse->chapter}}</span> {{$verse->words}}
        @else
          <sup class="vno">{{$verse->verse}}</sup> {{$verse->words}}
        @endif
      @endforeach
    </div>
    <div class="col-md-4">
      <h3 class="text-center">Notes</h3>
    </div>
  </div>
</x-bible::layouts.web>