@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Books</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ App\Models\Book::count() }}</p>
                    <p class="text-xs text-green-500 mt-1">
                        <span class="font-medium">+{{ rand(5, 15) }}%</span> from last month
                    </p>
                </div>
                <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>
    
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Loans</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ App\Models\Loan::count() }}</p>
                    <p class="text-xs text-red-500 mt-1">
                        <span class="font-medium">+{{ rand(1, 10) }}%</span> from last week
                    </p>
                </div>
                <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
        </div>
    
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Registered Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ App\Models\User::count() }}</p>
                    <p class="text-xs text-green-500 mt-1">
                        <span class="font-medium">+{{ rand(5, 15) }}%</span> from last month
                    </p>
                </div>
                <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                    </svg>
                </div>
            </div>
        </div>
    
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Overdue Books</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ rand(5, 30) }}</p>
                    <p class="text-xs text-red-500 mt-1">
                        <span class="font-medium">+{{ rand(1, 5) }}</span> since yesterday
                    </p>
                </div>
                <div class="h-12 w-12 rounded-full bg-red-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Recent Activity</h2>
            </div>
            <div class="divide-y divide-gray-200">
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">New book loan</p>
                            <p class="text-sm text-gray-600">"The Silent Patient" borrowed by Sarah Johnson</p>
                            <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">Book returned</p>
                            <p class="text-sm text-gray-600">"Educated" by Tara Westover returned</p>
                            <p class="text-xs text-gray-500 mt-1">5 hours ago</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">New book added</p>
                            <p class="text-sm text-gray-600">"Project Hail Mary" by Andy Weir added to collection</p>
                            <p class="text-xs text-gray-500 mt-1">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 text-center">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all activity</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Quick Actions</h2>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('admin.books.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 border border-gray-200">
                    <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <span>Add New Book</span>
                </a>
                <a href="{{ route('admin.loans.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 border border-gray-200">
                    <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <span>Create New Loan</span>
                </a>
                <a href="{{ route('admin.users.create')}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 border border-gray-200">
                    <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <span>Register New User</span>
                </a>
                <a href="{{--{{ route('reports') }}--}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 border border-gray-200">
                    <div class="h-10 w-10 rounded-full bg-purple-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span>Generate Report</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Overdue Books -->
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">Overdue Books</h2>
            <a href="{{--{{ route('loans.overdue') }}--}}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrower</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Overdue</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">The Midnight Library</div>
                                    <div class="text-sm text-gray-500">Matt Haig</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Michael Brown</div>
                            <div class="text-sm text-gray-500">michael@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">May 15, 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">8 days</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Remind</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Fine</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Atomic Habits</div>
                                    <div class="text-sm text-gray-500">James Clear</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Emily Davis</div>
                            <div class="text-sm text-gray-500">emily@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">May 18, 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">5 days</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Remind</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Fine</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Where the Crawdads Sing</div>
                                    <div class="text-sm text-gray-500">Delia Owens</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Robert Wilson</div>
                            <div class="text-sm text-gray-500">robert@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">May 20, 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">3 days</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Remind</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Fine</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Members -->
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">Recent Members</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View All</a>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($recentUsers as $user)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full 
                        @php
                            $colors = ['bg-indigo-100', 'bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-purple-100', 'bg-pink-100'];
                            $textColors = ['text-indigo-600', 'text-blue-600', 'text-green-600', 'text-yellow-600', 'text-purple-600', 'text-pink-600'];
                            $colorIndex = crc32($user->name) % count($colors);
                        @endphp
                        {{ $colors[$colorIndex] }} flex items-center justify-center">
                        @php
                            // Get initials (first letter of first and last name)
                            $names = explode(' ', $user->name);
                            $initial = strtoupper(substr($names[0], 0, 1));
                            if (count($names) > 1) {
                                $initial .= strtoupper(substr(end($names), 0, 1));
                            }
                        @endphp
                        <span class="{{ $textColors[$colorIndex] }} font-medium">{{ $initial }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="inline-flex items-center text-sm text-gray-500">
                        Member since {{ $user->created_at->format('M Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection