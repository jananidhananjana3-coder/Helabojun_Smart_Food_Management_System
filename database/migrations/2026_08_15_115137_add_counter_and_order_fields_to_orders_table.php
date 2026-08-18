<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->enum('order_type', [
                'dine_in',
                'take_away'
            ])
            ->default('dine_in')
            ->after('counter_id');

            $table->decimal('discount', 10, 2)
                ->default(0)
                ->after('total_amount');

            $table->decimal('grand_total', 10, 2)
                ->default(0)
                ->after('discount');

            $table->string('payment_method')
                ->nullable()
                ->after('payment_status');

            $table->decimal('cash_received', 10, 2)
                ->default(0)
                ->after('payment_method');

            $table->decimal('change_amount', 10, 2)
                ->default(0)
                ->after('cash_received');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'order_type',
                'discount',
                'grand_total',
                'payment_method',
                'cash_received',
                'change_amount',
            ]);

        });
    }
};