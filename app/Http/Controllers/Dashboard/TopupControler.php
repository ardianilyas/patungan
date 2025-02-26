<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupControler extends Controller
{
    public function index() {
        $topups = Auth::user()->topups()->latest()->get();

        return inertia('dashboard/Topup', compact('topups'));
    }
}
