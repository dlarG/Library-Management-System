@extends('layouts.librarian')

@section('title', 'Generated Report')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold capitalize">{{ $validated['type'] }} Report</h2>
            <p class="text-sm text-gray-600 mt-1">
                {{ Carbon\Carbon::parse($validated['start_date'])->format('M d, Y') }} - 
                {{ Carbon\Carbon::parse($validated['end_date'])->format('M d, Y') }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['download' => 'pdf']) }}" 
               class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Download PDF
            </a>
            <button onclick="window.print()" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Print
            </button>
        </div>
    </div>

    <div class="p-6">
        @if($validated['type'] === 'loans')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Checkout Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Return Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reportData as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->due_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $loan->return_date ? $loan->return_date->format('M d, Y') : 'Not Returned' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No loan records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @elseif($validated['type'] === 'fines')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reportData as $fine)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $fine->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ number_format($fine->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $fine->paid_at?->format('M d, Y') ?? 'Unpaid' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Book: {{ $fine->loan->book->title }}<br>
                                    Due Date: {{ $fine->loan->due_date->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No fine records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @elseif($validated['type'] === 'overdue')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Checkout Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days Overdue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reportData as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loan->due_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-red-600">
                                    {{ now()->diffInDays($loan->due_date) }} days
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No overdue books found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <p class="text-sm text-gray-600">Generated on {{ now()->format('M d, Y h:i A') }}</p>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('librarian.reports.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Reports</a>
</div>
@endsection