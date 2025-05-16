<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['fine_id', 'amount', 'method'];

    public function fine()
    {
        return $this->belongsTo(Fine::class);
    }
}
