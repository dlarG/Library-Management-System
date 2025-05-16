<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Setting;
use Illuminate\Http\Request;

class FineControllerr extends Controller
{
    public function store(Request $request, Loan $loan)
    {
        try {
            // Verify loan is overdue
            if ($loan->status === 'returned') {
                return back()->with('error', 'Cannot fine a returned loan');
            }
    
            $settings = Setting::firstOrFail();
            $overdueDays = now()->diffInDays($loan->due_date);
    
            // Validate overdue days
            if ($overdueDays <= 0) {
                return back()->with('error', 'Loan is not yet overdue');
            }
    
            $fine = Fine::updateOrCreate(
                ['loan_id' => $loan->id],
                [
                    'user_id' => $loan->user_id,
                    'amount' => $settings->daily_fine_rate * $overdueDays,
                    'status' => 'pending',
                    'overdue_days' => $overdueDays,
                ]
            );
    
            // Update loan status to overdue if not already
            if ($loan->status !== 'overdue') {
                $loan->update(['status' => 'overdue']);
            }
    
            return back()->with('success', "₱{$fine->amount} fine added for {$overdueDays} days overdue");
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
