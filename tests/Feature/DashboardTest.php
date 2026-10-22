<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});


test('dashboard shows weekly averages and logging consistency from the current user data', function () {
    $user = User::factory()->create();

    $user->dailyMetrics()->create([
        'recorded_on' => now()->startOfWeek()->toDateString(),
        'calories' => 2400,
        'protein_g' => 130,
        'sleep_hours' => 7,
    ]);

    $user->dailyMetrics()->create([
        'recorded_on' => now()->startOfWeek()->addDay()->toDateString(),
        'calories' => 2600,
        'protein_g' => 150,
        'sleep_hours' => 8,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Konsistensi dan rata-rata minggu ini')
        ->assertSee('29%')
        ->assertSee('2.500')
        ->assertSee('140,0')
        ->assertSee('7,5');
});

test('dashboard weekly insights do not include another users metrics', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $otherUser->dailyMetrics()->create([
        'recorded_on' => now()->startOfWeek()->toDateString(),
        'calories' => 5000,
        'protein_g' => 300,
        'sleep_hours' => 12,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('0%')
        ->assertSee('Konsistensi dan rata-rata minggu ini')
        ->assertDontSee('5.000');
});
