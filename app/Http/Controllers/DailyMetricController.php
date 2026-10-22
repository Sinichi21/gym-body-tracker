<?php

namespace App\Http\Controllers;

use App\Models\DailyMetric;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DailyMetricController extends Controller
{
    public function index(Request $request): View
    {
        $user = $this->currentUser($request);

        $metrics = $user->dailyMetrics()
            ->orderByDesc('recorded_on')
            ->paginate(12)
            ->withQueryString();

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

        $latestWaistMetric = $user->dailyMetrics()
            ->whereNotNull('waist_cm')
            ->orderByDesc('recorded_on')
            ->first();

        return view('metrics.index', [
            'metrics' => $metrics,
            'totalEntries' => $user->dailyMetrics()->count(),
            'latestMetric' => $latestMetric,
            'latestWeightMetric' => $latestWeightMetric,
            'latestWaistMetric' => $latestWaistMetric,
            'weightChange' => $weightChange,
        ]);
    }

    public function create(): View
    {
        return view('metrics.create', ['metric' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $this->currentUser($request);
        $validated = $request->validate($this->rules($user));

        $user->dailyMetrics()->create($validated);

        return redirect()
            ->route('metrics.index')
            ->with('status', 'Catatan harian berhasil disimpan.');
    }

    public function edit(Request $request, int $metric): View
    {
        $record = $this->findUserMetric($request, $metric);

        return view('metrics.edit', ['metric' => $record]);
    }

    public function update(Request $request, int $metric): RedirectResponse
    {
        $user = $this->currentUser($request);
        $record = $this->findUserMetric($request, $metric);
        $validated = $request->validate($this->rules($user, $record));

        $record->update($validated);

        return redirect()
            ->route('metrics.index')
            ->with('status', 'Catatan harian berhasil diperbarui.');
    }

    public function destroy(Request $request, int $metric): RedirectResponse
    {
        $record = $this->findUserMetric($request, $metric);
        $record->delete();

        return redirect()
            ->route('metrics.index')
            ->with('status', 'Catatan harian berhasil dihapus.');
    }

    private function currentUser(Request $request): User
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        return $user;
    }

    private function findUserMetric(Request $request, int $metric): DailyMetric
    {
        return $this->currentUser($request)
            ->dailyMetrics()
            ->findOrFail($metric);
    }

    /**
     * @return array<string, list<mixed>>
     */
    private function rules(User $user, ?DailyMetric $metric = null): array
    {
        $recordedOnRule = Rule::unique('daily_metrics', 'recorded_on')
            ->where(fn ($query) => $query->where('user_id', $user->id));

        if ($metric !== null) {
            $recordedOnRule->ignore($metric->id);
        }

        return [
            'recorded_on' => ['required', 'date', 'before_or_equal:today', $recordedOnRule],
            'weight_kg' => ['nullable', 'numeric', 'min:20', 'max:500'],
            'waist_cm' => ['nullable', 'numeric', 'min:20', 'max:300'],
            'calories' => ['nullable', 'integer', 'min:0', 'max:60000'],
            'protein_g' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'sleep_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'steps' => ['nullable', 'integer', 'min:0', 'max:200000'],
            'energy_score' => ['nullable', 'integer', 'between:1,10'],
            'hunger_score' => ['nullable', 'integer', 'between:1,10'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
