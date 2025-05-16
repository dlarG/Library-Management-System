<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'recentUsers' => User::latest()->take(5)->get(),
            'recentLoans' => Loan::with(['book', 'user'])
                ->latest()
                ->take(5)
                ->get(),
            'overdueLoans' => Loan::with(['book', 'user'])
                ->where('due_date', '<', now())
                ->where('status', '!=', 'returned')
                ->get(),
            'stats' => [
                'total_books' => Book::count(),
                'active_loans' => Loan::whereIn('status', ['borrowed', 'overdue'])->count(),
                'total_users' => User::count(),
                'overdue_books' => Loan::where('due_date', '<', now())
                    ->where('status', '!=', 'returned')
                    ->count()
            ]
        ]);
    }
}
