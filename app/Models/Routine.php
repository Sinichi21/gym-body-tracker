<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routine extends Model
{
    protected $fillable = ['user_id', 'name', 'notes'];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsToMany<Exercise, $this> */
    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercises')
            ->withPivot(['id', 'position', 'sets', 'reps', 'weight_kg', 'rest_seconds', 'notes'])
            ->withTimestamps()->orderByPivot('position');
    }

    /** @return BelongsToMany<Program, $this> */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_routines')
            ->withPivot(['position', 'day_label'])->withTimestamps()->orderByPivot('position');
    }
}
