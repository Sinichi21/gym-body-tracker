<?php

use App\Http\Controllers\DailyMetricController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FitnessGoalController;
use App\Http\Controllers\WorkoutSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->user()?->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('library/programs', [LibraryController::class, 'storeProgram'])->name('library.programs.store');
    Route::delete('library/programs/{program}', [LibraryController::class, 'destroyProgram'])->name('library.programs.destroy');
    Route::post('library/programs/{program}/routines', [LibraryController::class, 'attachRoutine'])->name('library.programs.routines.store');
    Route::post('library/routines', [LibraryController::class, 'storeRoutine'])->name('library.routines.store');
    Route::delete('library/routines/{routine}', [LibraryController::class, 'destroyRoutine'])->name('library.routines.destroy');
    Route::post('library/routines/{routine}/exercises', [LibraryController::class, 'attachExercise'])->name('library.routines.exercises.store');
    Route::delete('library/exercises/{exercise}', [LibraryController::class, 'destroyExercise'])->name('library.exercises.destroy');
    Route::post('library/exercises', [LibraryController::class, 'storeExercise'])->name('library.exercises.store');

    Route::get('fitness-goals', [FitnessGoalController::class, 'edit'])->name('fitness-goals.edit');
    Route::put('fitness-goals', [FitnessGoalController::class, 'update'])->name('fitness-goals.update');

    Route::get('workouts', [WorkoutSessionController::class, 'index'])->name('workouts.index');
    Route::get('workouts/create', [WorkoutSessionController::class, 'create'])->name('workouts.create');
    Route::post('workouts', [WorkoutSessionController::class, 'store'])->name('workouts.store');
    Route::delete('workouts/{workout}', [WorkoutSessionController::class, 'destroy'])->whereNumber('workout')->name('workouts.destroy');

    Route::get('metrics', [DailyMetricController::class, 'index'])->name('metrics.index');
    Route::get('metrics/create', [DailyMetricController::class, 'create'])->name('metrics.create');
    Route::post('metrics', [DailyMetricController::class, 'store'])->name('metrics.store');
    Route::get('metrics/{metric}/edit', [DailyMetricController::class, 'edit'])->whereNumber('metric')->name('metrics.edit');
    Route::put('metrics/{metric}', [DailyMetricController::class, 'update'])->whereNumber('metric')->name('metrics.update');
    Route::delete('metrics/{metric}', [DailyMetricController::class, 'destroy'])->whereNumber('metric')->name('metrics.destroy');
});

require __DIR__.'/settings.php';
