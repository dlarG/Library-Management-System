<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('librarian.reports.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:loans,fines,overdue',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $reportData = match($validated['type']) {
            'loans' => Loan::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
                        ->with(['user', 'book'])
                        ->get(),
            'fines' => Fine::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
                        ->with(['user', 'loan'])
                        ->get(),
            'overdue' => Loan::where('status', 'overdue')
                        ->whereBetween('due_date', [$validated['start_date'], $validated['end_date']])
                        ->with(['user', 'book'])
                        ->get()
        };

        return view('librarian.reports.show', compact('reportData', 'validated'));
    }
}