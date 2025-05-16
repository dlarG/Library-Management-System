@extends('layouts.member')

@section('title', 'Loan Details')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto">
        <!-- Loan Header -->
        <div class="p-6 border-b border-blue-100 bg-blue-50">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800">Loan Details</h1>
                <span class="px-3 py-1 text-sm rounded-full bg-white border border-blue-200 text-blue-600">
                    {{ strtoupper($loan->status) }}
                </span>
            </div>
            <p class="text-sm text-gray-600 mt-2">Loan ID: #{{ $loan->id }}</p>
        </div>

        <!-- Loan Timeline -->
        <div class="p-6 border-b border-blue-100">
            <div class="flex items-center justify-between text-sm">
                <div class="text-center">
                    <div class="h-2 w-2 bg-blue-600 rounded-full mb-2 mx-auto"></div>
                    <p class="font-medium">Borrowed</p>
                    <p class="text-gray-600">{{ $loan->loan_date->format('M d, Y') }}</p>
                </div>
                <div class="flex-1 border-t-2 border-dashed border-blue-200 mx-4"></div>
                <div class="text-center">
                    <div class="h-2 w-2 bg-blue-600 rounded-full mb-2 mx-auto"></div>
                    <p class="font-medium">Due</p>
                    <p class="text-gray-600">{{ $loan->due_date->format('M d, Y') }}</p>
                </div>
                @if($loan->return_date)
                <div class="flex-1 border-t-2 border-dashed border-blue-200 mx-4"></div>
                <div class="text-center">
                    <div class="h-2 w-2 bg-green-600 rounded-full mb-2 mx-auto"></div>
                    <p class="font-medium">Returned</p>
                    <p class="text-gray-600">{{ $loan->return_date->format('M d, Y') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Loan Details -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Book Information -->
            <div>
                <h2 class="text-lg font-medium text-gray-800 mb-4">Book Information</h2>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-24 h-32 bg-gray-100 rounded-md overflow-hidden">
                        @if($loan->book->cover_image)
                            <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                                 alt="{{ $loan->book->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $loan->book->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $loan->book->author->name }}</p>
                        <p class="text-sm text-gray-500 mt-2">ISBN: {{ $loan->book->isbn ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Published: {{ $loan->book->publication_year }}</p>
                    </div>
                </div>
            </div>

            <!-- Loan Summary -->
            <div>
                <h2 class="text-lg font-medium text-gray-800 mb-4">Loan Summary</h2>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div class="py-2 border-b border-gray-200">
                        <dt class="text-gray-600">Quantity</dt>
                        <dd class="font-medium text-gray-900">{{ $loan->quantity }}</dd>
                    </div>
                    <div class="py-2 border-b border-gray-200">
                        <dt class="text-gray-600">Days Overdue</dt>
                        <dd class="font-medium text-gray-900">
                            {{ $loan->status === 'overdue' ? now()->diffInDays($loan->due_date) : '0' }}
                        </dd>
                    </div>
                    <div class="py-2 border-b border-gray-200">
                        <dt class="text-gray-600">Fine Rate</dt>
                        <dd class="font-medium text-gray-900">₱{{ number_format($settings->daily_fine_rate ?? 0, 2) }}/day</dd>
                    </div>
                    <div class="py-2 border-b border-gray-200">
                        <dt class="text-gray-600">Total Fines</dt>
                        <dd class="font-medium text-gray-900">
                            ₱{{ number_format($loan->fines->sum('amount') ?? 0, 2) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Fines and Payments -->
        @if($loan->fines->isNotEmpty())
        <div class="p-6 border-t border-blue-100">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Fines & Payments</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loan->fines as $fine)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $fine->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                Overdue Fine ({{ $fine->overdue_days }} days)
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                ₱{{ number_format($fine->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $fine->balance > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $fine->balance > 0 ? 'Pending' : 'Paid' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="p-6 border-t border-blue-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <a href="{{ route('member.loans.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                    Back to Loans
                </a>
                {{-- @if($loan->status === 'borrowed')
                <form action="{{ route('admin.loans.update', $loan) }}" method="POST">
                    @csrf @method('PUT')
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                            onclick="return confirm('Mark this book as returned?')">
                        Mark as Returned
                    </button>
                </form>
                @endif --}}
            </div>
        </div>
    </div>
</div>
@endsection