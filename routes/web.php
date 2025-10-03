<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) { return redirect()->route('dashboard'); }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('registration.store');
    Route::get('/pendaftaran/{id}/preview', [RegistrationController::class, 'preview'])->name('registration.preview');
    Route::get('/pendaftaran/{id}/download', [RegistrationController::class, 'download'])->name('registration.download');

    // RUTE BARU UNTUK EDIT DAN UPDATE
    Route::get('/pendaftaran/{registration}/edit', [RegistrationController::class, 'edit'])->name('registration.edit');
    Route::patch('/pendaftaran/{registration}', [RegistrationController::class, 'update'])->name('registration.update');
});

require __DIR__.'/auth.php';