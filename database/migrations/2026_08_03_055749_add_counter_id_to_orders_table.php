<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('counter_id')
                ->nullable()
                ->after('outlet_id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'counter_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('counter_id');
            });
        }
    }
};