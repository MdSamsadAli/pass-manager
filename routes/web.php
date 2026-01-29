<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/test-mail', function () {
    try {
        \Mail::raw('OTP test mail', function ($message) {
            $message->to('samali2md@gmail.com')
                ->subject('Test OTP Mail');
        });

        return 'Mail sent successfully!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/dashboard', [FrontendController::class, 'index'])->name('dashboard');
    Route::post('/storepassword', [FrontendController::class, 'store'])->name('front.store');
    Route::get('/edit/{id}', [FrontendController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [FrontendController::class, 'update'])->name('front.update');
    Route::delete('/delete/{id}', [FrontendController::class, 'delete'])->name('front.delete');

    Route::get('/ajax-search', [FrontendController::class, 'ajaxSearch'])->name('front.ajaxSearch');


    Route::get('/bookmarklet', [FrontendController::class, 'bookmarklet']);
    Route::get('/social-media', [FrontendController::class, 'socialMedia'])->name('front.socialmedia');
    Route::get('/bank-details', [FrontendController::class, 'bankDetails'])->name('front.bankdetails');
    Route::get('/education-info', [FrontendController::class, 'educationInfo'])->name('front.educationinfo');
    Route::get('/notes', [FrontendController::class, 'notes'])->name('front.notes');
    Route::get('/blogs', [FrontendController::class, 'blogs'])->name('front.blogs');
    Route::get('/driving-licence', [FrontendController::class, 'drivingLicence'])->name('front.drivinglicence');
});

Route::middleware('guest')->group(function () {
    Route::get('/otp-verify', [AuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/otpverify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
});

require __DIR__ . '/auth.php';
