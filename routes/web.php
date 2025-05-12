<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
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

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');



// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginview'])->name('login');
    Route::post('/login', [AuthController::class, 'login_pro'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'registerview'])->name('register');
    Route::post('/register', [AuthController::class, 'register_pro'])->name('register.post');
});




// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');




// Email Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        
        // Redirect to appropriate dashboard after verification
        return match($request->user()->roleType) {
            'admin' => redirect()->route('admin.dashboard')->with('verified', true),
            'librarian' => redirect()->route('librarian.dashboard')->with('verified', true),
            default => redirect()->route('member.dashboard')->with('verified', true),
        };
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});





// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',[Controller::class,'dashboard'])->name('dashboard');
    // Book Resource Routes
    Route::resource('books', BookController::class);
    
    // User Resource Routes with additional verification routes
    Route::resource('users', UserController::class);
    
    //Loan Resource routes to view loans
    Route::resource('loans', LoanController::class);
    //ROute for reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
    // Additional user verification routes
    Route::post('/users/{user}/send-verification', [UserController::class, 'sendVerification'])
        ->name('users.send-verification');
    Route::delete('/users/{user}/remove-image', [UserController::class, 'removeImage'])
        ->name('users.remove-image');
    
    // Add other admin-only routes here
});






// Librarian Routes
Route::middleware(['auth', 'verified', 'role:librarian'])->prefix('librarian')->name('librarian.')->group(function () {
    Route::get('/dashboard', function () {
        return view('librarian.dashboard');
    })->name('dashboard');
    
    // Add other librarian-only routes here
});





// Member Routes
Route::middleware(['auth', 'verified', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', function () {
        return view('member.dashboard');
    })->name('dashboard');
    
    // Add other member-only routes here
});






// Common Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function() {
        return view('home');
    })->name('home');
});