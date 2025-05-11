<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->latest()->paginate(6);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.books.create', compact('authors', 'publishers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'nullable|unique:books|max:20',
            'title' => 'required|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set available equal to quantity
        $validated['available'] = $validated['quantity'];

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);
    
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => 'nullable|max:20|unique:books,isbn,' . $book->id,
            'title' => 'required|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('remove_cover') && $book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
            $validated['cover_image'] = null;
        }
    
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }
    
        $book->update($validated);
    
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }
}