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
        $wishlist = auth()->user()->wishlist()
            ->with(['book.author'])
            ->paginate(10);

        return view('member.wishlist.index', compact('wishlist'));
    }

    public function store(Request $request, Book $book)
    {
        try {
            auth()->user()->wishlist()->firstOrCreate(['book_id' => $book->id]);
            return back()->with('success', 'Book added to wishlist');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add to wishlist: ' . $e->getMessage());
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        $this->authorize('delete', $wishlist);
        
        try {
            $wishlist->delete();
            return back()->with('success', 'Book removed from wishlist');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove from wishlist: ' . $e->getMessage());
        }
    }
}