@extends('layouts.member')

@section('title', 'Edit Profile')

@section('content')
<div class="mb-10 max-w-3xl mx-auto space-y-6">
    <div class="bg-white shadow-md rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Edit Profile</h2>
            <p class="text-sm text-gray-500 mt-1">Update your profile details and security settings.</p>
        </div>

        @if(session('success'))
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            <strong>{{ session('success') }}</strong>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            <strong>{{ session('error') }}</strong>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Profile Image --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <div class="flex items-center space-x-4">
                    @if($user->user_cover)
                        <img src="{{ asset('storage/' . $user->user_cover) }}" class="h-20 w-20 rounded-full object-cover border border-gray-300 shadow-sm" alt="User Image">
                        <label for="user_cover" class="cursor-pointer px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-200 transition">Change</label>
                        <input id="user_cover" name="user_cover" type="file" class="sr-only" accept="image/*">
                        <button type="submit" name="remove_image" value="1" class="text-sm text-red-600 hover:underline">Remove</button>
                    @else
                        <label for="user_cover" class="cursor-pointer px-4 py-2 bg-blue-100 border border-blue-300 rounded-lg text-sm text-blue-700 hover:bg-blue-200 transition">
                            Upload Image
                        </label>
                        <input id="user_cover" name="user_cover" type="file" class="sr-only" accept="image/*">
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG. Max size: 2MB.</p>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input style="height: 45px;" type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input style="height: 45px;" type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                @error('username')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input style="height: 45px;" type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                    placeholder="Leave blank to keep current password">
                @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input style="height: 45px;" type="password" name="current_password" id="current_password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                    placeholder="Required to confirm changes">
                @error('current_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm transition">
                    Save Changes
                </button>
            </div>
        </form>
        <div class="p-6 border-t border-gray-100">
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-red-600">Danger Zone</h3>
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                    <div>
                        <p class="font-medium text-red-700">Delete Account</p>
                        <p class="text-sm text-red-600 mt-1">Once deleted, all your data will be permanently removed.</p>
                    </div>
                    <button 
                        onclick="showDeleteConfirmation()"
                        class="px-4 py-2 border border-red-600 text-red-600 rounded-md hover:bg-red-50 text-sm transition">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <form method="POST" action="{{ route('member.profile.destroy') }}" class="space-y-6 p-6">
            @csrf
            @method('DELETE')

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-red-600">Confirm Account Deletion</h3>
                <p class="text-gray-600">This action cannot be undone. Please type <span class="font-mono font-bold text-red-600">DELETE</span> to confirm.</p>
                
                <input 
                    type="text" 
                    id="delete_confirmation" 
                    name="delete_confirmation" 
                    required
                    class="w-full border border-red-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Type DELETE here">
                
                <div class="flex justify-end space-x-3">
                    <button 
                        type="button"
                        onclick="hideDeleteConfirmation()"
                        class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Delete Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function showDeleteConfirmation() {
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    
    function hideDeleteConfirmation() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteConfirmation();
        }
    });
    </script>
@endsection
