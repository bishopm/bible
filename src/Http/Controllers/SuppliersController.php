<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\SuppliersRepository;
use Bishopm\Bible\Repositories\BooksRepository;
use Bishopm\Bible\Models\Supplier;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateSupplierRequest;
use Bishopm\Bible\Http\Requests\UpdateSupplierRequest;

class SuppliersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $supplier, $books;

	public function __construct(SuppliersRepository $supplier, BooksRepository $books)
    {
        $this->supplier = $supplier;
        $this->books = $books;
    }

	public function index()
	{
        $suppliers = $this->supplier->all();
   		return view('bible::suppliers.index',compact('suppliers'));
	}

	public function edit(Supplier $supplier)
    {
        $books = $this->books->getByAttributes(array('supplier_id'=>$supplier->id));
        return view('bible::suppliers.edit', compact('supplier','books'));
    }

    public function create()
    {
        return view('bible::suppliers.create');
    }

	public function show(Supplier $supplier)
	{
        $data['supplier']=$supplier;
        return view('bible::suppliers.show',$data);
	}

    public function store(CreateSupplierRequest $request)
    {
        $this->supplier->create($request->all());

        return redirect()->route('admin.suppliers.index')
            ->withSuccess('New supplier added');
    }
	
    public function update(Supplier $supplier, UpdateSupplierRequest $request)
    {
        $this->supplier->update($supplier, $request->all());
        return redirect()->route('admin.suppliers.index')->withSuccess('Supplier has been updated');
    }

}