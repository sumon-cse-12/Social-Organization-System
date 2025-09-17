<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'message',
        'type',
        'is_read',
    ];

     public function sender()
    {
        return $this->morphTo(null, 'sender_type', 'sender_id');
    }

    /**
     * Get the receiver (Admin or Member)
     */
    public function receiver()
    {
        return $this->morphTo(null, 'receiver_type', 'receiver_id');
    }
}
