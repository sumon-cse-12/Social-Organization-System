<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

      protected $fillable = [
        'user_id',
        'member_id',
        'title',
        'message',
        'type',
        'read_at',
        'related_type',
        'related_id'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function related()
    {
        return $this->morphTo();
    }
}
