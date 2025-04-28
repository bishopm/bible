<x-bible::layouts.web pageName="{{$group->tenant}}">
    <div class="col-md-12 post-content" data-aos="fade-up">
        <h3>{{$group->tenant}}</h3>
        @foreach ($group->tags as $tag)
            <span class="badge bg-dark"><a class="text-white" href="{{url('/subject/' . $tag->slug)}}">{{$tag->name}}</a></span>
        @endforeach
        <br>
        @if ($group->image)
            <img style="float:right; padding-left:10px;" src="{{setting('general.church_storage_url')}}/{{$group->image}}" alt="Image" class="rounded">
        @endif
        {!! $group->description !!}
        @if (isset($group->diaryentries[0]))
            <h4>Next meeting</h4>
            {{date('l, j F Y H:i', strtotime($group->diaryentries[0]->diarydatetime))}} 
            <a href="{{url('/venues/' . $group->diaryentries[0]->venue->slug)}}">({{$group->diaryentries[0]->venue->venue}})</a>
        @endif
    </div>
</x-bible::layout>