<div class="sidebar fixed md:relative z-50 w-64 bg-white shadow-lg flex flex-col" id="sidebar">
    <!-- Logo -->
    <div class="p-4 border-b border-blue-100 flex items-center space-x-2">
        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="text-xl font-bold text-blue-900">My Library</span>
    </div>
    <div class="p-4 border-b border-blue-100 flex items-center space-x-3">
        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
            <span class="text-blue-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
        </div>
        <div>
            <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
            <p class="text-xs text-blue-600">Library Member</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ route('member.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('member.dashboard') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{--{{ route('member.loans') }}--}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('member.loans') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
            <span>My Loans</span>
        </a>

        <a href="{{--{{ route('member.books') }}--}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('member.books') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Browse Books</span>
        </a>

        <a href="{{--{{ route('member.wishlist') }}--}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('member.wishlist') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span>Wishlist</span>
        </a>

        <a href="{{--{{ route('member.profile') }}--}}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs('member.profile') ? 'active-nav' : '' }}">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-blue-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 w-full" style="cursor: pointer;">
                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>