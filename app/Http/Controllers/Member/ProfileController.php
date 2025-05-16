<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('member.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Define base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'user_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Add current_password validation only when password is being changed
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validate($rules);

        try {
            $user->fill([
                'name' => $validated['name'],
                'username' => $validated['username'],
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }

            if ($request->hasFile('user_cover')) {
                if ($user->user_cover) {
                    Storage::delete('public/' . $user->user_cover);
                }
                $path = $request->file('user_cover')->store('user_covers', 'public');
                $user->user_cover = $path;
            }

            if ($request->has('remove_image') && $user->user_cover) {
                Storage::delete('public/' . $user->user_cover);
                $user->user_cover = null;
            }

            $user->save();

            return redirect()->route('member.profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
        
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'delete_confirmation' => ['required', 'in:DELETE'],
        ], [
            'delete_confirmation.in' => 'You must type DELETE to confirm.',
        ]);

        $user = Auth::user();

        // if ($user->user_cover) {
        //     Storage::delete('public/' . $user->user_cover);
        // }

        Auth::logout();

        $user->delete();

        return redirect('/login')->with('success', 'Your account has been deleted successfully.');
    }

}