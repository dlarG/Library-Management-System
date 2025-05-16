<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Setting;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()->loans()
            ->with(['book.author', 'book.publisher'])
            ->latest()
            ->paginate(10);

        return view('member.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {   
        $this->authorize('view', $loan);
        
        $loan->load(['fines.payments', 'book.author']);
        
        return view('member.loans.show', [
            'loan' => $loan,
            'settings' => Setting::first()
        ]);
    }
    public function store(Request $request, Book $book)
    {
        // Validate the request
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after:loan_date',
        ]);

        // Check book availability
        if ($book->available <= 0) {
            return back()->with('error', 'This book is currently not available');
        }

        // Check if user already has an active loan for this book
        $existingLoan = auth()->user()->loans()
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingLoan) {
            return back()->with('error', 'You already have an active loan for this book');
        }

        // Create the loan
        Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => $validated['loan_date'],
            'return_date' => $validated['return_date'],
            'status' => 'pending'
        ]);

        return redirect()->route('member.loans.index')
            ->with('success', 'Book loan request submitted successfully');
    }
}
