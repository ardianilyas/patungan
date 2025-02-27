<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('reference_id')->unique();
            $table->string('payout_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('amount');
            $table->string('currency');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('channel_code')->nullable();
            $table->string('channel_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
