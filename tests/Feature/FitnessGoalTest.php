<?php

use App\Models\FitnessGoal;
use App\Models\User;

test('guests cannot access fitness goal settings', function () {
    $this->get(route('fitness-goals.edit'))->assertRedirect(route('login'));
});

test('authenticated users can view and save their own fitness goals', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('fitness-goals.edit'))
        ->assertOk()
        ->assertSee('Target kebugaran');

    $this->actingAs($user)->put(route('fitness-goals.update'), [
        'goal_type' => 'lean_bulk',
        'target_weight_kg' => 72,
        'daily_calories' => 2450,
        'daily_protein_g' => 140,
        'daily_sleep_hours' => 8,
    ])->assertRedirect(route('fitness-goals.edit'));

    $this->assertDatabaseHas('fitness_goals', [
        'user_id' => $user->id,
        'goal_type' => 'lean_bulk',
        'target_weight_kg' => 72,
        'daily_calories' => 2450,
        'daily_protein_g' => 140,
        'daily_sleep_hours' => 8,
    ]);
});

test('fitness goals are scoped to the authenticated user', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    FitnessGoal::create([
        'user_id' => $otherUser->id,
        'goal_type' => 'fat_loss',
        'daily_calories' => 1800,
    ]);

    $this->actingAs($user)->put(route('fitness-goals.update'), [
        'goal_type' => 'maintenance',
        'daily_calories' => 2200,
    ])->assertRedirect(route('fitness-goals.edit'));

    $this->assertDatabaseHas('fitness_goals', [
        'user_id' => $otherUser->id,
        'goal_type' => 'fat_loss',
        'daily_calories' => 1800,
    ]);
    $this->assertDatabaseHas('fitness_goals', [
        'user_id' => $user->id,
        'goal_type' => 'maintenance',
        'daily_calories' => 2200,
    ]);
});

test('invalid fitness goal values are rejected', function () {
    $this->actingAs(User::factory()->create())
        ->put(route('fitness-goals.update'), [
            'goal_type' => 'unrealistic',
            'target_weight_kg' => 2,
            'daily_calories' => 12000,
            'daily_protein_g' => -1,
            'daily_sleep_hours' => 30,
        ])
        ->assertSessionHasErrors([
            'goal_type',
            'target_weight_kg',
            'daily_calories',
            'daily_protein_g',
            'daily_sleep_hours',
        ]);
});

test('dashboard displays configured personal goals', function () {
    $user = User::factory()->create();

    FitnessGoal::create([
        'user_id' => $user->id,
        'goal_type' => 'lean_bulk',
        'target_weight_kg' => 72,
        'daily_calories' => 2450,
        'daily_protein_g' => 140,
        'daily_sleep_hours' => 8,
    ]);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Target pribadi')
        ->assertSee('Lean bulk')
        ->assertSee('2.450')
        ->assertSee('140,0');
});
