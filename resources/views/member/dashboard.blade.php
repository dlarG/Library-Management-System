@extends('layouts.member')

@section('title', 'Member Dashboard')

@section('content')
@if (@session('success'))
<div id="successToast" class="fixed bottom-5 right-4 w-80 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg p-4 opacity-0 transform transition-all duration-300 translate-y-4">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" onclick="hideToast()" class="text-green-700 hover:text-green-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
@endif
@php
    $user = Auth::user();
    $currentLoans = $user->loans()
        ->with(['book.author', 'book.publisher'])
        ->whereIn('status', ['borrowed', 'overdue'])
        ->get();
    
    $overdueLoans = $currentLoans->filter(function($loan) {
        return $loan->due_date->isPast() && $loan->status !== 'returned';
    });

    $booksDueSoon = $currentLoans->filter(function($loan) {
        return $loan->due_date->isFuture() && $loan->due_date->diffInDays(now()) <= 3;
    });
@endphp

<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back, {{ $user->name }}!</h1>
                <p class="text-gray-600 mt-2">
                    @if($booksDueSoon->count() > 0)
                        You have {{ $booksDueSoon->count() }} {{ Str::plural('book', $booksDueSoon->count()) }} due soon.
                    @else
                        You have no upcoming due books. Keep reading! 📚
                    @endif
                </p>
            </div>
            <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Books Borrowed</p>
                    <p class="text-2xl font-bold mt-1">{{ $currentLoans->count() }}</p>
                </div>
                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Overdue Books</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $overdueLoans->count() }}</p>
                </div>
                <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Fines</p>
                    <p class="text-2xl font-bold mt-1">₱{{ number_format($user->fines()->sum('amount'), 2) }}</p>
                </div>
                <div class="h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Loans -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-blue-100 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">Current Loans</h2>
            <a href="{{ route('member.loans.index') }}" class="text-sm text-blue-600 hover:text-blue-500">View All →</a>
        </div>
        <div class="divide-y divide-blue-100">
            @forelse($currentLoans as $loan)
            <div class="p-4 hover:bg-blue-50">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-12 bg-blue-100 rounded-md flex items-center justify-center overflow-hidden">
                        @if($loan->book->cover_image)
                            <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                                 alt="{{ $loan->book->title }} cover" 
                                 class="w-full h-full object-cover">
                        @else
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">{{ $loan->book->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $loan->book->author->name }}</p>
                        <div class="mt-2 flex items-center space-x-4 text-sm">
                            @if($loan->status === 'overdue')
                                <span class="text-red-600">
                                    Overdue by {{ now()->diffInDays($loan->due_date) }} days
                                </span>
                            @else
                                <span class="{{ $loan->due_date->diffInDays(now()) <= 3 ? 'text-yellow-600' : 'text-blue-600' }}">
                                    Due in {{ $loan->due_date->diffForHumans(now(), ['syntax' => Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                                </span>
                            @endif
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">
                                Borrowed on {{ $loan->loan_date->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                No active loans found
            </div>
            @endforelse
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function hideToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => toast.remove(), 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('successToast');
        if (toast) {
            // Trigger reflow to apply initial styles
            toast.offsetHeight; // This forces a reflow
            toast.classList.remove('opacity-0', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            
            // Auto-hide after 5 seconds
            setTimeout(hideToast, 5000);
        }
    });
    </script>
@endpush
@endsection