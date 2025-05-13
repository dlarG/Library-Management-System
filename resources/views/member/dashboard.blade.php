@extends('layouts.member')

@section('title', 'Member Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-2">You have 3 books due soon. Keep reading! 📚</p>
            </div>
            <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Books Borrowed</p>
                    <p class="text-2xl font-bold mt-1">12</p>
                </div>
                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Overdue Books</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">2</p>
                </div>
                <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Reading Time</p>
                    <p class="text-2xl font-bold mt-1">18h</p>
                </div>
                <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Wishlist Items</p>
                    <p class="text-2xl font-bold mt-1">5</p>
                </div>
                <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Loans -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-blue-100 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">Current Loans</h2>
            <a href="{{--{{ route('member.loans') }}--}}" class="text-sm text-blue-600 hover:text-blue-500">View All →</a>
        </div>
        <div class="divide-y divide-blue-100">
            <div class="p-4 hover:bg-blue-50">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-12 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">The Silent Patient</h3>
                        <p class="text-sm text-gray-600">Alex Michaelides</p>
                        <div class="mt-2 flex items-center space-x-4 text-sm">
                            <span class="text-blue-600">Due in 3 days</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">Borrowed on: Apr 10, 2025</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 hover:bg-blue-50">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-12 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">Atomic Habits</h3>
                        <p class="text-sm text-gray-600">James Clear</p>
                        <div class="mt-2 flex items-center space-x-4 text-sm">
                            <span class="text-blue-600">Due in 5 days</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">Borrowed on: Apr 8, 2025</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 hover:bg-blue-50">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-12 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">Deep Work</h3>
                        <p class="text-sm text-gray-600">Cal Newport</p>
                        <div class="mt-2 flex items-center space-x-4 text-sm">
                            <span class="text-red-600">Overdue by 2 days</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">Borrowed on: Mar 25, 2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection