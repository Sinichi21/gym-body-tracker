<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitness_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('goal_type', 30)->default('maintenance');
            $table->decimal('target_weight_kg', 6, 2)->nullable();
            $table->unsignedSmallInteger('daily_calories')->nullable();
            $table->decimal('daily_protein_g', 6, 2)->nullable();
            $table->decimal('daily_sleep_hours', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_goals');
    }
};
