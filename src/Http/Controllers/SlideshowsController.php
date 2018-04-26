<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\SlideshowsRepository;
use Bishopm\Bible\Models\Slideshow;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateSlideshowRequest;
use Bishopm\Bible\Http\Requests\UpdateSlideshowRequest;

class SlideshowsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $slideshow;

	public function __construct(SlideshowsRepository $slideshow)
    {
        $this->slideshow = $slideshow;
    }

	public function index()
	{
        $slideshows = $this->slideshow->all();
   		return view('bible::slideshows.index',compact('slideshows'));
	}

	public function edit(Slideshow $slideshow)
    {
        return view('bible::slideshows.edit', compact('slideshow'));
    }

    public function create()
    {
        return view('bible::slideshows.create');
    }

	public function show(Slideshow $slideshow)
	{
        $data['slideshow']=$slideshow;
        return view('bible::slideshows.show',$data);
	}

    public function store(CreateSlideshowRequest $request)
    {
        $slideshow=$this->slideshow->create($request->all());
        return redirect()->route('admin.slideshows.index')
            ->withSuccess('New slideshow added');
    }
	
    public function update(Slideshow $slideshow, UpdateSlideshowRequest $request)
    {
        $this->slideshow->update($slideshow, $request->all());
        return redirect()->route('admin.slideshows.index')->withSuccess('Slideshow has been updated');
    }

}