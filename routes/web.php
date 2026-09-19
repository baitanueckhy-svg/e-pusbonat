<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeswaController;
use App\Http\Controllers\SpmController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/search', [SearchController::class, 'index'])
        ->name('search');


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('/spm', SpmController::class)
        ->except(['show']);

    Route::get('/kesehatan-jiwa/export', [KeswaController::class, 'export'])
        ->name('kesehatan-jiwa.export');

    Route::resource('/kesehatan-jiwa', KeswaController::class)
        ->except(['show']);
});

require __DIR__.'/auth.php';

