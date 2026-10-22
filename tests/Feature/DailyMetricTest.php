<?php

use App\Models\User;

test('authenticated users can create a daily metric', function () {
    $user = User::factory()->create();
    $recordedOn = now()->toDateString();

    $response = $this->actingAs($user)->post(route('metrics.store'), [
        'recorded_on' => $recordedOn,
        'weight_kg' => '68.80',
        'waist_cm' => '79.50',
        'calories' => 2450,
        'protein_g' => '135.0',
        'sleep_hours' => '7.5',
        'steps' => 8500,
        'energy_score' => 7,
        'hunger_score' => 5,
        'notes' => 'Latihan upper body.',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('metrics.index'));

    $this->assertDatabaseHas('daily_metrics', [
        'user_id' => $user->id,
        'recorded_on' => $recordedOn,
        'calories' => 2450,
        'notes' => 'Latihan upper body.',
    ]);

    $metric = $user->dailyMetrics()
        ->whereDate('recorded_on', $recordedOn)
        ->firstOrFail();

    expect($metric->weight_kg)->toBe('68.80');
});

test('users only see their own daily metrics', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $user->dailyMetrics()->create([
        'recorded_on' => now()->subDay()->toDateString(),
        'weight_kg' => '70.50',
        'notes' => 'catatan-milik-pengguna-aktif',
    ]);

    $otherUser->dailyMetrics()->create([
        'recorded_on' => now()->subDay()->toDateString(),
        'weight_kg' => '99.90',
        'notes' => 'rahasia-pengguna-lain',
    ]);

    $response = $this->actingAs($user)->get(route('metrics.index'));

    $response
        ->assertOk()
        ->assertSee('catatan-milik-pengguna-aktif')
        ->assertDontSee('rahasia-pengguna-lain');
});

test('users cannot update a daily metric owned by someone else', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $metric = $otherUser->dailyMetrics()->create([
        'recorded_on' => now()->subDay()->toDateString(),
        'weight_kg' => '99.90',
    ]);

    $response = $this->actingAs($user)->put(route('metrics.update', $metric->id), [
        'recorded_on' => now()->subDay()->toDateString(),
        'weight_kg' => '80.00',
    ]);

    $response->assertNotFound();

    $this->assertDatabaseHas('daily_metrics', [
        'id' => $metric->id,
        'user_id' => $otherUser->id,
        'weight_kg' => '99.90',
    ]);
});

test('users cannot delete a daily metric owned by someone else', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $metric = $otherUser->dailyMetrics()->create([
        'recorded_on' => now()->subDay()->toDateString(),
        'weight_kg' => '99.90',
    ]);

    $response = $this->actingAs($user)->delete(route('metrics.destroy', $metric->id));

    $response->assertNotFound();

    $this->assertDatabaseHas('daily_metrics', [
        'id' => $metric->id,
        'user_id' => $otherUser->id,
    ]);
});

test('each user can only have one daily metric per date', function () {
    $user = User::factory()->create();
    $recordedOn = now()->toDateString();

    $user->dailyMetrics()->create([
        'recorded_on' => $recordedOn,
        'weight_kg' => '68.00',
    ]);

    $response = $this->actingAs($user)->from(route('metrics.create'))->post(route('metrics.store'), [
        'recorded_on' => $recordedOn,
        'weight_kg' => '69.00',
    ]);

    $response
        ->assertSessionHasErrors('recorded_on')
        ->assertRedirect(route('metrics.create'));

    $this->assertDatabaseCount('daily_metrics', 1);
});

test('daily metric validation rejects impossible values', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('metrics.store'), [
        'recorded_on' => now()->toDateString(),
        'weight_kg' => '0',
        'sleep_hours' => '30',
        'energy_score' => 11,
    ]);

    $response->assertSessionHasErrors([
        'weight_kg',
        'sleep_hours',
        'energy_score',
    ]);
});

test('users can filter their daily metrics by date range and note text', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $olderMetric = $user->dailyMetrics()->create([
        'recorded_on' => now()->subDays(5)->toDateString(),
        'weight_kg' => '69.50',
        'notes' => 'latihan kaki lama',
    ]);

    $matchingMetric = $user->dailyMetrics()->create([
        'recorded_on' => now()->subDays(2)->toDateString(),
        'weight_kg' => '69.20',
        'notes' => 'latihan upper body',
    ]);

    $otherUser->dailyMetrics()->create([
        'recorded_on' => now()->subDays(2)->toDateString(),
        'weight_kg' => '99.90',
        'notes' => 'latihan upper rahasia',
    ]);

    $response = $this->actingAs($user)->get(route('metrics.index', [
        'from' => now()->subDays(3)->toDateString(),
        'to' => now()->toDateString(),
        'q' => 'upper',
    ]));

    $response
        ->assertOk()
        ->assertSee('latihan upper body')
        ->assertDontSee('latihan kaki lama')
        ->assertDontSee('latihan upper rahasia')
        ->assertSee('value="upper"', false);

    expect($matchingMetric->exists)->toBeTrue()
        ->and($olderMetric->exists)->toBeTrue();
});

test('date filters reject an end date earlier than the start date', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('metrics.index', [
        'from' => now()->toDateString(),
        'to' => now()->subDay()->toDateString(),
    ]));

    $response->assertSessionHasErrors('to');
});
