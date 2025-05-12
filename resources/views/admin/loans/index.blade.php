@extends('layouts.admin')

@section('title', 'Loan Management')

@section('content')
@if(session('success'))
<div id="successToast" class="fixed bottom-5 right-4 w-80 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg p-4 opacity-0 transform transition-all duration-300 translate-y-4">
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
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Loan Management</h2>
        <div class="flex gap-4">
            <div class="relative">
                <select 
                    id="statusFilter" 
                    class="block appearance-none w-40 pl-4 pr-8 py-2 rounded-lg border border-gray-300 
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                           text-sm text-gray-700 bg-white"
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
            <input type="text" id="search" placeholder="Search loans..." class="w-64 px-4 py-2 border rounded-lg">
            <a href="{{ route('admin.loans.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                New Loan
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
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
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($loans as $loan)
                <tr class="loan-row hover:bg-gray-50 transition-colors duration-150" 
                data-user="{{ strtolower($loan->user->name) }}"
                data-book="{{ strtolower($loan->book->title) }}"
                data-loan-date="{{ $loan->loan_date->format('Y-m-d') }}"
                data-due-date="{{ $loan->due_date->format('Y-m-d') }}"
                data-status="{{ strtolower($loan->status) }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $loan->book->title }}</div>
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
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="relative inline-block text-left">
                            <button type="button" class="inline-flex items-center p-2 rounded-lg hover:bg-gray-100 focus:outline-none" 
                                    id="loan-options-{{ $loan->id }}" data-dropdown-toggle="dropdown-{{ $loan->id }}">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="1.5" />
                                    <circle cx="6" cy="12" r="1.5" />
                                    <circle cx="18" cy="12" r="1.5" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 dropdown-menu" 
                                id="dropdown-{{ $loan->id }}"
                                style="bottom: auto; top: unset;">
                                <div class="py-1" role="menu">
                                    <!-- Remind Button -->
                                    <form action="{{--{{ route('admin.loans.remind', $loan) }}--}}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @csrf
                                        <button type="submit" class="w-full text-left">
                                            ⏰ Remind
                                        </button>
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
                                          action="{{--{{ route('admin.loans.fine', $loan) }}--}}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                    </form>
                    
                                    <!-- Mark Returned Button -->
                                    @if($loan->status === 'borrowed')
                                    <form action="{{ route('admin.loans.update', $loan) }}" method="POST" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                                        @csrf @method('PUT')
                                        <button type="submit" class="w-full text-left">
                                            ✅ Mark Returned
                                        </button>
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

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $loans->links() }}
    </div>
</div>
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
            // Trigger reflow to apply initial styles
            toast.offsetHeight; // This forces a reflow
            toast.classList.remove('opacity-0', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            
            // Auto-hide after 5 seconds
            setTimeout(hideToast, 5000);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Existing toast code...

    const searchInput = document.getElementById('search');
    const loanRows = document.querySelectorAll('.loan-row');
    
    function filterLoans() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        let hasVisibleRows = false;
        
        loanRows.forEach(row => {
            const user = row.dataset.user;
            const book = row.dataset.book;
            const loanDate = row.dataset.loanDate;
            const dueDate = row.dataset.dueDate;
            const status = row.dataset.status;
            
            const matches = user.includes(searchTerm) || 
                          book.includes(searchTerm) || 
                          loanDate.includes(searchTerm) || 
                          dueDate.includes(searchTerm) || 
                          status.includes(searchTerm);
            
            row.style.display = matches ? '' : 'none';
            if (matches) hasVisibleRows = true;
        });
        
        // Handle no results
        const noResults = document.getElementById('noResults');
        if (!hasVisibleRows) {
            if (!noResults) {
                const tr = document.createElement('tr');
                tr.id = 'noResults';
                tr.innerHTML = `
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No loans found matching your search
                    </td>
                `;
                document.getElementById('loansTableBody').appendChild(tr);
            }
        } else if (noResults) {
            noResults.remove();
        }
    }
    
    searchInput.addEventListener('input', filterLoans);
    filterLoans(); // Initial filter

    
});

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
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        const dropdownId = button.getAttribute('data-dropdown-toggle');
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
});

const statusFilter = document.getElementById('statusFilter');
const searchInput = document.getElementById('search');
const loanRows = document.querySelectorAll('.loan-row');

function filterLoans() {
    const searchTerm = searchInput.value.trim().toLowerCase();
    const selectedStatus = statusFilter.value.toLowerCase();
    let hasVisibleRows = false;

    loanRows.forEach(row => {
        const user = row.dataset.user;
        const book = row.dataset.book;
        const loanDate = row.dataset.loanDate;
        const dueDate = row.dataset.dueDate;
        const status = row.dataset.status;

        const matchesSearch = user.includes(searchTerm) || 
                            book.includes(searchTerm) || 
                            loanDate.includes(searchTerm) || 
                            dueDate.includes(searchTerm) || 
                            status.includes(searchTerm);

        const matchesStatus = !selectedStatus || status === selectedStatus;

        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        if (matchesSearch && matchesStatus) hasVisibleRows = true;
    });

    // Handle no results
    const noResults = document.getElementById('noResults');
    if (!hasVisibleRows) {
        if (!noResults) {
            const tr = document.createElement('tr');
            tr.id = 'noResults';
            tr.innerHTML = `
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    No loans found matching your criteria
                </td>`;
            document.querySelector('tbody').appendChild(tr);
        }
    } else if (noResults) {
        noResults.remove();
    }
}

// Event listeners
statusFilter.addEventListener('change', filterLoans);
searchInput.addEventListener('input', filterLoans);

// Initial filter
filterLoans();
</script>
@endpush
@endsection