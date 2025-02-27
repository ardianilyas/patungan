<?php

namespace App\Services;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Payout\CreatePayoutRequest;
use Xendit\Payout\PayoutApi;
use Xendit\XenditSdkException;

class WithdrawService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }

    public function createWithdraw($reference_id, $data) {
        return Withdraw::query()->create([
            'user_id' => auth()->id(),
            'reference_id' => $reference_id,
            'currency' => 'IDR',
            'amount' => $data['amount'],
            'account_holder_name' => $data['account_holder_name'],
            'account_number' => $data['account_number'],
        ]);
    }

    public function findWithdrawByReferenceId($reference_id) {
        return Withdraw::query()->where('reference_id', $reference_id)->first();
    }

    public function updateWithdraw(Withdraw $withdraw, $data) {
        $withdraw['payout_id'] = $data['id'];
        $withdraw['channel_code'] = $data['channel_code'];
        $withdraw['channel_category'] = $data['channel_category'];

        if ($data['status'] === 'SUCCEEDED') {
            $withdraw['status'] = 'success';
        } elseif ($data['status'] === 'FAILED') {
            $withdraw['status'] = 'failed';
        }

        $withdraw->save();
        return $withdraw;
    }

    public function createTransaction(Withdraw $withdraw, $data) {
        return $withdraw->transaction()->create([
            'user_id' => $withdraw['user_id'],
            'type' => 'withdraw',
            'amount' => $withdraw['amount'],
            'status' => $withdraw['status'],
            'payment_channel' => $data['channel_category'],
        ]);
    }

    public function updateUserBalance(Withdraw $withdraw, $amount) {
        $user = User::query()->where('id', $withdraw['user_id'])->first();
        $user['balance'] -= $amount;
        $user->save();
        return $user;
    }

    public function withdraw(array $data) {
        $api = new PayoutApi();

        $idempotency_key = uniqid();
        $reference_id = 'DISB-' . uniqid();

        $payload = new CreatePayoutRequest([
            'reference_id' => $reference_id,
            'currency' => 'IDR',
            'channel_code' => 'ID_BCA',
            'channel_properties' => [
                'account_holder_name' => $data['account_holder_name'],
                'account_number' => $data['account_number'],
            ],
            'amount' => $data['amount'],
            'description' => 'Withdrawal',
            'type' => 'DIRECT_DISBURSEMENT'
        ]);

        try {
            DB::beginTransaction();
            $withdraw = $this->createWithdraw($reference_id, $data);

            $user = $this->updateUserBalance($withdraw, $data['actual_amount']);
            Log::info('User balance updated: ', [$user]);

            $result = $api->createPayout($idempotency_key, '', $payload);
            Log::info('Payout created : ', [$result, $user]);

            DB::commit();
            return 0;
        } catch (XenditSdkException $e) {
            DB::rollBack();
            Log::error('Error creating payout: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error creating payout, check your bank credentials.']);
        }
    }

    public function verifySignature($receivedToken) {
        $webhookToken = config('services.xendit.webhook_token');
        return hash_equals($webhookToken, $receivedToken);
    }

    public function handleWebhook(array $payload) {
        $data = $payload['data'];

        Log::info('Webhook received: ', (array)$payload);

        try {
            Db::beginTransaction();

            $withdraw = $this->findWithdrawByReferenceId($data['reference_id']);

            $updatedWithdraw = $this->updateWithdraw($withdraw, $data);

            $transaction = $this->createTransaction($updatedWithdraw, $data);

            Log::info('Withdraw processed: ', [$updatedWithdraw, $transaction]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing webhook: ' . $e->getMessage());
        }
    }
}
