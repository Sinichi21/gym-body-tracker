<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FitnessGoalController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        return view('fitness-goals.edit', [
            'fitnessGoal' => $user->fitnessGoal,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $validated = $request->validate([
            'goal_type' => ['required', Rule::in(['lean_bulk', 'fat_loss', 'maintenance'])],
            'target_weight_kg' => ['nullable', 'numeric', 'between:20,500'],
            'daily_calories' => ['nullable', 'integer', 'between:500,10000'],
            'daily_protein_g' => ['nullable', 'numeric', 'between:0,1000'],
            'daily_sleep_hours' => ['nullable', 'numeric', 'between:0,24'],
        ]);

        $user->fitnessGoal()->updateOrCreate(
            ['user_id' => $user->id],
            $validated,
        );

        return redirect()
            ->route('fitness-goals.edit')
            ->with('status', 'Target kebugaran berhasil disimpan.');
    }
}
