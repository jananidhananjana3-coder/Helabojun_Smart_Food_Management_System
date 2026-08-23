<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('queue_displays', function (Blueprint $table) {

            $table->foreignId('counter_id')
                ->nullable()
                ->after('order_id')
                ->constrained('counters')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('queue_displays', function (Blueprint $table) {

            $table->dropForeign(['counter_id']);
            $table->dropColumn('counter_id');

        });
    }
};