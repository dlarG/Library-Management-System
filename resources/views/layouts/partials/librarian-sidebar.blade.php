<!-- Sidebar -->
<div class="sidebar fixed md:relative z-50 w-64 bg-white shadow-lg flex flex-col" id="sidebar">
    <!-- Logo -->
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg class="h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
            </svg>
            <span class="ml-2 text-xl font-bold text-gray-900">LibraLynx</span>
        </div>
        <button id="closeSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- User Profile -->
    <div class="p-4 border-b border-gray-200 flex items-center space-x-3">
        @if(Auth::user()->user_cover)
            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-indigo-100">
                <img src="{{ asset('storage/' . Auth::user()->user_cover) }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="h-full w-full object-cover">
            </div>
        @else
            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-indigo-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
        @endif
        <div>
            <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500">Librarian</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ route('librarian.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('librarian.dashboard') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('librarian.loans.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('librarian.loans.*') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
            </svg>
            <span>Loan Management</span>
        </a>

        <a href="{{ route('librarian.returns.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('librarian.returns.*') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Returns & Fines</span>
        </a>

        <a href="{{ route('librarian.members.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('librarian.members.*') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8 4 4 0 010-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
            </svg>
            <span>Member Management</span>
        </a>

        <a href="{{ route('librarian.reports.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('librarian.reports.*') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Reports</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 w-full">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>