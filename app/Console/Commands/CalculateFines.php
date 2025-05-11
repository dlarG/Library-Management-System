<?php

namespace App\Console\Commands;

use App\Models\Fine;
use App\Models\Loan;
use Illuminate\Console\Command;

class CalculateFines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fines:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Loan::where('status', 'overdue')
        ->with('book')
        ->chunk(200, function ($loans) {
            foreach ($loans as $loan) {
                $daysOverdue = now()->diffInDays($loan->due_date);
                $dailyRate = match($loan->book->category) {
                    'reserve' => 50.00,
                    default => 2.00
                };
                
                Fine::updateOrCreate(
                    ['loan_id' => $loan->id],
                    [
                        'user_id' => $loan->user_id,
                        'days_overdue' => $daysOverdue,
                        'daily_rate' => $dailyRate,
                        'amount' => $daysOverdue * $dailyRate
                    ]
                );
            }
        });
    
        $this->info('Fines calculated successfully.');
    }
}
