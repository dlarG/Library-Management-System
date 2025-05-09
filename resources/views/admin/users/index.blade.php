@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
@if(session('success'))
<div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
    {{ session('success') }}
</div>
@endif
<div class="mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all registered users and their permissions</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            New User
        </a>
    </div>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Filters and Search -->
    <div class="bg-white/70  p-6 border border-gray-200 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-6">
        <!-- Search -->
        <div class="w-full md:w-1/2">
            <div class="relative">
              <input type="text" id="searchInput" placeholder=" Search by name, email or ID..."
                class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm placeholder-gray-400 bg-white">
              <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
        
          <!-- Filters -->
          <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <!-- Role Filter -->
            <div class="w-full sm:w-44">
              <select id="roleFilter"
                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option value="">🎭 All Roles</option>
                <option value="admin">🛡️ Admin</option>
                <option value="librarian">📚 Librarian</option>
                <option value="member">👤 Member</option>
              </select>
            </div>
        
            <!-- Status Filter -->
            <div class="w-full sm:w-44">
              <select id="statusFilter"
                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option value="">🔄 All Statuses</option>
                <option value="Verified">✅ Verified</option>
                <option value="Unverified">❌ Unverified</option>
              </select>
            </div>
          </div>
      </div>
    

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="user-row hover:bg-gray-50 transition-colors duration-150" 
                    data-name="{{ strtolower($user->name) }}"
                    data-username="{{ strtolower($user->username) }}"
                    data-email="{{ strtolower($user->email) }}"
                    data-status="{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}"
                    data-role="{{ $user->roleType }}">
                    <!-- User Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($user->user_cover)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->user_cover) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500"><span>@</span>{{ $user->username }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Email Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                    </td>
                    
                    <!-- Status Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->email_verified_at)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Verified
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @endif
                    </td>
                    
                    <!-- Role Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->roleType === 'Admin') bg-purple-100 text-purple-800
                            @elseif($user->roleType === 'Librarian') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $user->roleType }}
                        </span>
                    </td>
                    
                    <!-- Actions Column -->
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')" style="cursor: pointer;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
            </a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $users->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $users->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $users->total() }}</span>
                    results
                </p>
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const userRows = document.querySelectorAll('.user-row');
    
    // Function to filter users
    function filterUsers() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const roleValue = roleFilter.value;
        const statusValue = statusFilter.value;
        
        let hasVisibleRows = false;
        
        userRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const username = row.getAttribute('data-username');
            const email = row.getAttribute('data-email');
            const status = row.getAttribute('data-status');
            const role = row.getAttribute('data-role');
            
            // Check if row matches search term and filters
            const matchesSearch = searchTerm === '' || 
                name.includes(searchTerm) || 
                username.includes(searchTerm) || 
                email.includes(searchTerm);
            
            const matchesRole = roleValue === '' || role === roleValue;
            const matchesStatus = statusValue === '' || status === statusValue;
            
            // Show/hide row based on filters
            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
                hasVisibleRows = true;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show message if no results found
        const noResultsMessage = document.getElementById('noResultsMessage');
        if (!hasVisibleRows) {
            if (!noResultsMessage) {
                const tr = document.createElement('tr');
                tr.id = 'noResultsMessage';
                tr.className = 'text-center py-4';
                tr.innerHTML = `
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        No users found matching your criteria
                    </td>
                `;
                document.getElementById('usersTableBody').appendChild(tr);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
    
    // Event listeners for filtering
    searchInput.addEventListener('input', filterUsers);
    roleFilter.addEventListener('change', filterUsers);
    statusFilter.addEventListener('change', filterUsers);
    
    // Initialize filters
    filterUsers();
});
</script>
@endpush
@endsection