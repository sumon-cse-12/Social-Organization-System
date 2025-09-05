<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyFee extends Model
{
    use HasFactory;

     protected $fillable = [
        'member_id',
        'amount',
        'for_month',
        'paid_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'for_month' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
