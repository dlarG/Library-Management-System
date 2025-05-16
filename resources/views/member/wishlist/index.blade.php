@extends('layouts.member')

@section('title', 'My Wishlist')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-blue-100 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800">My Wishlist</h2>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($wishlist as $item)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gray-100 rounded-t-lg overflow-hidden">
                    @if($item->book->cover_image)
                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                             alt="{{ $item->book->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-medium text-gray-900">{{ $item->book->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $item->book->author->name }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <form action="{{ route('member.wishlist.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm hover:bg-red-200"
                                    onclick="return confirm('Remove from wishlist?')">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Your wishlist is empty</p>
                <a href="{{ route('member.books.index') }}" 
                   class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Browse Books
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection