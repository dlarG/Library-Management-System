<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->loadCount(['loans as active_loans_count' => function($query) {
            $query->whereIn('status', ['borrowed', 'overdue']);
        }]);

        return view('member.dashboard', [
            'currentLoans' => $user->loans()
                ->with(['book.author', 'book.publisher'])
                ->whereIn('status', ['borrowed', 'overdue'])
                ->get()
        ]);
    }
}
