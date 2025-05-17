<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class CheckOverdueLoans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-loans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('loans:check-overdue')->daily();
    }
    public function handle()
    {
        $settings = \App\Models\Setting::first();
        $cutoffDate = now()->subDays($settings->grace_period);
        
        Loan::where('status', 'borrowed')
            ->where('due_date', '<', $cutoffDate)
            ->update(['status' => 'overdue']);
        
        $this->info('Updated overdue loans');
    }
}
