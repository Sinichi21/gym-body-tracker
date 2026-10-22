<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WorkoutCalendarController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $month = isset($validated['month'])
            ? CarbonImmutable::createFromFormat('!Y-m', $validated['month'])
            : CarbonImmutable::now();

        abort_if($month === false, 422);

        $monthStart = $month->startOfMonth();
        $monthEnd = $month->endOfMonth();
        $gridStart = $monthStart->startOfWeek(CarbonImmutable::MONDAY);
        $gridEnd = $monthEnd->endOfWeek(CarbonImmutable::SUNDAY);

        $sessions = $user->workoutSessions()
            ->with('exercises')
            ->whereBetween('trained_on', [$gridStart->toDateString(), $gridEnd->toDateString()])
            ->orderBy('trained_on')
            ->orderBy('id')
            ->get();

        $sessionsByDate = $sessions->groupBy(fn ($session) => $session->trained_on->toDateString());
        $days = collect(range(0, (int) $gridStart->diffInDays($gridEnd)))
            ->map(fn (int $offset) => $gridStart->addDays($offset));

        $monthSessions = $sessions->filter(fn ($session) => $session->trained_on->betweenIncluded($monthStart, $monthEnd));

        return view('workouts.calendar', [
            'month' => $monthStart,
            'days' => $days,
            'sessionsByDate' => $sessionsByDate,
            'totalSessions' => $monthSessions->count(),
            'activeDays' => $monthSessions->pluck('trained_on')->map(fn ($date) => $date->toDateString())->unique()->count(),
            'totalExercises' => $monthSessions->sum(fn ($session) => $session->exercises->count()),
            'previousMonth' => $monthStart->subMonth()->format('Y-m'),
            'nextMonth' => $monthStart->addMonth()->format('Y-m'),
        ]);
    }
}
