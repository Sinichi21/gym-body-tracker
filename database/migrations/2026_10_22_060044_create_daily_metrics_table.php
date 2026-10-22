
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_metrics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('recorded_on');

            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->decimal('waist_cm', 6, 2)->nullable();

            $table->unsignedSmallInteger('calories')->nullable();
            $table->decimal('protein_g', 6, 2)->nullable();

            $table->decimal('sleep_hours', 4, 2)->nullable();
            $table->unsignedInteger('steps')->nullable();

            $table->unsignedTinyInteger('energy_score')->nullable();
            $table->unsignedTinyInteger('hunger_score')->nullable();

            $table->text('notes')->nullable();

            $table->string('source', 50)->default('manual');
            $table->string('source_key')->nullable();

            $table->timestamps();

            $table->unique(
                ['user_id', 'recorded_on'],
                'daily_metrics_user_date_unique'
            );

            $table->unique(
                ['source', 'source_key'],
                'daily_metrics_source_key_unique'
            );

            $table->index(['user_id', 'recorded_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_metrics');
    }
};
