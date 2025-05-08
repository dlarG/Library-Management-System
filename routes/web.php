    <?php

    use App\Http\Controllers\AuthController;
    use GuzzleHttp\Psr7\Request;
    use Illuminate\Foundation\Auth\EmailVerificationRequest;
    use Illuminate\Support\Facades\Route;

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

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'loginview'])->name('login');
        Route::post('/login', [AuthController::class, 'login_pro'])->name('login.post');
        
        Route::get('/register', [AuthController::class, 'registerview'])->name('register');
        Route::post('/register', [AuthController::class, 'register_pro'])->name('register.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Email Verification Routes
    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('/dashboard')->with('verified', true);
        })->middleware('signed')->name('verification.verify');

        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'verification-link-sent');
        })->middleware('throttle:6,1')->name('verification.send');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboards.admin');
        })->name('admin.dashboard');
    
        Route::get('/librarian/dashboard', function () {
            return view('dashboards.librarian');
        })->name('librarian.dashboard');
    
        Route::get('/member/dashboard', function () {
            return view('dashboards.member');
        })->name('member.dashboard');
    });

    Route::get('/home', function() {
        return view('home');
    });