<x-bible::layouts.web pageName="Subject">
    <div class="container">
        <div class="row">
            <h1 class="text-uppercase">{{ucwords(str_replace('-', ' ', $slug))}}</h1>
            @if (count($groups))
                <div class="col-md-4 post-content" data-aos="fade-up">
                    <h4>Groups</h4>
                    @foreach ($groups as $group)
                        <a href="{{url('/groups') . '/' .  $group->slug}}">{{$group->tenant}}</a><br>
                    @endforeach
                </div>
            @endif
            @if (count($projects))
                <div class="col-md-4 post-content" data-aos="fade-up">
                    <h4>Projects</h4>
                    @foreach ($projects as $project)
                        <a href="{{url('/projects') . '/' . $project->slug}}">{{$project->project}}</a><br>
                    @endforeach
                </div>
            @endif
            @if (count($posts))
                <div class="col-md-4 post-content" data-aos="fade-up">
                    <h4>Blog posts</h4>
                    @foreach ($posts as $post)
                        <a href="{{url('/blog') . '/' . date('Y',strtotime($post['published_at'])) . '/' . date('m',strtotime($post['published_at'])) . '/' . $post['slug']}}">{{$post['title']}}</a><br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-bible::layout>                
