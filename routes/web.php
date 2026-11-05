<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

// Campus Events Report Page
Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');
