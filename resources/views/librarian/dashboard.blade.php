@extends('layouts.librarian')

@section('title', 'Librarian Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Librarian Dashboard</h1>
        <div class="text-sm text-gray-600">
            Logged in as: {{ Auth::user()->name }} (Librarian)
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Active Loans</h3>
            <p class="text-2xl">{{--{{ $activeLoans }}--}}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Overdue Books</h3>
            <p class="text-2xl">{{--{{ $overdueLoans }}--}}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Available Books</h3>
            <p class="text-2xl">{{--{{ $availableBooks }}--}}</p>
        </div>
    </div>

    <!-- Recent Loans Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Recent Loans</h2>
        </div>
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                {{-- @foreach($recentLoans as $loan)
                <tr>
                    <td class="px-6 py-4">{{ $loan->user->name }}</td>
                    <td class="px-6 py-4">{{ $loan->book->title }}</td>
                    <td class="px-6 py-4">{{ $loan->due_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-sm rounded-full 
                            {{ $loan->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection