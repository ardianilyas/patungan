<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index() {
        $transactions = Auth::user()->transactions()->orderBy('created_at', 'desc')->get()->groupBy(function ($transaction) {
            return $transaction->created_at->format('j F Y');
        });
        return inertia('dashboard/Transactions', compact('transactions'));
    }
}
