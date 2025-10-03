<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Proses penyimpanan formulir
    Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('registration.store');
    
    // Rute Baru untuk Preview dan Download
    Route::get('/pendaftaran/{id}/preview', [RegistrationController::class, 'preview'])->name('registration.preview');
    Route::get('/pendaftaran/{id}/download', [RegistrationController::class, 'download'])->name('registration.download');
});

require __DIR__.'/auth.php';