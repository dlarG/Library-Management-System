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
            // Get grace period from settings (ensure you have a Settings model)
            $gracePeriod = \App\Models\Setting::first()->grace_period ?? 0;
            
            Loan::where('status', 'borrowed')
                ->whereDate('due_date', '<', now()->subDays($gracePeriod))
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
