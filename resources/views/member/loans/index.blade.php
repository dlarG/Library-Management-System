@extends('layouts.member')

@section('title', 'My Loans')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-blue-100 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">My Loans</h2>
            <div class="flex gap-4">
                <input type="text" placeholder="Search loans..." class="px-4 py-2 border rounded-lg w-64">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($loans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-9 bg-blue-100 rounded-md flex items-center justify-center overflow-hidden">
                                    @if($loan->book->cover_image)
                                        <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                                             alt="{{ $loan->book->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $loan->book->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $loan->book->author->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loan->loan_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loan->due_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span @class([
                                'px-2 py-1 text-xs rounded-full',
                                'bg-green-100 text-green-800' => $loan->status === 'returned',
                                'bg-yellow-100 text-yellow-800' => $loan->status === 'borrowed',
                                'bg-red-100 text-red-800' => $loan->status === 'overdue'
                            ])>
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('member.loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-blue-100">
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection