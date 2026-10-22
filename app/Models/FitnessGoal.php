<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitnessGoal extends Model
{
    protected $fillable = [
        'user_id',
        'goal_type',
        'target_weight_kg',
        'daily_calories',
        'daily_protein_g',
        'daily_sleep_hours',
    ];

    protected function casts(): array
    {
        return [
            'target_weight_kg' => 'decimal:2',
            'daily_calories' => 'integer',
            'daily_protein_g' => 'decimal:2',
            'daily_sleep_hours' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
