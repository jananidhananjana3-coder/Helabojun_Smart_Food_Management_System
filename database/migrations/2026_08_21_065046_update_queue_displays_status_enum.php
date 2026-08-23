<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE queue_displays
            MODIFY status ENUM('waiting', 'ready', 'served')
            NOT NULL DEFAULT 'waiting'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE queue_displays
            MODIFY status ENUM('waiting', 'served')
            NOT NULL DEFAULT 'waiting'
        ");
    }
};