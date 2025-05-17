@extends('layouts.librarian')

@section('title', 'Create New Member')
@push('styles')
    <style>
        input {
            height: 40px;
        }
        @media (max-width: 640px) {
            .mobile-stack {
                flex-direction: column;
            }
            .mobile-mt-2 {
                margin-top: 0.5rem;
            }
        }
    </style>
@endpush
@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Create New Member</h2>
        <a href="{{ route('librarian.members.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Cancel</a>
    </div>

    <div class="p-4 sm:p-6">
        <form action="{{ route('librarian.members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
                    <div class="flex mobile-stack items-start gap-4">
                        <div class="relative h-24 w-24 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-200 shadow-inner flex-shrink-0">
                            <svg class="absolute h-full w-full text-gray-300 p-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <div id="profilePreview" class="absolute inset-0 bg-cover bg-center hidden"></div>
                        </div>
                        <div class="flex-grow">
                            <label for="user_cover" class="cursor-pointer">
                                <div class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 w-max">
                                    Upload Image
                                    <input id="user_cover" name="user_cover" type="file" class="sr-only" accept="image/*">
                                </div>
                            </label>
                            <p class="mt-2 text-xs text-gray-500">JPG, PNG or GIF (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username *</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-sm">@</span>
                        <input type="text" name="username" id="username" 
                               value="{{ old('username') }}"
                               class="block w-full pl-8 pr-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required
                               pattern="[a-zA-Z0-9_]+">
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Letters, numbers and underscores only</p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                    <input type="password" name="password" id="password" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                    Create Member
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Profile image preview
    document.getElementById('user_cover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('profilePreview');
        const defaultIcon = preview.previousElementSibling;
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.style.backgroundImage = `url(${event.target.result})`;
                preview.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
                preview.style.backgroundImage = '';
                preview.classList.add('hidden');
                defaultIcon.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection