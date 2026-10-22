<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutSet extends Model
{
    protected $fillable = ['workout_exercise_id', 'set_number', 'weight_kg', 'reps'];

    protected function casts(): array
    {
        return ['set_number' => 'integer', 'weight_kg' => 'decimal:2', 'reps' => 'integer'];
    }

    /** @return BelongsTo<WorkoutExercise, $this> */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(WorkoutExercise::class, 'workout_exercise_id');
    }
}
