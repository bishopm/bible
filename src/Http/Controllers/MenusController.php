<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\MenusRepository;
use Bishopm\Bible\Repositories\MenuitemsRepository;
use Bishopm\Bible\Models\Menu;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateMenuRequest;
use Bishopm\Bible\Http\Requests\UpdateMenuRequest;

class MenusController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $menu, $menuitems;

	public function __construct(MenusRepository $menu, MenuitemsRepository $menuitems)
    {
        $this->menuitems = $menuitems;
        $this->menu = $menu;
    }

	public function index()
	{
        $data['menus'] = $this->menu->all();
   		return view('bible::menus.index',$data);
	}

	public function edit(Menu $menu)
    {
        $data['menuitems'] = $this->menuitems->arrayForMenu($menu->id);
        $data['menu'] = $menu;
        return view('bible::menus.edit', $data);
    }

    public function create()
    {
        return view('bible::menus.create');
    }

    public function store(CreateMenuRequest $request)
    {
        $this->menu->create($request->all());

        return redirect()->route('admin.menus.index')
            ->withSuccess('New menu added');
    }

    public function update(Menu $menu, UpdateMenuRequest $request)
    {
        $this->menu->update($menu, $request->all());
        return redirect()->route('admin.menus.index')->withSuccess('Menu has been updated');
    }

}
