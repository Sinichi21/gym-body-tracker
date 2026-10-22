<?php

use App\Models\User;

test('users can view progress aggregated from their workout history', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $session = $user->workoutSessions()->create([
        'trained_on' => now()->subDays(2)->toDateString(),
        'workout_type' => 'Push',
    ]);
    $exercise = $session->exercises()->create(['name' => 'Bench Press', 'position' => 1]);
    $exercise->sets()->create(['set_number' => 1, 'weight_kg' => 40, 'reps' => 10]);
    $exercise->sets()->create(['set_number' => 2, 'weight_kg' => 45, 'reps' => 8]);

    $recentSession = $user->workoutSessions()->create([
        'trained_on' => now()->toDateString(),
        'workout_type' => 'Push',
    ]);
    $recentExercise = $recentSession->exercises()->create(['name' => 'bench press', 'position' => 1]);
    $recentExercise->sets()->create(['set_number' => 1, 'weight_kg' => 42.5, 'reps' => 9]);

    $foreignSession = $otherUser->workoutSessions()->create([
        'trained_on' => now()->toDateString(),
        'workout_type' => 'Pull',
    ]);
    $foreignExercise = $foreignSession->exercises()->create(['name' => 'Deadlift', 'position' => 1]);
    $foreignExercise->sets()->create(['set_number' => 1, 'weight_kg' => 100, 'reps' => 5]);

    $response = $this->actingAs($user)->get(route('workouts.progress'));

    $response->assertOk()
        ->assertSee('Bench Press')
        ->assertSee('45,00 kg')
        ->assertDontSee('Deadlift')
        ->assertSee('1.220 kg-rep');
});

test('guests must authenticate before viewing workout progress', function () {
    $this->get(route('workouts.progress'))->assertRedirect(route('login'));
});
