<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'agenda',
        'date_time',
        'type',
        'location',
        'meeting_link',
        'minutes',
        'decisions',
        'created_by'
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees()
    {
        return $this->belongsToMany(Member::class)->withPivot('attendance');
    }
}
