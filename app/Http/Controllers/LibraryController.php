<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\Routine;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $exerciseQuery = Exercise::query()
            ->where(fn ($query) => $query->whereNull('user_id')->orWhere('user_id', $user->id));

        return view('library.index', [
            'programs' => $user->programs()->withCount('routines')->with('routines')->latest()->get(),
            'routines' => $user->routines()->withCount('exercises')->with('exercises')->latest()->get(),
            'exerciseOptions' => (clone $exerciseQuery)->orderBy('name')->get(),
            'exercises' => (clone $exerciseQuery)
                ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.trim((string) $request->query('q')).'%'))
                ->when($request->filled('muscle'), fn ($query) => $query->where('muscle_group', $request->query('muscle')))
                ->orderBy('name')->paginate(18)->withQueryString(),
            'muscleGroups' => (clone $exerciseQuery)->whereNotNull('muscle_group')->distinct()->orderBy('muscle_group')->pluck('muscle_group'),
            'tab' => in_array($request->query('tab'), ['programs', 'routines', 'exercises'], true) ? $request->query('tab') : 'programs',
        ]);
    }

    public function storeProgram(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);
        $user->programs()->create($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        return redirect()->route('library.index', ['tab' => 'programs'])->with('status', 'Program berhasil dibuat.');
    }

    public function storeRoutine(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);
        $user->routines()->create($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]));

        return redirect()->route('library.index', ['tab' => 'routines'])->with('status', 'Rutinitas berhasil dibuat.');
    }

    public function storeExercise(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);
        $user->exercises()->create($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'muscle_group' => ['nullable', 'string', 'max:80'],
            'equipment' => ['nullable', 'string', 'max:80'],
            'instructions' => ['nullable', 'string', 'max:3000'],
        ]) + ['is_system' => false]);

        return redirect()->route('library.index', ['tab' => 'exercises'])->with('status', 'Exercise berhasil ditambahkan.');
    }

    public function attachExercise(Request $request, Routine $routine): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);
        abort_unless($routine->user_id === $user->id, 404);
        $data = $request->validate([
            'exercise_id' => ['required', 'integer', 'exists:exercises,id'],
            'sets' => ['required', 'integer', 'min:1', 'max:30'],
            'reps' => ['required', 'string', 'max:30'],
            'weight_kg' => ['nullable', 'numeric', 'min:0', 'max:2000'],
            'rest_seconds' => ['required', 'integer', 'min:0', 'max:3600'],
        ]);
        $exercise = Exercise::query()->whereKey($data['exercise_id'])
            ->where(fn ($query) => $query->whereNull('user_id')->orWhere('user_id', $user->id))
            ->firstOrFail();

        $routine->exercises()->attach($exercise->id, [
            'position' => $routine->exercises()->count() + 1,
            'sets' => $data['sets'],
            'reps' => $data['reps'],
            'weight_kg' => $data['weight_kg'] ?? null,
            'rest_seconds' => $data['rest_seconds'],
        ]);

        return redirect()->route('library.index', ['tab' => 'routines'])->with('status', 'Exercise ditambahkan ke rutinitas.');
    }

    public function attachRoutine(Request $request, Program $program): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);
        abort_unless($program->user_id === $user->id, 404);
        $data = $request->validate([
            'routine_id' => ['required', 'integer', 'exists:routines,id'],
            'day_label' => ['nullable', 'string', 'max:80'],
        ]);
        $routine = $user->routines()->findOrFail($data['routine_id']);
        $program->routines()->attach($routine->id, [
            'position' => $program->routines()->count() + 1,
            'day_label' => $data['day_label'] ?? null,
        ]);

        return redirect()->route('library.index', ['tab' => 'programs'])->with('status', 'Rutinitas ditambahkan ke program.');
    }

    public function destroyProgram(Request $request, Program $program): RedirectResponse
    {
        abort_unless($program->user_id === $request->user()->id, 404);
        $program->delete();

        return redirect()->route('library.index', ['tab' => 'programs'])->with('status', 'Program dihapus.');
    }

    public function destroyRoutine(Request $request, Routine $routine): RedirectResponse
    {
        abort_unless($routine->user_id === $request->user()->id, 404);
        $routine->delete();

        return redirect()->route('library.index', ['tab' => 'routines'])->with('status', 'Rutinitas dihapus.');
    }

    public function destroyExercise(Request $request, Exercise $exercise): RedirectResponse
    {
        abort_unless($exercise->user_id === $request->user()->id, 404);
        $exercise->delete();

        return redirect()->route('library.index', ['tab' => 'exercises'])->with('status', 'Exercise dihapus.');
    }
}
