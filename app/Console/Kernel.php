<?php

namespace App\Console;

use App\Models\Loan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    
    protected $commands = [
        \App\Console\Commands\InitializeSettings::class,
    ];
    // In app/Console/Kernel.php
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Loan::where('status', 'borrowed')
                ->where('due_date', '<', now()->subDays(config('settings.grace_period')))
                ->update(['status' => 'overdue']);
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
