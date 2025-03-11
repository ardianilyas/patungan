<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DonationHistoryController extends Controller
{
    public function index() {
        $donations = Auth::user()->donations()->with('sender')->get();

        return inertia('dashboard/DonationHistory', compact('donations'));
    }
}
