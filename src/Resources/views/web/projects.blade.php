<x-bible::layouts.web pageName="Groups">
    <div class="col-md-12 post-content" data-aos="fade-up">
        <table class="table table-condensed table-borderless table-striped">
            <tr><th colspan="2">Projects</th></tr>
            @forelse ($projects as $project)
                <tr>
                    <td><a href="{{url('/projects/' . $project->slug)}}">{{$project->project}}</a></td>
                    <td>
                        @foreach ($project->tags as $tag)
                            <span class="badge bg-dark"><a class="text-white" href="{{url('/subject/' . $tag->slug)}}">{{$tag->name}}</a></span>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No projects have been added yet.</td>
                </tr>
            @endforelse
        </table>
    </div>
</x-bible::layout>