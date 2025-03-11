<?php

namespace App\Http\Controllers;

use App\Events\DonationSent;
use App\Http\Requests\DonationRequest;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function index($name) {
        $creator = User::query()->where('name', $name)->firstOrFail(['id', 'name']);

        return inertia('Donation', compact('creator'));
    }

    public function donate(DonationRequest $request, $name): RedirectResponse {
        $sender = Auth::user();
        $creator = User::query()->where('name', $name)->first();

        if ($request->amount > $sender->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance']);
        }

        $tax = $request->amount * 0.05;
        $amountAfterTax = $request->amount - $tax;

        DB::beginTransaction();
        try {

            // create donation
            $donation = Donation::query()->create([
                'sender_id' => $sender->id,
                'receiver_id' => $creator->id,
                'actual_amount' => $request->amount,
                'amount_after_tax' => $amountAfterTax,
                'message' => $request->message,
                'status' => 'success'
            ]);
            Log::info('Donation created: ', [$donation]);

            $transaction = $donation->transaction()->create([
                'type' => 'donation',
                'user_id' => $sender->id,
                'amount' => $request->amount,
                'status' => $donation->status,
            ]);
            Log::info('Transaction created: ', [$transaction]);

            // update sender balance (decrement)
            $sender->balance -= $request->amount;
            $sender->save();
            Log::info("Sender {$sender->name} balance updated: ", [$sender]);

            // update creator balance (increment)
            $creator->balance += $amountAfterTax;
            $creator->save();
            Log::info("Creator {$creator->name} balance updated: ", [$creator]);

            DB::commit();

            event(new DonationSent($request->message, $creator, $sender, $request->amount));

            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
