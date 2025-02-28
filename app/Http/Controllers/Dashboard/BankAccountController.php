<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index() {
        $banks = Bank::all();
        $userBank = [];
        $isUserBankExist = Auth::user()->bank()->exists();

        if($isUserBankExist) {
            $userBank = UserBank::where('user_id', Auth::id())->get();
        }

        return inertia('dashboard/BankAccount', compact('banks', 'userBank'));
    }

    public function store(Request $request) {
        $isExists = Auth::user()->bank()->exists();

        if($isExists) {
            Auth::user()->bank()->update([
                'channel_code' => $request->bank,
                'account_holder_name' => $request->name,
                'account_number' => $request->number,
            ]);
        }

        Auth::user()->bank()->create([
            'channel_code' => $request->bank,
            'account_holder_name' => $request->name,
            'account_number' => $request->number,
        ]);

        return back();
    }
}
