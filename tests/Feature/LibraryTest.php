<?php

use App\Models\User;

test('library is available to verified users and shows its three sections', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('library.index'))
        ->assertOk()
        ->assertSee('Programs')
        ->assertSee('Routines')
        ->assertSee('Exercises');
});

test('user can create a routine and a custom exercise and add it with set details', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->post(route('library.routines.store'), ['name' => 'Push Day'])
        ->assertRedirect(route('library.index', ['tab' => 'routines']));
    $routine = $user->routines()->firstOrFail();

    $this->actingAs($user)->post(route('library.exercises.store'), [
        'name' => 'Incline Dumbbell Press',
        'muscle_group' => 'Chest',
        'equipment' => 'Dumbbell',
    ])->assertRedirect(route('library.index', ['tab' => 'exercises']));
    $exercise = $user->exercises()->firstOrFail();

    $this->actingAs($user)->post(route('library.routines.exercises.store', $routine), [
        'exercise_id' => $exercise->id,
        'sets' => 4,
        'reps' => '8-12',
        'weight_kg' => 20,
        'rest_seconds' => 90,
    ])->assertRedirect(route('library.index', ['tab' => 'routines']));

    $this->assertDatabaseHas('routine_exercises', [
        'routine_id' => $routine->id,
        'exercise_id' => $exercise->id,
        'sets' => 4,
        'reps' => '8-12',
        'weight_kg' => 20,
        'rest_seconds' => 90,
    ]);
});

test('user cannot attach another users routine to their program', function () {
    $owner = User::factory()->create(['email_verified_at' => now()]);
    $other = User::factory()->create(['email_verified_at' => now()]);
    $program = $owner->programs()->create(['name' => 'PPL']);
    $routine = $other->routines()->create(['name' => 'Push']);

    $this->actingAs($owner)->post(route('library.programs.routines.store', $program), [
        'routine_id' => $routine->id,
    ])->assertNotFound();
});
