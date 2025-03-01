<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index() {
        $transactions = Auth::user()->transactions()->latest()->get();
        return inertia('dashboard/Transactions', compact('transactions'));
    }
}
