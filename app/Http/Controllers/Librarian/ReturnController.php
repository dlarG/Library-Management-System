<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Fine;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book', 'fines.payments'])
            ->whereIn('status', ['borrowed', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        $settings = Setting::first();
        
        return view('librarian.returns.index', compact('loans', 'settings'));
    }

    public function applyFine(Loan $loan)
    {
        // Check if fine already exists
        if ($loan->status !== 'overdue' || $loan->fines()->exists()) {
            return back()->with('error', 'Fine cannot be applied to this loan');
        }

        $settings = Setting::first();
        $daysOverdue = now()->diffInDays($loan->due_date);
        $fineAmount = $daysOverdue * $settings->daily_fine_rate;

        $fine = Fine::create([
            'user_id' => $loan->user_id,
            'loan_id' => $loan->id,
            'amount' => $fineAmount,
            'days_overdue' => $daysOverdue,
            'status' => 'pending'
        ]);

        return back()->with('success', "Fine of ₱{$fineAmount} applied successfully");
    }
}