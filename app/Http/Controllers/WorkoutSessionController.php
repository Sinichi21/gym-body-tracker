<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutSessionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $sessions = $user->workoutSessions()
            ->with('exercises.sets')
            ->orderByDesc('trained_on')
            ->orderByDesc('id')
            ->paginate(10);

        return view('workouts.index', [
            'sessions' => $sessions,
            'totalSessions' => $user->workoutSessions()->count(),
            'totalMinutes' => $user->workoutSessions()->sum('duration_minutes'),
        ]);
    }

    public function create(): View
    {
        return view('workouts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $validated = $request->validate([
            'trained_on' => ['required', 'date', 'before_or_equal:today'],
            'workout_type' => ['required', 'string', 'max:80'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'exercises' => ['required', 'array', 'min:1', 'max:20'],
            'exercises.*.name' => ['required', 'string', 'max:120'],
            'exercises.*.sets' => ['required', 'array', 'min:1', 'max:20'],
            'exercises.*.sets.*.weight_kg' => ['nullable', 'numeric', 'min:0', 'max:2000'],
            'exercises.*.sets.*.reps' => ['nullable', 'integer', 'min:1', 'max:1000'],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $session = $user->workoutSessions()->create([
                'trained_on' => $validated['trained_on'],
                'workout_type' => $validated['workout_type'],
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['exercises'] as $index => $exerciseData) {
                $exercise = $session->exercises()->create([
                    'name' => trim($exerciseData['name']),
                    'position' => $index + 1,
                ]);

                foreach ($exerciseData['sets'] as $setIndex => $setData) {
                    $exercise->sets()->create([
                        'set_number' => $setIndex + 1,
                        'weight_kg' => $setData['weight_kg'] ?? null,
                        'reps' => $setData['reps'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('workouts.index')->with('status', 'Sesi latihan berhasil disimpan.');
    }

    public function destroy(Request $request, int $workout): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $session = $user->workoutSessions()->findOrFail($workout);
        $session->delete();

        return redirect()->route('workouts.index')->with('status', 'Sesi latihan berhasil dihapus.');
    }
}
