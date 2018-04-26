<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\TransactionsRepository;
use Bishopm\Bible\Repositories\BooksRepository;
use Bishopm\Bible\Models\Transaction;
use Bishopm\Bible\Models\Book;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateTransactionRequest;
use Bishopm\Bible\Http\Requests\UpdateTransactionRequest;

class TransactionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $transaction;
    private $book;

    public function __construct(TransactionsRepository $transaction, BooksRepository $book)
    {
        $this->transaction = $transaction;
        $this->book = $book;
    }

    public function index()
    {
        $transactions = $this->transaction->all();
        return view('bible::transactions.index', compact('transactions'));
    }

    public function edit(Transaction $transaction)
    {
        $books=$this->book->all();
        return view('bible::transactions.edit', compact('transaction', 'books'));
    }

    public function create()
    {
        $books=$this->book->all();
        return view('bible::transactions.create', compact('books'));
    }

    public function show(Transaction $transaction)
    {
        $data['transaction']=$transaction;
        return view('bible::transactions.show', $data);
    }

    public function store(CreateTransactionRequest $request)
    {
        $transaction=$this->transaction->create($request->all());
        $book=Book::find($transaction->book_id);
        if ($transaction->transactiontype=="Add stock") {
            $book->stock=$book->stock + $transaction->units;
        } else {
            $book->stock=$book->stock - $transaction->units;
        }
        $book->save();
        return redirect()->route('admin.transactions.index')
            ->withSuccess('New transaction added');
    }
    
    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transaction->update($transaction, $request->all());
        return redirect()->route('admin.transactions.index')->withSuccess('Transaction has been updated');
    }

    public function summary()
    {
        $thismonth=date('Y-m');
        $lastday=date('t');
        $data['transactions']=Transaction::where('transactiondate', '>=', $thismonth . '-01')->where('transactiondate', '<=', $thismonth . '-' . $lastday)->orderBy('transactiondate')->get();
        $sales=0;
        foreach ($data['transactions'] as $trans) {
            if (($trans->transactiontype<>'Add stock') and ($trans->transactiontype<>'Shrinkage')) {
                $sales=$sales + $trans->units * $trans->unitamount;
            }
        }
        $data['sales']=number_format($sales, 2);
        return view('bible::transactions.summary', $data);
    }
}