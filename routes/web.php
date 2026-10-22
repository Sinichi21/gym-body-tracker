<?php

use App\Http\Controllers\DailyMetricController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FitnessGoalController;
use App\Http\Controllers\WorkoutSessionController;
use App\Http\Controllers\WorkoutProgressController;
use App\Http\Controllers\WorkoutCalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->user()?->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('fitness-goals', [FitnessGoalController::class, 'edit'])->name('fitness-goals.edit');
    Route::put('fitness-goals', [FitnessGoalController::class, 'update'])->name('fitness-goals.update');

    Route::get('workouts/calendar', WorkoutCalendarController::class)->name('workouts.calendar');
    Route::get('workouts/progress', WorkoutProgressController::class)->name('workouts.progress');
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
