@extends('layouts.librarian')

@section('title', 'Returns & Fines Management')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Returns & Fines Management</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fine Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($loans as $loan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $loan->book->title }}</div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span @class([
                            'px-2 py-1 text-xs rounded-full',
                            'bg-yellow-100 text-yellow-800' => $loan->status === 'borrowed',
                            'bg-red-100 text-red-800' => $loan->status === 'overdue'
                        ])>
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $loan->status === 'overdue' ? now()->diffInDays($loan->due_date) : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->fines->isNotEmpty())
                            ₱{{ number_format($loan->fines->first()->amount, 2) }}
                            <span class="text-xs ml-2 {{ $loan->fines->first()->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                ({{ $loan->fines->first()->status }})
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <!-- Add this after the fine amount column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->fines->isNotEmpty())
                            @php $fine = $loan->fines->first() @endphp
                            <div class="flex items-center space-x-2">
                                @if($fine->balance > 0)
                                    <form action="{{ route('librarian.payments.store', $fine) }}" method="POST" 
                                          class="flex items-center space-x-2">
                                        @csrf
                                        <input type="number" name="amount" step="0.01" min="0.01" 
                                               max="{{ number_format($fine->balance, 2) }}"
                                               class="w-24 px-2 py-1 border rounded" 
                                               placeholder="Amount" required>
                                        <select name="method" class="px-2 py-1 border rounded" required>
                                            <option value="cash">Cash</option>
                                            <option value="gcash">GCash</option>
                                            <option value="card">Credit Card</option>
                                        </select>
                                        <button type="submit" 
                                                class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            💳 Pay
                                        </button>
                                    </form>
                                    <span class="text-sm text-gray-500">
                                        Remaining: ₱{{ number_format($fine->balance, 2) }}
                                    </span>
                                @else
                                    <span class="text-green-600">Fully Paid</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($loan->status === 'overdue' && !$loan->fines()->exists())
                            <form action="{{ route('librarian.returns.apply-fine', $loan) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Apply Fine
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                <!-- Add this below the existing table row -->
                @if($loan->fines->isNotEmpty())
                <tr x-data="{ open: false }" class="bg-gray-50">
                    <td colspan="7" class="px-6 py-4">
                        @php $fine = $loan->fines->first() @endphp
                        <button @click="open = !open" class="text-indigo-600 hover:text-indigo-900 text-sm">
                            📜 {{ $fine->payments->count() }} Payment Records (₱{{ number_format($fine->paid_amount, 2) }} Paid)
                        </button>
                        
                        <div x-show="open" class="mt-2 space-y-2">
                            @forelse($fine->payments as $payment)
                                <div class="flex items-center justify-between bg-white p-3 rounded shadow">
                                    <div>
                                        <span class="font-medium">₱{{ number_format($payment->amount, 2) }}</span>
                                        <span class="text-sm text-gray-500 ml-2">via {{ ucfirst($payment->method) }}</span>
                                        @if($payment->notes)
                                            <p class="text-xs text-gray-400 mt-1">{{ $payment->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $payment->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-gray-500 text-sm">
                                    No payment history found
                                </div>
                            @endforelse
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $loans->links() }}
    </div>
</div>
@endsection