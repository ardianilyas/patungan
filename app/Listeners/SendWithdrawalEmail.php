<?php

namespace App\Listeners;

use App\Events\WithdrawalProcessed;
use App\Mail\WithdrawalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWithdrawalEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(WithdrawalProcessed $event)
    {

    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalProcessed $event): void
    {
        $user = $event->withdraw->user;
        Mail::to($user)->queue(new WithdrawalNotification($event->withdraw));
        Log::info("Withdrawal email send successfully: ", [$event]);
    }
}
