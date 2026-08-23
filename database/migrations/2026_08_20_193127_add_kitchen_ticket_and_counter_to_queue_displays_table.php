<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('queue_displays', function (Blueprint $table) {

            $table->foreignId('kitchen_ticket_id')
                ->nullable()
                ->after('order_id');

        });
    }

    public function down(): void
    {
        Schema::table('queue_displays', function (Blueprint $table) {

            $table->dropForeign(['kitchen_ticket_id']);
            $table->dropColumn('kitchen_ticket_id');

        });
    }
};