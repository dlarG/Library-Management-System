<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date', now()->subMonth()->format('Y-m-d')),
            'end_date' => $request->input('end_date', now()->format('Y-m-d')),
        ];

        $reportData = [
            'loanStats' => $this->getLoanStatistics($filters),
            'popularBooks' => $this->getPopularBooks($filters),
            'userActivity' => $this->getUserActivity($filters),
            'filters' => $filters
        ];

        return view('admin.reports.index', $reportData);
    }

    public function print(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date', now()->subMonth()->format('Y-m-d')),
            'end_date' => $request->input('end_date', now()->format('Y-m-d')),
        ];

        $data = [
            'loanStats' => $this->getLoanStatistics($filters),
            'popularBooks' => $this->getPopularBooks($filters),
            'userActivity' => $this->getUserActivity($filters),
            'filters' => $filters,
            'printDate' => now()->format('F j, Y')
        ];

        $pdf = FacadePdf::loadView('admin.reports.printable', $data);
        return $pdf->download('library-report-'.now()->format('Y-m-d').'.pdf');
    }

    private function getLoanStatistics($filters)
    {
        $loans = Loan::whereBetween('loan_date', [$filters['start_date'], $filters['end_date']]);
        
        return [
            'total_loans' => $loans->count(),
            'overdue' => Loan::where('status', 'overdue')->count(),
            'avg_loan_duration' => Loan::whereNotNull('return_date')
                ->avg(DB::raw('DATEDIFF(return_date, loan_date)')),
            'total_fines' => DB::table('fines')->sum('amount'),
            'late_returns' => Loan::whereNotNull('return_date')
                ->whereColumn('return_date', '>', 'due_date')
                ->count(),
            'peak_period' => $this->getPeakPeriod($filters)
        ];
    }

    private function getPeakPeriod($filters)
    {
        $peak = Loan::select(DB::raw('WEEK(loan_date) as week, COUNT(*) as count'))
            ->whereBetween('loan_date', [$filters['start_date'], $filters['end_date']])
            ->groupBy('week')
            ->orderByDesc('count')
            ->first();

        return $peak ? "Week {$peak->week} ({$peak->count} loans)" : 'N/A';
    }

    private function getPopularBooks($filters)
    {
        return Book::withCount(['loans' => function($query) use ($filters) {
                $query->whereBetween('loan_date', [$filters['start_date'], $filters['end_date']]);
            }])
            ->orderByDesc('loans_count')
            ->limit(5)
            ->get();
    }
    private function getUserActivity($filters)
    {
        return User::whereHas('loans', function($query) use ($filters) {
                $query->whereBetween('loan_date', [$filters['start_date'], [$filters['end_date']]]);
            })
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(5)
            ->get();
    }

    private function getFinancialStats($filters)
    {
        return [
            'total_fines' => Fine::whereBetween('created_at', [$filters['start_date'], $filters['end_date']])
                ->sum('amount'),
            'paid_fines' => Payment::whereBetween('created_at', [$filters['start_date'], $filters['end_date']])
                ->sum('amount'),
            'outstanding_fines' => Fine::where('status', 'pending')
                ->sum(DB::raw('amount - (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.fine_id = fines.id)'))
        ];
    }
    
}
