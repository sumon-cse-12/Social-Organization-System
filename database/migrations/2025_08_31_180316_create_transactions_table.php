<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['joining_fee', 'monthly_fee', 'donation', 'event_fund', 'expense'])->index();
            $table->string('gateway');
            $table->string('currency', 3)->default('USD');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('order_id')->nullable();
            $table->string('capture_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('approval_url')->nullable();
            $table->json('meta')->nullable();
            $table->json('error')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
