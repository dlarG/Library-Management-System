<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\RemindDueDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrarianLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $loans = Loan::with(['user', 'book'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->orderBy('due_date', 'asc')
            ->paginate(6);
        return view('librarian.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('roleType', 'member')->get();
        $books = Book::where('available', '>', 0)->get();
        return view('librarian.loans.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'due_date' => 'required|date|after:today'
        ]);
    
        try {
            $settings = Setting::firstOrFail();
            $book = Book::findOrFail($request->book_id);
            
            if($book->available < $request->quantity) {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Not enough available copies. Available: ' . $book->available]);
            }
    
            $currentLoans = Loan::where('user_id', $request->user_id)
                ->whereIn('status', ['borrowed', 'overdue'])
                ->sum('quantity');
    
            if (($currentLoans + $request->quantity) > $settings->max_books_per_user) {
                return back()->withInput()->withErrors([
                    'user_id' => "User cannot borrow more than {$settings->max_books_per_user} books total. Current loans: {$currentLoans}"
                ]);
            }
            DB::transaction(function () use ($request, $book) {
                $loan = Loan::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'quantity' => $request->quantity,
                    'loan_date' => now(),
                    'due_date' => $request->due_date,
                    'status' => 'borrowed'
                ]);

                $book->available -= $request->quantity;
                $book->save();
            });

            return redirect()->route('librarian.loans.index')
                ->with('success', 'Loan created successfully. ' . $request->quantity . ' copies of "' . $book->title . '" loaned.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create loan. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return view('librarian.loans.show', [
            'loan' => $loan->load(['fines.payments']),
            'fine' => $loan->fines()->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        if ($loan->status === 'borrowed') {
            DB::transaction(function () use ($loan) {
                $loan->update([
                    'return_date' => now(),
                    'status' => 'returned'
                ]);

                // Check for overdue
                if ($loan->return_date->gt($loan->due_date)) {
                    $settings = Setting::first();
                    $daysOverdue = $loan->return_date->diffInDays($loan->due_date);
                    $fineAmount = $daysOverdue * $settings->daily_fine_rate;

                    if (!$loan->fines()->exists()) {
                        Fine::create([
                            'loan_id' => $loan->id,
                            'amount' => $fineAmount,
                            'days_overdue' => $daysOverdue,
                            'status' => 'pending'
                        ]);
                    }
                }

                $loan->book->increment('available', $loan->quantity);
            });
        }

        return back()->with('success', 'Loan marked as returned');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
    public function sendReminder(Loan $loan)
    {
        try {
            $user = $loan->user;
            $settings = Setting::first();
            $overdueDays = now()->diffInDays($loan->due_date);
            
            // Send email notification
            $user->notify(new RemindDueDate($loan, $overdueDays, $settings));
            
            return back()->with('success', "Reminder sent to {$user->email}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to send reminder: ' . $e->getMessage()]);
        }
    }
}
