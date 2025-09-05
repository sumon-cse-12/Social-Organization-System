<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentSetting extends Model
{
    use HasFactory;
    protected $fillable = ['gateway', 'mode', 'value', 'is_active'];

    protected $casts = [
        'value' => 'array',
        'is_active' => 'boolean',
    ];
}
