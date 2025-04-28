<x-bible::layouts.web pageName="{{$project->project}}">
    <div class="col-md-12 post-content" data-aos="fade-up">
        <h3>{{$project->project}}</h3>
        @foreach ($project->tags as $tag)
            <span class="badge bg-dark"><a class="text-white" href="{{url('/subject/' . $tag->slug)}}">{{$tag->name}}</a></span>
        @endforeach
        <br>
        @if ($project->image)
            <img style="float:right; padding-left:10px;" src="{{setting('general.church_storage_url')}}/{{$project->image}}" alt="Image" class="rounded">
        @endif
        {!! $project->description !!}
        @if (isset($project->diaryentries[0]))
            <h4>Next meeting</h4>
            {{date('l, j F Y H:i', strtotime($project->diaryentries[0]->diarydatetime))}} 
            <a href="{{url('/venues/' . $project->diaryentries[0]->venue->slug)}}">({{$project->diaryentries[0]->venue->venue}})</a>
        @endif
    </div>
</x-bible::layout>