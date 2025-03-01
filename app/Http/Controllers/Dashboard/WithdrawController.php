<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    private WithdrawService $withdrawService;

    public function __construct(WithdrawService $withdrawService) {
        $this->withdrawService = $withdrawService;
    }

    public function index() {
        $isHaveBankAccount = Auth::user()->bank()->exists();
        return inertia('dashboard/Withdraw', compact('isHaveBankAccount'));
    }

    public function withdraw(WithdrawRequest $request) {
        $userBalance = Auth::user()->balance;

        $amountAfterTax = $request->amount - 4000;

        if ($userBalance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance']);
        }

        $data['amount'] = (int)$amountAfterTax;
        $data['actual_amount'] = $request->amount;
        $data['account_holder_name'] = 'Ardian Ilyas';
        $data['account_number'] = '00004444';

        $this->withdrawService->withdraw($data);

        return back();
    }

    public function handleWebhook(Request $request) {
        if (!$this->withdrawService->verifySignature($request->header('x-callback-token'))) {
            Log::warning('Invalid webhook token: ', (array)$request->all());
        }

        $this->withdrawService->handleWebhook($request->all());
    }
}
