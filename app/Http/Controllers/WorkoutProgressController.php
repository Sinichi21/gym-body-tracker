<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WorkoutProgressController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $sessions = $user->workoutSessions()
            ->with('exercises.sets')
            ->orderByDesc('trained_on')
            ->orderByDesc('id')
            ->get();

        $performances = collect();

        foreach ($sessions as $session) {
            foreach ($session->exercises as $exercise) {
                $key = mb_strtolower(trim($exercise->name));

                if ($key === '') {
                    continue;
                }

                if (! $performances->has($key)) {
                    $performances->put($key, [
                        'name' => trim($exercise->name),
                        'latest_date' => $session->trained_on,
                        'latest_weight' => null,
                        'latest_reps' => null,
                        'best_weight' => null,
                        'best_weight_date' => null,
                        'sets_logged' => 0,
                        'volume_kg' => 0.0,
                    ]);
                }

                $performance = $performances->get($key);

                foreach ($exercise->sets as $set) {
                    $performance['sets_logged']++;

                    if ($set->weight_kg !== null && $set->reps !== null) {
                        $weight = (float) $set->weight_kg;
                        $reps = (int) $set->reps;
                        $performance['volume_kg'] += $weight * $reps;

                        if ($performance['latest_weight'] === null) {
                            $performance['latest_date'] = $session->trained_on;
                            $performance['latest_weight'] = $weight;
                            $performance['latest_reps'] = $reps;
                        }

                        if ($performance['best_weight'] === null || $weight > $performance['best_weight']) {
                            $performance['best_weight'] = $weight;
                            $performance['best_weight_date'] = $session->trained_on;
                        }
                    }
                }

                $performances->put($key, $performance);
            }
        }

        $exerciseProgress = $performances
            ->sortBy('name')
            ->values();

        return view('workouts.progress', [
            'exerciseProgress' => $exerciseProgress,
            'totalSessions' => $sessions->count(),
            'totalSets' => $exerciseProgress->sum('sets_logged'),
            'totalVolume' => $exerciseProgress->sum('volume_kg'),
        ]);
    }
}
