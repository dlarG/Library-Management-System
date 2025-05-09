@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
            <p class="text-sm text-gray-500 mt-1">Update user information and permissions</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.show', $user->id) }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Profile
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

@if($errors->any())
<div class="mb-6 p-5 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">Please fix the following errors:</span>
    </div>
    <ul class="mt-3 pl-5 list-disc text-sm space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="mb-6 p-5 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-8 space-y-8">
            <!-- Profile Picture -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
                    <div class="flex items-center">
                        <div class="relative h-24 w-24 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-200 shadow-inner">
                            @if($user->user_cover)
                                <img src="{{ asset('storage/' . $user->user_cover) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                <svg class="absolute h-full w-full text-gray-300 p-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                            <div id="profilePreview" class="absolute inset-0 bg-cover bg-center hidden"></div>
                        </div>
                        <label for="user_cover" class="ml-6 cursor-pointer">
                            <div class="px-5 py-3.5 border border-gray-300 rounded-xl shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Change Image
                                </span>
                            </div>
                            <input id="user_cover" name="user_cover" type="file" class="sr-only" accept="image/*">
                        </label>
                        @if($user->user_cover)
                        <button type="button" onclick="confirmImageRemoval()" class="ml-4 px-4 py-2.5 border border-red-300 rounded-xl text-sm font-medium text-red-700 hover:bg-red-50 transition-colors duration-200">
                            Remove
                        </button>
                        @endif
                    </div>
                    <p class="mt-3 text-xs text-gray-500">JPG, PNG or GIF (Max 2MB)</p>
                </div>
            </div>

            <!-- Name and Username -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-3">Full Name *</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-100 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-3">Username *</label>
                    <div class="relative">
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                            class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all duration-200 @error('username') border-red-500 ring-2 ring-red-100 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">@</span>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">Letters, numbers and underscores only</p>
                </div>
            </div>

            <!-- Email -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-3">Email Address *</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-100 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Update (Optional) -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Password Update (Optional)</h3>
                        <p class="text-sm text-gray-500 mb-6">Leave blank to keep current password</p>
                        
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-3">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all duration-200 @error('password') border-red-500 ring-2 ring-red-100 @enderror">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" class="text-gray-400 hover:text-indigo-500 focus:outline-none transition-colors duration-200" onclick="togglePassword('password')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="flex items-center mb-1">
                                        <div id="strength-meter" class="h-1.5 flex-1 bg-gray-200 rounded-full overflow-hidden">
                                            <div id="strength-bar" class="h-full bg-gray-400 w-0 transition-all duration-300"></div>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500">Must contain uppercase, lowercase, number (min 8 chars)</p>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-3">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all duration-200">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" class="text-gray-400 hover:text-indigo-500 focus:outline-none transition-colors duration-200" onclick="togglePassword('password_confirmation')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 flex items-center">
                                    <svg id="password-match" class="h-4 w-4 text-transparent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <p id="password-match-text" class="text-xs text-gray-500">Passwords must match</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Type and Verification -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="roleType" class="block text-sm font-medium text-gray-700 mb-3">User Role *</label>
                    <div class="relative">
                        <select id="roleType" name="roleType" required
                            class="block w-full px-5 py-3.5 text-base rounded-xl border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 appearance-none bg-white bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='currentColor' viewBox='0 0 24 24'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3e%3c/path%3e%3c/svg%3e")] bg-no-repeat bg-[right_1rem_center] bg-[length:1.25rem_1.25rem] pr-10 transition-all duration-200 @error('roleType') border-red-500 ring-2 ring-red-100 @enderror">
                            <option value="admin" {{ old('roleType', $user->roleType) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="librarian" {{ old('roleType', $user->roleType) == 'librarian' ? 'selected' : '' }}>Librarian</option>
                            <option value="member" {{ old('roleType', $user->roleType) == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Email Verification</label>
                    <div class="mt-1">
                        @if($user->email_verified_at)
                            <div class="inline-flex items-center px-4 py-3 rounded-xl bg-green-100 text-green-800">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Email Verified
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Verified on {{ $user->email_verified_at->format('M d, Y') }}</p>
                        @else
                            <div class="inline-flex items-center px-4 py-3 rounded-xl bg-yellow-100 text-yellow-800">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Email Not Verified
                            </div>
                            <button type="button" onclick="confirmSendVerification()" class="mt-3 px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                Send Verification Email
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Footer -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-right">
            <button type="button" onclick="window.location='{{ route('admin.users.show', $user->id) }}'" class="mr-4 px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Cancel
            </button>
            <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Update User
            </button>
        </div>
    </form>
    
    <!-- Image Removal Form (hidden) -->
    @if($user->user_cover)
    <form id="removeImageForm" action="{{ route('admin.users.remove-image', $user->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endif
    
    <!-- Verification Email Form (hidden) -->
    <form id="sendVerificationForm" action="{{ route('admin.users.send-verification', $user->id) }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('svg');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }

    // Preview profile image when selected
    document.getElementById('user_cover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('profilePreview');
                preview.style.backgroundImage = `url(${event.target.result})`;
                preview.classList.remove('hidden');
                preview.previousElementSibling.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Password strength meter
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBar = document.getElementById('strength-bar');
        let strength = 0;
        
        if (password.length > 0) strength += 1;
        if (password.length >= 8) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        const width = strength * 20;
        
        if (strength <= 2) {
            strengthBar.className = 'h-full bg-red-500 w-0 transition-all duration-300';
        } else if (strength <= 3) {
            strengthBar.className = 'h-full bg-yellow-500 w-0 transition-all duration-300';
        } else {
            strengthBar.className = 'h-full bg-green-500 w-0 transition-all duration-300';
        }
        
        strengthBar.style.width = `${width}%`;
    });

    // Password match checker
    document.getElementById('password_confirmation').addEventListener('input', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = e.target.value;
        const matchIcon = document.getElementById('password-match');
        const matchText = document.getElementById('password-match-text');
        
        if (confirmPassword.length === 0) {
            matchIcon.classList.add('text-transparent');
            matchText.textContent = 'Passwords must match';
            matchText.className = 'text-xs text-gray-500';
        } else if (password === confirmPassword) {
            matchIcon.classList.remove('text-transparent');
            matchIcon.classList.add('text-green-500');
            matchText.textContent = 'Passwords match';
            matchText.className = 'text-xs text-green-500';
        } else {
            matchIcon.classList.remove('text-transparent');
            matchIcon.classList.add('text-red-500');
            matchText.textContent = 'Passwords do not match';
            matchText.className = 'text-xs text-red-500';
        }
    });

    // Confirm image removal
    function confirmImageRemoval() {
        if (confirm('Are you sure you want to remove the profile picture?')) {
            document.getElementById('removeImageForm').submit();
        }
    }

    // Confirm send verification email
    function confirmSendVerification() {
        if (confirm('Send verification email to this user?')) {
            document.getElementById('sendVerificationForm').submit();
        }
    }
</script>
@endpush
@endsection