@extends('layouts.admin')

@section('title', 'Create New Loan')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-700">
        <h2 class="text-2xl font-bold text-white">Create New Loan</h2>
    </div>

    <form action="{{ route('admin.loans.store') }}" method="POST" class="p-8">
        @csrf

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-700">Please fix these errors:</h3>
                    <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Content -->
        <div class="space-y-6">
            <!-- User Selection -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
                <div class="relative">
                    <select name="user_id" class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Book Selection -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Book</label>
                <div class="relative">
                    <select name="book_id" class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors">
                        @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} (Available: {{ $book->available }})
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quantity Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors">
            </div>

            <!-- Due Date Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-8">
            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors focus:ring-2 focus:ring-indigo-200 focus:ring-offset-2">
                Create Loan
            </button>
        </div>
    </form>
</div>
@endsection