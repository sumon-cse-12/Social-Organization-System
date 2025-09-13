<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Transaction extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'member_id',
    //     'type',
    //     'amount',
    //     'description',
    //     'reference',
    //     'status'
    // ];
    protected $guarded = ['id'];


    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
