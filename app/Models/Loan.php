<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'book_id',
        'quantity',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function calculateFine()
    {
        if ($this->status !== 'overdue') return 0;
        
        $daysOverdue = now()->diffInDays($this->due_date);
        $dailyRate = match($this->book->category) {
            'reserve' => 50.00,
            default => 2.00
        };
        
        return $daysOverdue * $dailyRate;
    }
}
