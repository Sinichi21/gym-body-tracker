<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('muscle_group', 80)->nullable();
            $table->string('equipment', 80)->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'name']);
        });

        Schema::create('routines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'name']);
        });

        Schema::create('routine_exercises', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('routine_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->unsignedTinyInteger('sets')->default(3);
            $table->string('reps', 30)->default('8-12');
            $table->decimal('weight_kg', 7, 2)->nullable();
            $table->unsignedSmallInteger('rest_seconds')->default(90);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['routine_id', 'position']);
        });

        Schema::create('programs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'name']);
        });

        Schema::create('program_routines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('routine_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('day_label', 80)->nullable();
            $table->timestamps();
            $table->unique(['program_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_routines');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('routine_exercises');
        Schema::dropIfExists('routines');
        Schema::dropIfExists('exercises');
    }
};
