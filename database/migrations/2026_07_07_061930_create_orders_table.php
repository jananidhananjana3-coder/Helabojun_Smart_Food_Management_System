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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Cashier [cite: 61]
            $table->foreignId('outlet_id')->constrained()->cascadeOnDelete();
            $table->string('token_number'); // Queue display to token number
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])->default('pending'); // cashier paid
            $table->enum('payment_status', ['unpaid', 'paid'])->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
