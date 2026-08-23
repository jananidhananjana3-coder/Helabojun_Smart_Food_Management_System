<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE kitchen_tickets
            MODIFY status ENUM('waiting', 'cooking', 'ready', 'completed')
            NOT NULL DEFAULT 'waiting'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE kitchen_tickets
            MODIFY status ENUM('waiting', 'cooking', 'completed')
            NOT NULL DEFAULT 'waiting'
        ");
    }
};