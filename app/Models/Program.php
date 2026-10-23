<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    protected $fillable = ['user_id', 'name', 'description'];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsToMany<Routine, $this> */
    public function routines(): BelongsToMany
    {
        return $this->belongsToMany(Routine::class, 'program_routines')
            ->withPivot(['position', 'day_label'])->withTimestamps()->orderByPivot('position');
    }
}
