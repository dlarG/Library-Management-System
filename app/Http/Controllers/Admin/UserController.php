<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(6);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'roleType' => ['required', 'string', 'in:member,admin,librarian'],
            'user_cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('user_cover')) {
            $imagePath = $request->file('user_cover')->store('user-covers', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'roleType' => $validated['roleType'],
            'user_cover' => $imagePath, // Save the path directly
        ]);

        $user->sendEmailVerificationNotification();
        return redirect()->route('admin.users.index')
        ->with('success', 'User created successfully! Verification email sent.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id, 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'roleType' => ['required', 'string', 'in:member,admin,librarian'],
            'user_cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'roleType' => $validated['roleType'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        if ($request->has('remove_image') && $user->user_cover) {
            Storage::disk('public')->delete($user->user_cover);
            $updateData['user_cover'] = null;
        }

        if ($request->hasFile('user_cover')) {
            if ($user->user_cover) {
                Storage::disk('public')->delete($user->user_cover);
            }
            $path = $request->file('user_cover')->store('user_covers', 'public');
            $user->user_cover = $path;
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->user_cover) {
            Storage::disk('public')->delete($user->user_cover);
        }
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function sendVerification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->back()
                ->with('warning', 'User is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return redirect()->back()
            ->with('success', 'Verification email sent successfully!');
    }

    public function removeImage(User $user)
    {
        if ($user->user_cover) {
            Storage::disk('public')->delete($user->user_cover);
            $user->update(['user_cover' => null]);
            
            return redirect()->back()
                ->with('success', 'Profile image removed successfully!');
        }

        return redirect()->back()
            ->with('warning', 'No profile image to remove.');
    }
}