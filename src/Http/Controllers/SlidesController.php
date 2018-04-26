<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\SlidesRepository;
use Bishopm\Bible\Models\Slide;
use Bishopm\Bible\Models\Slideshow;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateSlideRequest;
use Bishopm\Bible\Http\Requests\UpdateSlideRequest;

class SlidesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $slide;

    public function __construct(SlidesRepository $slide)
    {
        $this->slide = $slide;
    }

    public function index()
    {
        $slides = $this->slide->all();
        return view('bible::slides.index', compact('slides'));
    }

    public function edit(Slideshow $slideshow, Slide $slide)
    {
        return view('bible::slides.edit', compact('slide', 'slideshow'));
    }

    public function create(Slideshow $slideshow)
    {
        return view('bible::slides.create', compact('slideshow'));
    }

    public function show(Slide $slide)
    {
        $data['slide']=$slide;
        return view('bible::slides.show', $data);
    }

    public function store(CreateSlideRequest $request)
    {
        $slide=$this->slide->create($request->all());
        return redirect()->route('admin.slideshows.show', $request->input('slideshow_id'))
            ->withSuccess('New slide added');
    }
    
    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $this->slide->update($slide, $request->all());
        return redirect()->route('admin.slideshows.show', $request->input('slideshow_id'))->withSuccess('Slide has been updated');
    }

    public function destroy($id)
    {
        $slide=$this->slide->find($id);
        $slideshow=$slide->slideshow_id;
        $slide->delete();
        return redirect()->route('admin.slideshows.show', $slideshow)->withSuccess('Slide has been deleted');
    }
}
