<header class="bg-white shadow-sm z-10">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Mobile menu button -->
        <button id="openSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Search Bar -->
        <div class="flex-1 max-w-md mx-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search members, books...">
            </div>
        </div>

        <!-- Notifications & User Menu -->
        <div class="flex items-center space-x-4" x-data="{ open: false }">
            <button class="p-1 rounded-full text-gray-500 hover:text-gray-600 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>
            
            <!-- User Dropdown -->
            <div class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none" style="cursor: pointer;">
                    <div class="h-8 w-8 rounded-full border-2 border-indigo-100 overflow-hidden">
                        @if (Auth::user()->user_cover)
                            <img src="{{ asset('storage/' . Auth::user()->user_cover) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="hidden md:inline-block font-medium">{{ Auth::user()->name }}</span>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50" style="cursor: pointer;">
                    <a href="{{--{{ route('librarian.profile.edit') }}--}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button style="cursor: pointer;" type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>