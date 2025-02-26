<?php

namespace App\Http\Controllers;

use App\Services\TopupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopupController extends Controller
{
    private TopupService $topupService;
    public function __construct(TopupService  $topupService) {
        $this->topupService = $topupService;
    }

    public function index() {
        return inertia('Topup');
    }

    public function store(Request $request) {
        $request->validate([
            'amount' => 'required|integer|min:1000'
        ]);

        $invoice = $this->topupService->createInvoice($request->amount);

        return inertia('Topup', with(['invoice' => $invoice['invoice_url']]));
    }

    public function handleWebhook(Request $request) {
        $webhookToken = config('services.xendit.webhook_token');
        $receivedSignature = $request->header('x-callback-token');

        if (!$this->topupService->verifySignature($receivedSignature, $webhookToken)) {
            Log::warning('Invalid Xendit webhook signature', ['signature' => $receivedSignature]);
        }

        $payload = $request->all();

        try {
            $this->topupService->processWebhook($payload);
            Log::info('Webhook processed', ['payload' => $payload]);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', ['error' => $e->getMessage(), 'payload' => $payload]);
        }
    }
}
