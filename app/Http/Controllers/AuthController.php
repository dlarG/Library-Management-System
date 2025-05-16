<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginview() {
        return view('auth.login');
    }
    public function login_pro(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Determine if login is email or username
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) 
            ? 'email'
            : 'username';

        $authAttempt = Auth::attempt(
            [$field => $credentials['login'], 'password' => $credentials['password']],
            $request->boolean('remember')
        );

        if ($authAttempt) {
            $request->session()->regenerate();
        
            // Email verification check
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'You need to verify your email address first.',
                ])->onlyInput('login');
            }
        
            // Role-based redirection
            $user = Auth::user();
            
            if ($user->roleType === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->roleType === 'librarian') {
                return redirect()->intended(route('librarian.dashboard'));
            } elseif ($user->roleType === 'member') {
                return redirect()->intended(route('member.dashboard'));
            }
            
            // Invalid role handling
            Auth::logout();
            return back()->withErrors([
                'login' => 'Your account has an invalid role configuration.',
            ])->onlyInput('login');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }
    public function registerview() {
        return view('auth.register');
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('status','Account logged out successfully!');
    }
    public function register_pro(Request $request) {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'], // Added regex validation
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'], // Stricter email validation
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'], // Stronger password
        ]);

        $validate['password'] = Hash::make($validate['password']);

        $user = User::create($validate);
        $user->sendEmailVerificationNotification(); // Send verification email
    
        return redirect('/login')->with('status', 'Account created successfully. Please check your email for verification instructions.');
    }
}
