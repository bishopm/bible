<x-bible::layouts.web pageName="{{$page->title}}">
    <div class="col-md-9 post-content" data-aos="fade-up">
        <h1>{{$page->title}}</h1>
        <div style="min-height: 270px;">
            @if ($page->image)
                <img style="float:right; padding-left:10px;" height="250px" src="{{url('/storage/' . $page->image)}}" alt="Image" class="rounded">
            @endif
            {!!$page->content!!}<br><br>
        </div>
    </div>
</x-bible::layout>