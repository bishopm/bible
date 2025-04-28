<x-bible::layouts.web pageName="Home">
    <!-- Trending Category Section -->
    <section id="trending-category" class="trending-category section">
      <div class="row g-5">
        <div class="col-lg-4">
          <div class="post-entry lg">
            @if (isset($posts[0]))
              <a href="blog-details.html"><img src="{{ asset('storage/public/' . $posts[0]->image) }}" alt="" class="img-fluid"></a>
              <div class="post-meta"><span class="date">
                @foreach ($posts[0]->tags as $tag)
                  {{$tag->name}} <span class="mx-1">•</span>
                @endforeach
                </span> <span>{{date('d M Y',strtotime($posts[0]->published_at))}}</span>
              </div>
              <h2><a href="{{url('/blog') . '/' . date('Y',strtotime($posts[0]->published_at)) . '/' . date('m',strtotime($posts[0]->published_at)) . '/' . $posts[0]->slug}}">{{$posts[0]->title}}</a></h2>
              {!!$posts[0]->excerpt!!}
            </div>
          @endif
        </div>
        <div class="col-lg-8">
          <div class="row g-5">
            <div class="col-lg-4 border-start custom-border">
              @if (isset($posts[1]))
                <div class="post-entry">
                  <a href="{{url('/blog') . '/' . date('Y',strtotime($posts[1]->published_at)) . '/' . date('m',strtotime($posts[1]->published_at)) . '/' . $posts[1]->slug}}"><img src="{{ asset('storage/public/' . $posts[1]->image) }}" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">
                    @foreach ($posts[1]->tags as $tag)
                      {{$tag->name}} <span class="mx-1">•</span>
                    @endforeach
                  </span> <span>{{date('d M Y',strtotime($posts[1]->published_at))}}</span></div>
                  <h2><a href="{{url('/blog') . '/' . date('Y',strtotime($posts[1]->published_at)) . '/' . date('m',strtotime($posts[1]->published_at)) . '/' . $posts[1]->slug}}">{{$posts[1]->title}}</a></h2>
                </div>
              @endif
              @if (isset($posts[2]))
                <div class="post-entry">
                  <a href="{{url('/blog') . '/' . date('Y',strtotime($posts[2]->published_at)) . '/' . date('m',strtotime($posts[2]->published_at)) . '/' . $posts[2]->slug}}"><img src="{{ asset('storage/public/' . $posts[2]->image) }}" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date"> 
                    @foreach ($posts[2]->tags as $tag)
                      {{$tag->name}} <span class="mx-1">•</span>
                    @endforeach
                    </span> <span>{{date('d M Y',strtotime($posts[2]->published_at))}}</span>
                  </div>
                  <h2><a href="{{url('/blog') . '/' . date('Y',strtotime($posts[2]->published_at)) . '/' . date('m',strtotime($posts[2]->published_at)) . '/' . $posts[2]->slug}}">{{$posts[2]->title}}</a></h2>
                </div>
              @endif
            </div>
            <div class="col-lg-4 border-start custom-border">
              @if (isset($posts[3]))
              <div class="post-entry">
                <a href="{{url('/blog') . '/' . date('Y',strtotime($posts[3]->published_at)) . '/' . date('m',strtotime($posts[3]->published_at)) . '/' . $posts[3]->slug}}"><img src="{{ asset('storage/public/' . $posts[3]->image) }}" alt="" class="img-fluid"></a>
                <div class="post-meta"><span class="date">
                  @foreach ($posts[3]->tags as $tag)
                    {{$tag->name}} <span class="mx-1">•</span>
                  @endforeach
                  </span> <span>{{date('d M Y',strtotime($posts[3]->published_at))}}</span>
                </div>
                <h2><a href="{{url('/blog') . '/' . date('Y',strtotime($posts[3]->published_at)) . '/' . date('m',strtotime($posts[3]->published_at)) . '/' . $posts[3]->slug}}">{{$posts[3]->title}}</a></h2>
              </div>
              @endif
              @if (isset($posts[4]))
              <div class="post-entry">
                <a href="{{url('/blog') . '/' . date('Y',strtotime($posts[4]->published_at)) . '/' . date('m',strtotime($posts[4]->published_at)) . '/' . $posts[4]->slug}}"><img src="{{ asset('storage/public/' . $posts[4]->image) }}" alt="" class="img-fluid"></a>
                <div class="post-meta"><span class="date">
                  @foreach ($posts[4]->tags as $tag)
                    {{$tag->name}} <span class="mx-1">•</span>
                  @endforeach
                  </span> <span>{{date('d M Y',strtotime($posts[4]->published_at))}}</span>
                </div>
                <h2><a href="{{url('/blog') . '/' . date('Y',strtotime($posts[4]->published_at)) . '/' . date('m',strtotime($posts[4]->published_at)) . '/' . $posts[4]->slug}}">{{$posts[4]->title}}</a></h2>
              </div>
              @endif
            </div>
            <!-- Trending Section -->
            <div class="col-lg-4">
              <div class="text-end">
                <table class="table table-sm table-borderless">
                  <tr class="table-dark"><th>Today@theBible</th></tr>
                  @foreach ($residents as $resident)
                    <tr class="table-dark"><td><small><a class="text-white" href="{{url('/' . $resident['slug'])}}">{{$resident['resident']}}</a><br><b>
                      @if ($resident[strtolower(date('l'))])
                        {{$resident[strtolower(date('l'))]}}
                      @else
                        Closed
                      @endif
                      </b></small></td></tr>
                  @endforeach
                  @forelse ($diaryentries as $ttt=>$slot)
                    <tr class="table-info"><th>{{$ttt}}</th></tr>
                    @foreach ($slot as $entry)
                      <tr>
                        <td>
                          <a href="{{url('/groups/' . $entry->diarisable->slug)}}">{{$entry->diarisable->tenant}}</a> 
                          <a href="{{url('/venues/' . $entry->venue->slug)}}"><small>({{$entry->venue->venue}})</small></a>
                        </td>
                      </tr>
                    @empty
                      <tr><td>Nothing booked for today</td></tr>
                    @endforelse
                  @endforeach
                  <tr class="table-dark"><th>Explore</th></tr>
                  <tr>
                    <td>
                      @if (isset($tags))
                        @foreach ($tags as $tag)
                          <a class="badge bg-dark" href="{{url('/subject/' . $tag['slug'])}}">{{$tag['name']}}</a>
                        @endforeach
                      @endif
                    </td>
                  </tr>
                  <tr class="table-dark"><th colspan="100%"><small><a class="text-white" href="{{url('/week')}}">View week bookings</a></small></th></tr>
                </table>
              </div>
            </div> <!-- End Trending Section -->
          </div>
        </div>
      </div> <!-- End .row -->
    </section><!-- /Trending Category Section -->   
</x-bible::layouts.web>