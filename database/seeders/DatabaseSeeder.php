<?php

namespace Database\Seeders;

use App\Models\Topup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Ardian Ilyas',
            'email' => 'ardian@patungan.com',
        ]);

        $topups = Topup::factory(15)->create();

        foreach ($topups as $topup) {

            $randomDate = collect([
                now()->subDay(),
                now()->subDays(rand(1, 15)),
                now()->subMonths(rand(1, 2))
            ]);

            $datetime = Carbon::parse($randomDate->random())->toDateTimeString();

            $transaction = $topup->transaction()->create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $topup->amount,
                'payment_id' => uniqid(),
                'payment_method' => fake()->randomElement(['bank transfer', 'qr_code']),
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);

            if ($topup->status === 'paid') {
                $user->balance += $topup->amount;
                $user->save();
                $topup->paid_at = $datetime;
                $transaction->status = 'success';
                $transaction->paid_at = $datetime;
            } elseif ($topup->status === 'failed') {
                $transaction->status = 'failed';
            }
            $transaction->save();
            $topup->save();
        }
    }
}
