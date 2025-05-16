<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $books = auth()->user()->wishlist()
                    ->with(['author', 'publisher']) // Eager load relationships
                    ->paginate(10);

        return view('member.wishlist.index', compact('books'));
    }

    public function store(Request $request, Book $book)
    {
        try {
            // Check if already in wishlist
            if (auth()->user()->wishlist()->where('book_id', $book->id)->exists()) {
                return back()->with('error', 'Book is already in your wishlist');
            }

            // Add to wishlist
            auth()->user()->wishlist()->attach($book->id);

            return back()->with('success', 'Book added to wishlist successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add to wishlist: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        try {
            auth()->user()->wishlist()->detach($book->id);
            return back()->with('success', 'Book removed from wishlist');
        } catch (\Exception $e) {
            return back()->with('error', 'Error removing book: ' . $e->getMessage());
        }
    }
}