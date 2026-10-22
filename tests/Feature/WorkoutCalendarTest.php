<?php

use App\Models\User;

test('users can view their workout calendar and monthly consistency totals', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $month = now()->startOfMonth();

    $session = $user->workoutSessions()->create([
        'trained_on' => $month->copy()->addDays(2)->toDateString(),
        'workout_type' => 'Push',
    ]);
    $session->exercises()->create(['name' => 'Bench Press', 'position' => 1]);
    $user->workoutSessions()->create([
        'trained_on' => $month->copy()->addDays(2)->toDateString(),
        'workout_type' => 'Cardio',
    ]);
    $user->workoutSessions()->create([
        'trained_on' => $month->copy()->addDays(5)->toDateString(),
        'workout_type' => 'Legs',
    ]);
    $otherUser->workoutSessions()->create([
        'trained_on' => $month->copy()->addDays(4)->toDateString(),
        'workout_type' => 'Foreign Session',
    ]);

    $response = $this->actingAs($user)->get(route('workouts.calendar', ['month' => $month->format('Y-m')]));

    $response->assertOk()
        ->assertSee('Push')
        ->assertSee('Cardio')
        ->assertSee('Legs')
        ->assertDontSee('Foreign Session')
        ->assertSee('3', false);
});

test('calendar rejects invalid month parameters', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('workouts.calendar', ['month' => 'not-a-month']))
        ->assertSessionHasErrors('month');
});

test('guests must authenticate before viewing workout calendar', function () {
    $this->get(route('workouts.calendar'))->assertRedirect(route('login'));
});
