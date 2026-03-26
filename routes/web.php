<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Stand Users
    Route::middleware('role:user')->group(function () {
        Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
        Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
    });

    // Admin & Supervisor
    Route::middleware('role:admin,supervisor')->group(function () {
        Route::resource('stands', StandController::class);
        Route::resource('participants', ParticipantController::class);
        Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    });
    
    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

// P\u00fablico para registro
Route::get('/registro-participante', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/registro-participante', [ParticipantController::class, 'store'])->name('participants.store');
Route::get('/participante/{participant}/qr', [ParticipantController::class, 'show'])->name('participants.qr');

require __DIR__.'/auth.php';
