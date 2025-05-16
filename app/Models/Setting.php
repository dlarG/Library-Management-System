<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'daily_fine_rate',
        'loan_period',
        'max_books_per_user',
        'grace_period',
        'renewal_limit',
        'reminder_days_before_due',
        'enable_email_notifications'
    ];
}