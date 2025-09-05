<?php

namespace App\Models;

use App\Enums\Payment\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRequest extends Model
{
    use HasFactory;

      protected $fillable = [
        'member_id',
        'gateway',
        'amount',
        'currency',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    protected $casts = [
        'status' => PaymentStatus::class,
    ];




}
