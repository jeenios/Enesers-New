<?php

// routes/web.php

use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     // Tandai email user sebagai terverifikasi
//     $request->fulfill();

//     // Logout user setelah verifikasi
//     Auth::logout();

//     // Redirect kembali ke halaman login Filament
//     return redirect()
//         ->route('filament.auth.login')
//         ->with('status', 'Email berhasil diverifikasi! Silakan login kembali.');
// })->middleware(['signed'])->name('verification.verify');
