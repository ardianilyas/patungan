<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $totalTransactions = (int) Transaction::where('status', ['success', 'SUCCEEDED'])->sum('amount');
        $totalUsers = (int) User::all()->count();
        return inertia('Dashboard', compact([
            'totalTransactions',
            'totalUsers',
        ]));
    }
}
