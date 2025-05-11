@extends('layouts.admin')

@section('title', 'Loan Details')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Loan Details</h2>
    </div>

    <div class="p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">User</p>
                <p class="font-medium">{{ $loan->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Book</p>
                <p class="font-medium">{{ $loan->book->title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Loan Date</p>
                <p class="font-medium">{{ $loan->loan_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Due Date</p>
                <p class="font-medium">{{ $loan->due_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <span @class([
                    'px-2 py-1 text-xs rounded-full',
                    'bg-green-100 text-green-800' => $loan->status === 'returned',
                    'bg-yellow-100 text-yellow-800' => $loan->status === 'borrowed',
                    'bg-red-100 text-red-800' => $loan->status === 'overdue'
                ])>
                    {{ ucfirst($loan->status) }}
                </span>
            </div>
            @if($loan->return_date)
            <div>
                <p class="text-sm text-gray-600">Return Date</p>
                <p class="font-medium">{{ $loan->return_date->format('M d, Y') }}</p>
            </div>
            @endif
        </div>

        @if($loan->status === 'borrowed')
        <form action="{{ route('admin.loans.update', $loan) }}" method="POST">
            @csrf @method('PUT')
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Mark as Returned
            </button>
        </form>
        @endif
    </div>
</div>
@endsection