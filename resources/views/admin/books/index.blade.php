@extends('layouts.admin')

@section('title', 'Books Management')

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
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Books Management</h1>
    <div class="relative group" x-data="{ open: false }" @mouseover="open = true" @mouseleave="open = false">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center transition-colors duration-200">
            Add New
            <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        
        <div class="absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-10 transition-all duration-300 origin-top"
            x-show="open"
            x-cloak
            style="display: none;"
            @mouseover="open = true"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            <!-- Dropdown arrow -->
            <div class="absolute -top-1.5 right-3 w-3 h-3 bg-white transform rotate-45 border-t border-l border-gray-100"></div>
            
            <div class="relative bg-white rounded-lg">
                <a href="{{ route('admin.books.create') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 first:rounded-t-lg last:rounded-b-lg">
                    Add Book
                </a>
                <a href="{{ route('admin.authors.create') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                    Add Author
                </a>
                <a href="{{ route('admin.publishers.create') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                    Add Publisher
                </a>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-800">All Books</h2>
            <div class="relative max-w-xs">
                <input type="text" id="search" placeholder="Search books..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($books as $book)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-12 w-9 object-cover rounded">
                        @else
                        <div class="h-12 w-9 bg-gray-200 rounded flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                        <div class="text-sm text-gray-500">{{ $book->isbn }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $book->author->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $book->publisher->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $book->publication_year }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->available > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $book->available }} / {{ $book->quantity }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.books.show', $book->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $books->onEachSide(1)->links() }}
    </div>
</div>
@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
</script>
@endpush
@endsection