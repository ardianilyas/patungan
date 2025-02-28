<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secretKey = config('services.xendit.secret_key');
        $banks = Http::withBasicAuth($secretKey, '')->get('https://api.xendit.co/payouts_channels?currency=IDR&channel_category=BANK');

        foreach ($banks->json() as $bank) {
            Bank::query()->create([
                'currency' => $bank['currency'],
                'channel_code' => $bank['channel_code'],
                'channel_category' => $bank['channel_category'],
                'channel_name' => $bank['channel_name'],
            ]);
        }
    }
}
