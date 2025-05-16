@extends('layouts.member')

@section('title', 'My Wishlist')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-blue-100 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">My Wishlist</h2>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
    <div class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
        <div class="p-4">
            <!-- Book Cover -->
            <div class="h-48 bg-gray-100 rounded-lg overflow-hidden">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Book Details -->
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <a href="{{ route('member.books.show', $book) }}" class="hover:text-blue-600">
                        {{ $book->title }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $book->author->name }}
                </p>
            </div>

            <!-- Actions -->
            <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('member.books.show', $book) }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    View Details
                </a>
                
                <form action="{{ route('member.wishlist.destroy', $book) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-600 hover:text-red-800 text-sm"
                            onclick="return confirm('Are you sure you want to remove this from your wishlist?')">
                        Remove
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
        </div>
    </div>
</div>
@endsection