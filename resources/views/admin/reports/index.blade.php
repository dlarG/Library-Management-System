@extends('layouts.admin')

@section('title', 'System Reports')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Report Filters -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold">System Reports</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.print', request()->query()) }}" 
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h1a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h1m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </a>
        </div>
    </div>
    <div class="p-6 border-b border-gray-200">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', request('start_date')) }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', request('end_date')) }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div class="self-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Generate Report
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6">
        <div class="bg-indigo-50 p-4 rounded-lg">
            <dt class="text-sm font-medium text-indigo-600">Total Loans</dt>
            <dd class="mt-1 text-3xl font-semibold">{{ number_format($loanStats['total_loans']) }}</dd>
        </div>
        <div class="bg-red-50 p-4 rounded-lg">
            <dt class="text-sm font-medium text-red-600">Overdue Loans</dt>
            <dd class="mt-1 text-3xl font-semibold">{{ number_format($loanStats['overdue']) }}</dd>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <dt class="text-sm font-medium text-green-600">Avg. Loan Days</dt>
            <dd class="mt-1 text-3xl font-semibold">{{ number_format($loanStats['avg_loan_duration'], 1) }}</dd>
        </div>
    </div>

    <!-- Popular Books Section -->
    <div class="p-6 border-t border-gray-200">
        <h3 class="text-lg font-medium mb-4">Most Borrowed Books</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Loans</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available Copies</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($popularBooks as $book)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $book->loans_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $book->available }}/{{ $book->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Active Users Section -->
    <div class="p-6 border-t border-gray-200">
        <h3 class="text-lg font-medium mb-4">Most Active Users</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($userActivity as $user)
            <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                <div class="h-10 w-10 rounded-full overflow-hidden mr-3">
                    @if($user->user_cover)
                        <img src="{{ asset('storage/' . $user->user_cover) }}" 
                             alt="{{ $user->name }}" 
                             class="h-full w-full object-cover">
                    @else
                        @php
                            $names = explode(' ', $user->name);
                            $initial = strtoupper(substr($names[0], 0, 1));
                            if(count($names) > 1) {
                                $initial .= strtoupper(substr(end($names), 0, 1));
                            }
                            $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500'];
                            $colorIndex = crc32($user->name) % count($colors);
                        @endphp
                        <div class="h-full w-full flex items-center justify-center {{ $colors[$colorIndex] }} text-white font-semibold">
                            {{ $initial }}
                        </div>
                    @endif
                </div>
                <div>
                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->loans_count }} loans</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection