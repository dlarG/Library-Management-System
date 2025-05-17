<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = User::where('roleType', 'member')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->withCount(['loans' => fn($q) => $q->whereIn('status', ['borrowed', 'overdue'])])
            ->paginate(10);

        return view('librarian.members.index', compact('members'));
    }

    public function show(User $user)
    {
        $user->load(['loans.book', 'fines.payments']);
        return view('librarian.members.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('librarian.members.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'status' => 'required|in:active,suspended'
        ]);

        $user->update($validated);
        return redirect()->route('librarian.members.show', $user)->with('success', 'Member updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('librarian.members.index')->with('success', 'Member removed');
    }
    public function create()
    {
        return view('librarian.members.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            'roleType' => 'member', // Set default role to member
            'user_cover' => $imagePath
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        return redirect()->route('librarian.members.index')
                        ->with('success', 'Member created successfully. Verification email sent.');
    }
}