<?php

namespace App\Http\Controllers;

use App\Models\DailyMetric;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $recentMetrics = $user->dailyMetrics()
            ->orderByDesc('recorded_on')
            ->limit(7)
            ->get()
            ->reverse()
            ->values();

        $latestMetric = $user->dailyMetrics()
            ->orderByDesc('recorded_on')
            ->first();

        $latestWeightMetric = $user->dailyMetrics()
            ->whereNotNull('weight_kg')
            ->orderByDesc('recorded_on')
            ->first();

        $previousWeightMetric = $latestWeightMetric
            ? $user->dailyMetrics()
                ->whereNotNull('weight_kg')
                ->where('recorded_on', '<', $latestWeightMetric->recorded_on)
                ->orderByDesc('recorded_on')
                ->first()
            : null;

        $weightChange = $latestWeightMetric !== null && $previousWeightMetric !== null
            ? round((float) $latestWeightMetric->weight_kg - (float) $previousWeightMetric->weight_kg, 2)
            : null;

        $totalEntries = $user->dailyMetrics()->count();

        $entriesThisWeek = $user->dailyMetrics()
            ->whereBetween('recorded_on', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])
            ->count();

        $weightHistory = $user->dailyMetrics()
            ->whereNotNull('weight_kg')
            ->orderByDesc('recorded_on')
            ->limit(7)
            ->get()
            ->reverse()
            ->values();

        $weightChartPoints = '';

        if ($weightHistory->count() > 1) {
            $weights = $weightHistory
                ->pluck('weight_kg')
                ->map(fn ($weight): float => (float) $weight)
                ->all();

            if ($weights !== []) {
                $minWeight = min($weights);
                $maxWeight = max($weights);
                $weightRange = max($maxWeight - $minWeight, 1.0);
                $pointCount = count($weights);

                $weightChartPoints = $weightHistory
                    ->values()
                    ->map(function (DailyMetric $metric, int $index) use ($minWeight, $weightRange, $pointCount): string {
                        $x = $pointCount === 1 ? 300 : ($index / ($pointCount - 1)) * 600;
                        $y = 78 - (((float) $metric->weight_kg - $minWeight) / $weightRange) * 56;

                        return sprintf('%.2f,%.2f', $x, $y);
                    })
                    ->implode(' ');
            }
        }

        return view('dashboard', [
            'recentMetrics' => $recentMetrics,
            'latestMetric' => $latestMetric,
            'latestWeightMetric' => $latestWeightMetric,
            'previousWeightMetric' => $previousWeightMetric,
            'weightChange' => $weightChange,
            'totalEntries' => $totalEntries,
            'entriesThisWeek' => $entriesThisWeek,
            'weightHistory' => $weightHistory,
            'weightChartPoints' => $weightChartPoints,
        ]);
    }
}
