<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('amount');
    }
    
    public function getBalanceAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
}
