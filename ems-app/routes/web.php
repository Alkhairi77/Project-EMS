<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// ORGANIZER ROUTES
// ============================================
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');

    // Event CRUD
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    // Attendees & Check-in
    Route::get('/events/{id}/attendees', [EventController::class, 'attendees'])->name('events.attendees');
    Route::patch('/registrations/{id}/checkin', [RegistrationController::class, 'checkin'])->name('registrations.checkin');
});

// ============================================
// PARTICIPANT ROUTES
// ============================================
Route::middleware(['auth', 'role:participant'])->name('participant.')->group(function () {
    Route::get('/my-tickets', [ParticipantController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [ParticipantController::class, 'index'])->name('events.index');
    Route::get('/events/{id}', [ParticipantController::class, 'show'])->name('events.show');
    Route::post('/events/{id}/register', [RegistrationController::class, 'store'])->name('events.register');
});

require __DIR__.'/auth.php';
