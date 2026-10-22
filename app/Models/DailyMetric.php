<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyMetric extends Model
{
    protected $fillable = [
        'user_id',
        'recorded_on',
        'weight_kg',
        'waist_cm',
        'calories',
        'protein_g',
        'sleep_hours',
        'steps',
        'energy_score',
        'hunger_score',
        'notes',
        'source',
        'source_key',
    ];

    protected function casts(): array
    {
        return [
            'recorded_on' => 'date',
            'weight_kg' => 'decimal:2',
            'waist_cm' => 'decimal:2',
            'calories' => 'integer',
            'protein_g' => 'decimal:2',
            'sleep_hours' => 'decimal:2',
            'steps' => 'integer',
            'energy_score' => 'integer',
            'hunger_score' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
