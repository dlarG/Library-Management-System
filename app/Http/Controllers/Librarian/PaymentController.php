<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request, Fine $fine)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Create payment
        try {
            DB::transaction(function () use ($request, $fine) {
                $payment = Payment::create([
                    'fine_id' => $fine->id,
                    'amount' => $request->amount,
                    'method' => $request->method,
                    'notes' => $request->notes
                ]);
                if ($fine->fresh()->balance <= 0) {
                    $fine->update(['status' => 'paid']);
                    
                    // Update the associated loan
                    $loan = $fine->loan;
                    if (in_array($loan->status, ['borrowed', 'overdue'])) {
                        $loan->update([
                            'status' => 'returned',
                            'return_date' => now()
                        ]);
                        
                        // Restore book quantity
                        $loan->book->increment('available', $loan->quantity);
                    }
                }
            });

        }
        catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
        return back()->with('success', 'Payment recorded successfully');
        

        // // Update fine status
        // $totalPaid = $fine->payments->sum('amount') + $request->amount;
        // if ($totalPaid >= $fine->amount) {
        //     $fine->update(['status' => 'paid']);
        // }

        // return back()->with('success', 'Payment recorded successfully');
    }
}