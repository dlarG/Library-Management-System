@extends('layouts.librarian')

@section('title', 'Member Details')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Member Details</h2>
        <a href="{{ route('librarian.members.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to List</a>
    </div>

    <div class="p-6">
        <div class="flex items-start gap-6">
            <!-- Profile Section -->
            <div class="w-48">
                @if($user->user_cover)
                <img src="{{ asset('storage/' . $user->user_cover) }}" 
                     alt="{{ $user->name }}" 
                     class="w-32 h-32 rounded-full object-cover border-2 border-indigo-100">
                @else
                <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif
            </div>

            <!-- Member Info -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Full Name</p>
                    <p class="mt-1">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email Address</p>
                    <p class="mt-1">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Registration Date</p>
                    <p class="mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email Verification</p>
                    <p class="mt-1">
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Loans & Fines Section -->
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <!-- Active Loans -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium mb-4">Active Loans</h3>
                @if($user->loans->whereIn('status', ['borrowed', 'overdue'])->count() > 0)
                <div class="space-y-3">
                    @foreach($user->loans->whereIn('status', ['borrowed', 'overdue']) as $loan)
                    <div class="bg-white p-3 rounded shadow-sm">
                        <p class="font-medium">{{ $loan->book->title }}</p>
                        <p class="text-sm text-gray-500">Due: {{ $loan->due_date->format('M d, Y') }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $loan->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm">No active loans</p>
                @endif
            </div>

            <!-- Fines History -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium mb-4">Fines History</h3>
                @if($user->fines->count() > 0)
                <div class="space-y-3">
                    @foreach($user->fines as $fine)
                    <div class="bg-white p-3 rounded shadow-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">₱{{ number_format($fine->amount, 2) }}</p>
                            <span class="text-xs px-2 py-1 rounded-full {{ $fine->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($fine->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $fine->created_at->format('M d, Y') }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm">No fines recorded</p>
                @endif
            </div>
        </div>

        <!-- Loan History Table -->
        <div class="mt-8">
            <h3 class="text-lg font-medium mb-4">Loan History</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Return Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->loans as $loan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->loan_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $loan->return_date ? $loan->return_date->format('M d, Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $loan->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection