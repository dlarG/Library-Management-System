@extends('layouts.librarian')

@section('title', 'Member Management')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-lg font-semibold">Member Management</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <input type="text" id="search" placeholder="Search members..." 
                       class="w-full px-4 py-2 border rounded-lg sm:w-64 order-2 sm:order-1">
                <a href="{{ route('librarian.members.create') }}" 
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center sm:order-2">
                    Add New Member
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 sm:table hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loans</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($members as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if ($member->user_cover)
                                <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-indigo-100 mr-3">
                                    <img src="{{ asset('storage/' . $member->user_cover) }}" 
                                         alt="{{ $member->name }}" 
                                         class="h-full w-full object-cover">
                                </div>
                            @else
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            {{ $member->name }}
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">{{ $member->email }}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">{{ $member->loans_count }}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full {{ $member->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $member->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('librarian.members.show', $member) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            <a href="{{ route('librarian.members.edit', $member) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mobile List View -->
        <div class="sm:hidden">
            @foreach($members as $member)
            <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @if ($member->user_cover)
                            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-indigo-100 mr-3">
                                <img src="{{ asset('storage/' . $member->user_cover) }}" 
                                     alt="{{ $member->name }}" 
                                     class="h-full w-full object-cover">
                            </div>
                        @else
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-medium text-gray-900">{{ $member->name }}</div>
                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('librarian.members.show', $member) }}" class="text-indigo-600 hover:text-indigo-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('librarian.members.edit', $member) }}" class="text-yellow-600 hover:text-yellow-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <span class="px-2 py-1 text-xs rounded-full {{ $member->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $member->email_verified_at ? 'Verified' : 'Unverified' }}
                    </span>
                    <div class="text-sm text-gray-500">
                        {{ $member->loans_count }} Active Loans
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $members->onEachSide(1)->links() }}
    </div>
</div>
@endsection