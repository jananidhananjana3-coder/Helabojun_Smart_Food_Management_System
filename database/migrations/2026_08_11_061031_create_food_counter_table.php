<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_counter', function (Blueprint $table) {
            $table->id();

            $table->foreignId('food_id')
                ->constrained('foods')
                ->cascadeOnDelete();

            $table->foreignId('counter_id')
                ->constrained('counters')
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity')->default(0);

            $table->timestamps();

            $table->unique(['food_id', 'counter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_counter');
    }
};