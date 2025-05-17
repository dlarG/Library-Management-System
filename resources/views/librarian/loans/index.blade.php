@extends('layouts.librarian')

@section('title', 'Loan Management')

@section('content')
@if(session('success'))
<div id="successToast" class="fixed bottom-5 right-4 w-80 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg p-4 opacity-0 transform transition-all duration-300 translate-y-4 sm:w-64">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" onclick="hideToast()" class="text-green-700 hover:text-green-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header Section -->
    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
            <h2 class="text-lg font-semibold">Loan Management</h2>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-40">
                    <select id="statusFilter" class="block appearance-none w-full pl-4 pr-8 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700 bg-white"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>');
                                   background-repeat: no-repeat;
                                   background-position: right 0.75rem center;
                                   background-size: 1em;">
                        <option value="">All Statuses</option>
                        <option value="borrowed">Borrowed</option>
                        <option value="returned">Returned</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                
                <input type="text" id="search" placeholder="Search loans..." 
                       class="w-full px-4 py-2 border rounded-lg sm:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                
                <a href="{{ route('librarian.loans.create') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center transition-colors duration-200">
                    New Loan
                </a>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="loansTableBody">
                @foreach($loans as $loan)
                <tr class="loan-row hover:bg-gray-50 transition-colors duration-150" 
                    data-user="{{ strtolower($loan->user->name) }}"
                    data-book="{{ strtolower($loan->book->title) }}"
                    data-loan-date="{{ $loan->loan_date->format('Y-m-d') }}"
                    data-due-date="{{ $loan->due_date->format('Y-m-d') }}"
                    data-status="{{ strtolower($loan->status) }}">
                    <!-- Desktop Table Cells -->
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title }}</td>
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
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="relative inline-block text-left">
                            <button type="button" class="inline-flex items-center p-2 rounded-lg hover:bg-gray-100 focus:outline-none" 
                                    data-dropdown-toggle="dropdown-{{ $loan->id }}">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="1.5" />
                                    <circle cx="6" cy="12" r="1.5" />
                                    <circle cx="18" cy="12" r="1.5" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50" 
                                 id="dropdown-{{ $loan->id }}">
                                <div class="py-1" role="menu">
                                    <!-- Remind Button -->
                                    <form action="{{ route('librarian.loans.remind', $loan) }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @csrf
                                        <button type="submit" class="w-full text-left">⏰ Remind</button>
                                    </form>
                    
                                    <!-- Fine Button -->
                                    <button type="button" 
                                            class="block w-full px-4 py-2 text-sm text-left 
                                                   @if($loan->status !== 'overdue') text-gray-400 cursor-not-allowed @else text-red-600 hover:bg-gray-100 @endif"
                                            @if($loan->status !== 'overdue') disabled @endif
                                            onclick="document.getElementById('fine-form-{{ $loan->id }}').submit()">
                                        💰 Fine
                                    </button>
                                    <form id="fine-form-{{ $loan->id }}" 
                                          action="{{ route('librarian.loans.fine', $loan) }}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                    </form>
                    
                                    <!-- Mark Returned Button -->
                                    @if($loan->status === 'borrowed')
                                    <form action="{{ route('librarian.loans.update', $loan) }}" method="POST" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                                        @csrf @method('PUT')
                                        <button type="submit" class="w-full text-left">✅ Mark Returned</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="sm:hidden">
        @foreach($loans as $loan)
        <div class="border-b border-gray-200 p-4 hover:bg-gray-50 loan-card"
             data-user="{{ strtolower($loan->user->name) }}"
             data-book="{{ strtolower($loan->book->title) }}"
             data-loan-date="{{ $loan->loan_date->format('Y-m-d') }}"
             data-due-date="{{ $loan->due_date->format('Y-m-d') }}"
             data-status="{{ strtolower($loan->status) }}">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <div>
                        <div class="font-medium text-gray-900">{{ $loan->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $loan->book->title }}</div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <div class="text-sm">
                            <span class="font-medium">Loan:</span> 
                            {{ $loan->loan_date->format('M d, Y') }}
                        </div>
                        <div class="text-sm">
                            <span class="font-medium">Due:</span> 
                            {{ $loan->due_date->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-2">
                    <span @class([
                        'px-2 py-1 text-xs rounded-full',
                        'bg-green-100 text-green-800' => $loan->status === 'returned',
                        'bg-yellow-100 text-yellow-800' => $loan->status === 'borrowed',
                        'bg-red-100 text-red-800' => $loan->status === 'overdue'
                    ])>
                        {{ ucfirst($loan->status) }}
                    </span>
                    
                    <div class="relative inline-block text-left">
                        <button type="button" class="p-1 rounded-lg hover:bg-gray-100"
                                onclick="toggleMobileDropdown('mobile-dropdown-{{ $loan->id }}')">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="1.5" />
                                <circle cx="6" cy="12" r="1.5" />
                                <circle cx="18" cy="12" r="1.5" />
                            </svg>
                        </button>
                        
                        <!-- Mobile Dropdown -->
                        <div id="mobile-dropdown-{{ $loan->id }}" 
                             class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1" role="menu">
                                <!-- Dropdown items same as desktop -->
                                <form action="{{ route('librarian.loans.remind', $loan) }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full text-left">⏰ Remind</button>
                                </form>
                                
                                <button type="button" 
                                        class="block w-full px-4 py-2 text-sm text-left 
                                               @if($loan->status !== 'overdue') text-gray-400 cursor-not-allowed @else text-red-600 hover:bg-gray-100 @endif"
                                        @if($loan->status !== 'overdue') disabled @endif
                                        onclick="document.getElementById('fine-form-{{ $loan->id }}').submit()">
                                    💰 Fine
                                </button>
                                
                                @if($loan->status === 'borrowed')
                                <form action="{{ route('librarian.loans.update', $loan) }}" method="POST" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                                    @csrf @method('PUT')
                                    <button type="submit" class="w-full text-left">✅ Mark Returned</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $loans->onEachSide(1)->links() }}
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 640px) {
        .loan-card {
            padding: 1rem;
        }
        
        .mobile-dropdown {
            right: 0;
            left: auto;
            width: 100%;
            max-width: 200px;
        }
        
        .pagination .flex {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination li {
            margin: 2px;
        }
    }
</style>
@endsection
@endpush

@push('scripts')
<script>
    function hideToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => toast.remove(), 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.offsetHeight;
            toast.classList.remove('opacity-0', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            setTimeout(hideToast, 5000);
        }

        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('statusFilter');
        const loanRows = document.querySelectorAll('.loan-row');
        const loanCards = document.querySelectorAll('.loan-card');

        function filterElements(elements, searchTerm, selectedStatus) {
            let hasVisible = false;
            
            elements.forEach(element => {
                const user = element.dataset.user;
                const book = element.dataset.book;
                const loanDate = element.dataset.loanDate;
                const dueDate = element.dataset.dueDate;
                const status = element.dataset.status;

                const matchesSearch = user.includes(searchTerm) || 
                                    book.includes(searchTerm) || 
                                    loanDate.includes(searchTerm) || 
                                    dueDate.includes(searchTerm) || 
                                    status.includes(searchTerm);

                const matchesStatus = !selectedStatus || status === selectedStatus;

                if (matchesSearch && matchesStatus) {
                    element.style.display = '';
                    hasVisible = true;
                } else {
                    element.style.display = 'none';
                }
            });

            return hasVisible;
        }

        function filterLoans() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            const selectedStatus = statusFilter.value.toLowerCase();
            
            const hasTableResults = filterElements(loanRows, searchTerm, selectedStatus);
            const hasCardResults = filterElements(loanCards, searchTerm, selectedStatus);
            const hasAnyResults = hasTableResults || hasCardResults;

            // Handle no results
            const noResults = document.getElementById('noResults');
            if (!hasAnyResults) {
                if (!noResults) {
                    const tr = document.createElement(loanRows.length ? 'tr' : 'div');
                    tr.id = 'noResults';
                    tr.innerHTML = `
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No loans found matching your criteria
                        </td>`;
                    if (loanRows.length) {
                        document.querySelector('tbody').appendChild(tr);
                    } else {
                        document.querySelector('.sm\\:hidden').appendChild(tr);
                    }
                }
            } else if (noResults) {
                noResults.remove();
            }
        }

        // Event listeners
        statusFilter.addEventListener('change', filterLoans);
        searchInput.addEventListener('input', filterLoans);
        filterLoans();

        // Dropdown handlers
        document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdownId = this.getAttribute('data-dropdown-toggle');
                const dropdown = document.getElementById(dropdownId);
                dropdown.classList.toggle('hidden');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    });

    function toggleMobileDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
        
        document.querySelectorAll('.mobile-dropdown').forEach(d => {
            if (d.id !== dropdownId) d.classList.add('hidden