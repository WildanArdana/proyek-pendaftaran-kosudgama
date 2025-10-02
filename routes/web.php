<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Models\Registration; // <-- Tambahkan ini
use Barryvdh\DomPDF\Facade\Pdf; // <-- Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Grup Rute untuk Pendaftaran Publik (lebih rapi)
Route::controller(RegistrationController::class)->group(function () {
    Route::get('/pendaftaran', 'create')->name('registration.create');
    Route::post('/pendaftaran', 'store')->name('registration.store');
    Route::get('/pendaftaran/sukses', 'success')->name('registration.success');
});

// Rute Admin untuk Download PDF Formulir Pendaftaran
// Penting: Rute ini harus dilindungi agar hanya admin yang bisa akses
Route::get('/admin/registrations/{registration}/download-pdf', function(Registration $registration) {
    // Membuat PDF dari view 'pdf.registration' dengan data pendaftar
    $pdf = Pdf::loadView('pdf.registration', ['registration' => $registration]);
    
    // Memberikan nama file dan memulai download
    return $pdf->download('formulir-pendaftaran-'.$registration->nama_lengkap.'.pdf');
    
})->middleware('auth')->name('registration.download-pdf'); // <-- Lindungi dengan middleware
