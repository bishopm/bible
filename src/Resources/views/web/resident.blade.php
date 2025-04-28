<x-bible::layouts.web pageName="{{$resident->resident}}">
    <div class="col-md-12" data-aos="fade-up">
        <h1>{{$resident->resident}}</h1>
        <div style="min-height: 270px;">
            @if ($resident->image)
                <img style="float:right; padding-left:10px;" src="{{asset('storage/public/' . $resident->image)}}" alt="Image" class="rounded">
            @endif
            {!!$resident->description!!}<br><br>
            @if ($resident->website)
                <p>Website: <a href="{{$resident->website}}" target="_blank">{{$resident->website}}</a></p>
            @endif
            @if ($resident->contact)
                <p>Contact: {{$resident->contact}}</p>
            @endif
        </div>
    </div>
</x-bible::layout>