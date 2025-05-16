@extends('layouts.member')

@section('title', $book->title)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto">
        <div class="h-64 bg-gray-100 overflow-hidden">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     alt="{{ $book->title }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                    <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            @endif
        </div>
        
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
            <div class="mt-4 space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Author: {{ $book->author->name }}</p>
                    <p class="text-sm text-gray-600">Published: {{ $book->publication_year }}</p>
                    <p class="text-sm text-gray-600">ISBN: {{ $book->isbn ?? 'N/A' }}</p>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-medium text-gray-900">Description</h3>
                    <p class="mt-2 text-gray-600 text-sm">{{ $book->description ?? 'No description available' }}</p>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm text-gray-600">
                                Available copies: {{ $book->available }}
                            </span>
                        </div>
                        <form action="{{--{{ route('member.wishlist.store', $book) }}--}}" method="POST">
                            @csrf
                            @if($inWishlist)
                                <button type="button" 
                                        class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed"
                                        disabled>
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                    In Wishlist
                                </button>
                            @else
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Add to Wishlist
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($book->publisher || $book->category)
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Additional Details</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            @if($book->publisher)
            <div>
                <p class="text-gray-600">Publisher:</p>
                <p class="text-gray-900">{{ $book->publisher->name }}</p>
                @if($book->publisher->address)
                <p class="text-gray-500 mt-1">{{ $book->publisher->address }}</p>
                @endif
            </div>
            @endif
            
            @if($book->category)
            <div>
                <p class="text-gray-600">Category:</p>
                <p class="text-gray-900">{{ $book->category->name }}</p>
                @if($book->category->description)
                <p class="text-gray-500 mt-1">{{ $book->category->description }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection