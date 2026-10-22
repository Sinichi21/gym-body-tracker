<?php

use App\Models\User;

test('authenticated users can save a workout session with exercises and sets', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('workouts.store'), [
        'trained_on' => now()->toDateString(),
        'workout_type' => 'Push',
        'duration_minutes' => 70,
        'notes' => 'Latihan dada dan bahu.',
        'exercises' => [
            ['name' => 'Bench Press', 'sets' => [
                ['weight_kg' => '40', 'reps' => 10],
                ['weight_kg' => '42.5', 'reps' => 8],
            ]],
            ['name' => 'Shoulder Press', 'sets' => [
                ['weight_kg' => '20', 'reps' => 10],
            ]],
        ],
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect(route('workouts.index'));

    $this->assertDatabaseHas('workout_sessions', [
        'user_id' => $user->id,
        'workout_type' => 'Push',
        'duration_minutes' => 70,
    ]);
    $this->assertDatabaseHas('workout_exercises', ['name' => 'Bench Press']);
    $this->assertDatabaseHas('workout_sets', ['set_number' => 2, 'weight_kg' => '42.50', 'reps' => 8]);
    $this->assertDatabaseCount('workout_exercises', 2);
    $this->assertDatabaseCount('workout_sets', 3);
});

test('users can only see and delete their own workout sessions', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $own = $user->workoutSessions()->create([
        'trained_on' => now()->toDateString(),
        'workout_type' => 'Pull',
    ]);
    $foreign = $otherUser->workoutSessions()->create([
        'trained_on' => now()->toDateString(),
        'workout_type' => 'Legs',
    ]);

    $response = $this->actingAs($user)->get(route('workouts.index'));
    $response->assertOk()->assertSee('Pull')->assertDontSee('Legs');

    $this->actingAs($user)->delete(route('workouts.destroy', $foreign->id))->assertNotFound();
    $this->assertDatabaseHas('workout_sessions', ['id' => $foreign->id, 'user_id' => $otherUser->id]);

    $this->actingAs($user)->delete(route('workouts.destroy', $own->id))->assertRedirect(route('workouts.index'));
    $this->assertDatabaseMissing('workout_sessions', ['id' => $own->id]);
});

test('workout input rejects invalid dates and empty exercise lists', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('workouts.store'), [
        'trained_on' => now()->addDay()->toDateString(),
        'workout_type' => 'Push',
        'exercises' => [],
    ]);

    $response->assertSessionHasErrors(['trained_on', 'exercises']);
});

test('guests must authenticate before viewing workout tracking', function () {
    $this->get(route('workouts.index'))->assertRedirect(route('login'));
});
