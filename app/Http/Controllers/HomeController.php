<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::with('author')
            ->where('available', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::sum('available'),
            'active_loans' => Loan::whereIn('status', ['borrowed', 'overdue'])->count(),
            'registered_users' => User::count()
        ];

        return view('welcome', compact('featuredBooks', 'stats'));
    }
}