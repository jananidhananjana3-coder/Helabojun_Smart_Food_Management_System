<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('cash','card','qr') NOT NULL DEFAULT 'cash'");
        }
    }
    public function down(): void {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE payments SET payment_method='cash' WHERE payment_method='qr'");
            DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('cash','card') NOT NULL DEFAULT 'cash'");
        }
    }
};
