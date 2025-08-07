<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = Transaction::with('order', 'user')->orderBy('created_at','desc')->paginate(10); // Paginate with 10 records per page
    return view('admin.transaction.index', compact('transactions'));
}

    /////////////////////////////////////////
}
