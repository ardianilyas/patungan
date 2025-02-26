<?php

namespace App\Services;

use App\Models\Topup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class TopupService
{
    private $api;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
        $this->api = new InvoiceApi();
    }

    public function createTopup($external_id, $amount) {
        return Topup::query()->create([
            'user_id' => Auth::user()->id,
            'external_id' => $external_id,
            'amount' => $amount
        ]);
    }

    public function createInvoice($amount) {
        $external_id = 'Topup-' . uniqid();

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'description' => 'Topup invoice',
            'amount' => $amount,
            'payer_email' => Auth::user()->email,
            'invoice_duration' => 172800,
            'success_redirect_url' => route('topup.index'),
            'currency' => 'IDR',
            'reminder_time' => 1
        ]);

        try {
            DB::beginTransaction();
            $invoice = $this->api->createInvoice($create_invoice_request);
            DB::commit();

            $this->createTopup($external_id, $amount);

            Log::info('Invoice accepted', (array)$invoice['invoice_url']);
            return $invoice;
        } catch (\Xendit\XenditSdkException $e) {
            DB::rollBack();
            Log::info('Invoice declined', (array)$e->getMessage());
            return 0;
        }
    }

    public function verifySignature($receivedSignature, $webhookToken): bool {
        return hash_equals($receivedSignature, $webhookToken);
    }

    public function processWebhook($payload) {
        $eventType = $payload['status'] ?? 'unknown';

        switch ($eventType) {
            case 'PAID':
                $this->handleTopupPaid($payload);
                break;
            case 'FAILED':
                $this->handleTopupFailed($payload);
                break;
            default:
                Log::info('Unhandled webhook event', ['event' => $eventType, 'payload' => $payload]);
        }
    }

    public function handleTopupPaid(array $payload): void {
        $external_id = $payload['external_id'];
        $amount = $payload['amount'];
        $status = $payload['status'];

        if($status === 'PAID') {
            try {
                DB::beginTransaction();

                $topup = Topup::query()->where('external_id', $external_id)->first();

                $topup->update([
                    'status' => 'paid',
                    'amount' => $amount,
                    'paid_at' => now()
                ]);

                $user = User::query()->where('id', $topup->user_id)->first();

                $userBalance = $user['balance'];

                $user['balance'] = $userBalance + $amount;
                $user->save();

                DB::commit();
                Log::info("User balance updated", [$user['email'], $user['balance']]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::info('Error processing webhook', (array)$e->getMessage());
            }
        }
    }
    public function handleTopupFailed(array $payload): void {
        $external_id = $payload['external_id'];
        $status = $payload['status'];

        if($status === 'FAILED') {
            try {
                DB::beginTransaction();
                $topup = Topup::query()->where('external_id', $external_id)->first();
                $topup->update([
                    'status' => 'failed',
                ]);
                DB::commit();
                Log::info("Topup status updated to FAILED");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::info('Error processing webhook', (array)$e->getMessage());
            }
        }
    }
}
