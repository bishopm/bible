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
  @foreach ($verses as $verse)
    @if ($verse->verse==1)
      <h5>
        @if($prev_chap>0)
          <a href="{{url('/' . $translation . '/' . $prev_book . '/' . $prev_chap)}}"><i class="bi-arrow-left-square-fill"></i></a> 
        @else
          <i class="bi-arrow-left-square-fill"></i>
        @endif
        {{$book->book}} 
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
</x-bible::layouts.web>