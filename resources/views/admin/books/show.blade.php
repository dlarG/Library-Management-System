@extends('layouts.admin')

@section('title', 'View Book')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Book Details</h1>
    <div>
        <a href="{{ route('admin.books.edit', $book->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 mr-2">Edit</a>
        <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Back</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/3 lg:w-1/4">
                @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-md">
                @else
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                @endif
            </div>
            
            <div class="w-full md:w-2/3 lg:w-3/4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $book->title }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">ISBN</h3>
                        <p class="text-gray-800">{{ $book->isbn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Author</h3>
                        <p class="text-gray-800">{{ $book->author->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Publisher</h3>
                        <p class="text-gray-800">{{ $book->publisher->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Category</h3>
                        <p class="text-gray-800">{{ $book->category->name ?? 'No Category' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Publication Year</h3>
                        <p class="text-gray-800">{{ $book->publication_year ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Availability</h3>
                        <p class="text-gray-800">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->available > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->available }} available out of {{ $book->quantity }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="text-gray-800 whitespace-pre-line">{{ $book->description ?? 'No description available.' }}</p>
                </div>
                
                <div class="text-sm text-gray-500">
                    <p>Created: {{ $book->created_at->format('M d, Y H:i') }}</p>
                    <p>Last Updated: {{ $book->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection