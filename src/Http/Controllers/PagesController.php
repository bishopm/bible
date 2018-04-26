<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\PagesRepository;
use Bishopm\Bible\Models\Page;
use Bishopm\Bible\Models\Blog;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreatePageRequest;
use Bishopm\Bible\Http\Requests\UpdatePageRequest;

class PagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $page;

	public function __construct(PagesRepository $page)
    {
        $this->page = $page;
    }

	public function index()
	{
        $data['pages'] = $this->page->all();
   		return view('bible::pages.index',$data);
	}

	public function edit(Page $page)
    {
        $tags=Blog::allTags()->get();
        $btags=array();
        foreach ($page->tags as $tag){
            $btags[]=$tag->name;
        }
        $templates = $this->get_templates();
        return view('bible::pages.edit', compact('page','templates','tags','btags'));
    }

    public function create()
    {
        $tags=Blog::allTags()->get();
        $templates = $this->get_templates();
        return view('bible::pages.create',compact('templates','tags'));
    }

    public function store(CreatePageRequest $request)
    {
        $page=$this->page->create($request->except('files','tags'));
        $page->tag($request->tags);
        return redirect()->route('admin.pages.index')
            ->withSuccess('New page added');
    }

    public function update(Page $page, UpdatePageRequest $request)
    {
        $page=$this->page->update($page, $request->except('files','tags'));
        $page->tag($request->tags);
        return redirect()->route('admin.pages.index')->withSuccess('Page has been updated');
    }

    private function get_templates()
    {
        $temps=scandir(base_path() . "/vendor/bishopm/connexion/src/Resources/views/templates");
        foreach ($temps as $template) {
            if (strlen($template)>2){
                $templates[]=str_replace('.blade.php','',$template);
            }
        }
        return $templates;
    }

}
