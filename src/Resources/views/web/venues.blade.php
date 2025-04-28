<x-bible::layouts.web pageName="Groups">
    <div class="col-md-12 post-content" data-aos="fade-up">
        <table class="table table-condensed table-borderless table-striped">
            <tr><th>Venues</th></tr>
            @forelse ($venues as $venue)
                <tr>
                    <td><a href="{{url('/venues/' . $venue->slug)}}">{{$venue->venue}}</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No venues have been added yet.</td>
                </tr>
            @endforelse
        </table>
    </div>
</x-bible::layout>