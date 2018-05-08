<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Models\Verse;
use Bishopm\Bible\Models\Version;
use Bishopm\Bible\Models\Book;
use Bishopm\Bible\Repositories\VersesRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersesController extends Controller
{
    /**
     * @var VerseRepository
     */
    private $verse;

    public function __construct(VersesRepository $verse)
    {
        $this->verse = $verse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function home()
    {
        return view('bible::home');
    }

    public function verses($version, $book, $chapter)
    {
        return $this->verse->chapter($version, $book, $chapter);
    }

    public function dropdowns()
    {
        $data['books']=Book::all();
        $data['versions']=Version::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $project=$this->projects->find($id);
        $folders=$this->folders->dropdown();
        $tags=Verse::allTags()->get();
        return view('bible::verses.create', compact('folders', 'tags', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($project, CreateVerseRequest $request)
    {
        $verse=$this->verse->create($request->except('context'));
        $verse->tag($request->context);
        return redirect()->route('admin.projects.show', $project)
            ->withSuccess('Task has been created', ['name' => 'Tasks']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Verse $verse
     * @return Response
     */
    public function edit(Verse $verse)
    {
        $folders=$this->folders->dropdown();
        $project=$this->projects->find($verse->project_id);
        $tags=Verse::allTags()->get();
        $atags=array();
        foreach ($verse->tags as $tag) {
            $atags[]=$tag->name;
        }
        return view('bible::verses.edit', compact('verse', 'project', 'folders', 'tags', 'atags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Verse $verse
     * @param  Request $request
     * @return Response
     */
    public function update(Verse $verse, UpdateVerseRequest $request)
    {
        $this->verse->update($verse, $request->except('context'));
        $verse->tag($request->context);
        return redirect()->route('admin.projects.show', $verse->project_id)
            ->withSuccess('Task has been updated', ['name' => 'Task']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Verse $verse
     * @return Response
     */
    public function destroy(Verse $verse)
    {
        $this->verse->destroy($verse);

        return redirect()->route('admin.verses.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('todo::verses.title.verses')]));
    }
}
