<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    protected $fillable = ['user_id', 'name', 'muscle_group', 'equipment', 'instructions', 'is_system'];

    protected function casts(): array
    {
        return ['is_system' => 'boolean'];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsToMany<Routine, $this> */
    public function routines(): BelongsToMany
    {
        return $this->belongsToMany(Routine::class, 'routine_exercises')
            ->withPivot(['id', 'position', 'sets', 'reps', 'weight_kg', 'rest_seconds', 'notes'])
            ->withTimestamps()->orderByPivot('position');
    }
}
