<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Settings\LibrarySettings;

class InitializeSettings extends Command
{
    protected $signature = 'settings:init';
    protected $description = 'Initialize library settings with default values';

    public function handle()
    {
        $settings = new LibrarySettings();
        
        // Set default values
        $settings->library_name = 'LibraLynx';
        $settings->library_email = 'admin@libralynx.com';
        $settings->library_phone = '';
        $settings->library_address = '123 Library Street';
        $settings->fine_rate_filipiniana = 2.00;
        $settings->fine_rate_general = 2.00;
        $settings->fine_rate_reserve = 50.00;
        $settings->default_loan_period = 14;
        $settings->max_renewals = 2;
        $settings->opening_time = '08:00';
        $settings->closing_time = '17:00';
        $settings->enable_email_notifications = true;

        $settings->save();

        $this->info('Settings initialized successfully!');
    }
}