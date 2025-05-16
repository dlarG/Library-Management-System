<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Email already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);

        // Redirect based on role
        if ($user->roleType === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Email verified successfully!');
        } 
        else if ($user->roleType === 'librarian') {
            return redirect()->route('librarian.dashboard')->with('success', 'Email verified successfully!');
        }
        else {
            return redirect()->route('member.dashboard')->with('success', 'Email verified successfully!');
        }
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Email already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link resent!');
    }
}