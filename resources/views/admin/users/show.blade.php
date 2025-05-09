@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage user information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </div>
</div>

<div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
    <div class="p-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Left Column - Profile -->
            <div class="md:col-span-1">
                <div class="flex flex-col items-center">
                    <div class="relative h-40 w-40 rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-lg">
                        @if($user->user_cover)
                            <img src="{{ asset('storage/' . $user->user_cover) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            <svg class="h-full w-full text-gray-300 p-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        @endif
                    </div>
                    
                    <h2 class="mt-6 text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500"><span>@</span>{{ $user->username }}</p>
                    
                    <div class="mt-4 px-4 py-2 rounded-full bg-indigo-100 text-indigo-800 text-sm font-medium">
                        {{ ucfirst($user->roleType) }}
                    </div>
                    
                    <div class="mt-6 w-full">
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Account Status</h3>
                            <div class="mt-2 flex items-center">
                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Unverified
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 mt-4 pt-6">
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Member Since</h3>
                            <p class="mt-2 text-sm text-gray-900">
                                {{ $user->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Details -->
            <div class="md:col-span-2">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Full Name</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Username</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium"><span>@</span>{{ $user->username }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email Address</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium">{{ $user->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email Verified</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium">
                                @if($user->email_verified_at)
                                    {{ $user->email_verified_at->format('M d, Y H:i') }}
                                @else
                                    Not verified
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Account Created</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium">
                                {{ $user->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900 font-medium">
                                {{ $user->updated_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Sections -->
                <div class="mt-8 bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">User Activity</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Account Created</p>
                                <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        @if($user->email_verified_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Email Verified</p>
                                <p class="text-sm text-gray-500">{{ $user->email_verified_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Danger Zone -->
    <div class="border-t border-gray-200 bg-red-50 px-8 py-6">
        <h3 class="text-lg font-medium text-red-800 mb-4">Danger Zone</h3>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="max-w-xl">
                <p class="text-sm text-red-700">
                    Deleting a user account is permanent and cannot be undone. All associated data will be permanently removed.
                </p>
            </div>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete this user? This cannot be undone!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 flex items-center">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete User Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection