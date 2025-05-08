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
                ]);
            }
        
            // Role-based redirection
            $role = Auth::user()->roleType;
        
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'librarian':
                    return redirect()->route('librarian.dashboard');
                case 'member':
                    return redirect()->route('member.dashboard');
                default:
                    return redirect('/'); // fallback
            }
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
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'roleType' => ['required', 'string', 'in:member,admin,librarian'], 
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
