<x-bible::layouts.web pageName="{{$venue->venue}}">
    <div class="col-md-12 post-content" data-aos="fade-up">
        <h3>{{$venue->venue}}</h3>
        <br>
        {!! $venue->description !!}
    </div>
</x-bible::layout>