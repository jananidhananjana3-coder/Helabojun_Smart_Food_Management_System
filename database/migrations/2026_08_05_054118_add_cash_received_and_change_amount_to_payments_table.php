<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->decimal('cash_received',10,2)
                  ->default(0)
                  ->after('payment_status');

            $table->decimal('change_amount',10,2)
                  ->default(0)
                  ->after('cash_received');

        });
    }


    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->dropColumn([
                'cash_received',
                'change_amount'
            ]);

        });
    }
};