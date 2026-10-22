<?php

use App\Http\Controllers\DailyMetricController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('metrics', [DailyMetricController::class, 'index'])->name('metrics.index');
    Route::get('metrics/create', [DailyMetricController::class, 'create'])->name('metrics.create');
    Route::post('metrics', [DailyMetricController::class, 'store'])->name('metrics.store');
    Route::get('metrics/{metric}/edit', [DailyMetricController::class, 'edit'])->whereNumber('metric')->name('metrics.edit');
    Route::put('metrics/{metric}', [DailyMetricController::class, 'update'])->whereNumber('metric')->name('metrics.update');
    Route::delete('metrics/{metric}', [DailyMetricController::class, 'destroy'])->whereNumber('metric')->name('metrics.destroy');
});

require __DIR__.'/settings.php';
