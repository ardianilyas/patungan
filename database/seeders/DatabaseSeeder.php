<?php

namespace Database\Seeders;

use App\Models\Topup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ardian Ilyas',
            'email' => 'ardian@patungan.com',
        ]);
        User::factory(4)->create();

//        Topup::factory(20)->create();
    }
}
