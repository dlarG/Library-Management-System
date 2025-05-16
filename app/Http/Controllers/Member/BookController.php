<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher'])
            ->where('available', '>', 0)
            ->firstWhere(request(['search', 'author', 'category']))
            ->paginate(12);

        return view('member.books.index', compact('books'));
    }

    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);
        
        $inWishlist = auth()->user()->wishlist()
                        ->where('book_id', $book->id)
                        ->exists();

        // Add this to check if user has active loan for this book
        $hasActiveLoan = auth()->user()->loans()
                            ->where('book_id', $book->id)
                            ->whereIn('status', ['pending', 'approved'])
                            ->exists();

        return view('member.books.show', compact('book', 'inWishlist', 'hasActiveLoan'));
    }
}
