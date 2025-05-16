<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
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
}
