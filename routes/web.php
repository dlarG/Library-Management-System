<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Guest routes (unauthenticated users only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginview'])->name('login');
    Route::post('/login', [AuthController::class, 'login_pro'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'registerview'])->name('register');
    Route::post('/register', [AuthController::class, 'register_pro'])->name('register.post');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        
        // Redirect to appropriate dashboard after verification
        $user = $request->user();
        if ($user->roleType === 'admin') {
            return redirect()->route('admin.dashboard')->with('verified', true);
        } elseif ($user->roleType === 'librarian') {
            return redirect()->route('librarian.dashboard')->with('verified', true);
        }
        return redirect()->route('member.dashboard')->with('verified', true);
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// Role-based dashboard routes with multiple middleware protection
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard');
    
    // Add other admin-only routes here
});

Route::middleware(['auth', 'verified', 'role:librarian'])->prefix('librarian')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.librarian');
    })->name('librarian.dashboard');
    
    // Add other librarian-only routes here
});

Route::middleware(['auth', 'verified', 'role:member'])->prefix('member')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.member');
    })->name('member.dashboard');
    
    // Add other member-only routes here
});

// Home route (example)
Route::get('/home', function() {
    return view('home');
})->middleware(['auth', 'verified']);