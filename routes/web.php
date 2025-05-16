<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\FineControllerr;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\LoanController as MemberLoanController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\WishlistController;
use App\Http\Controllers\VerificationController;
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


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

Route::post('/email/verify/resend', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.resend');








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

    //Route for settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
    // Additional user verification routes
    Route::post('/users/{user}/send-verification', [UserController::class, 'sendVerification'])
        ->name('users.send-verification');
    Route::delete('/users/{user}/remove-image', [UserController::class, 'removeImage'])
        ->name('users.remove-image');
    
    // Route for authors section
    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::get('authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('authors', [AuthorController::class, 'store'])->name('authors.store');

    //Route for publisher
    Route::resource('publishers', PublisherController::class)->except(['show']);
    // Specifically for storing 
    Route::get('publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
    Route::post('publishers', [PublisherController::class, 'store'])->name('publishers.store');

    Route::post('/fines', [FineControllerr::class, 'store'])->name('fines.store');
    Route::post('/loans/{loan}/remind', [LoanController::class, 'sendReminder'])->name('loans.remind');
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/loans', [\App\Http\Controllers\Member\LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/{loan}', [\App\Http\Controllers\Member\LoanController::class, 'show'])->name('loans.show');
    
    // Books
    Route::get('/books', [\App\Http\Controllers\Member\BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [\App\Http\Controllers\Member\BookController::class, 'show'])->name('books.show');
    
    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\Member\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{book}', [\App\Http\Controllers\Member\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])
     ->name('wishlist.destroy');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/member/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});






// Common Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function() {
        return view('home');
    })->name('home');
});