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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
        
            // Check if email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You need to verify your email address first.',
                ])->onlyInput('email');
            }
        
            // Role-based redirection with authorization check
            $user = Auth::user();
            
            if ($user->roleType === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->roleType === 'librarian') {
                return redirect()->intended(route('librarian.dashboard'));
            } elseif ($user->roleType === 'member') {
                return redirect()->intended(route('member.dashboard'));
            }
            
            // Fallback for invalid roles
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has an invalid role configuration.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'], // Added regex validation
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'], // Stricter email validation
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'], // Stronger password
            'roleType' => ['required', 'string', 'in:member,admin,librarian'],
            'user_cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Added image upload validation
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roleType' => $request->roleType,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
