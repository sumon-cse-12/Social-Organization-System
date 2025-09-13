<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Member extends Authenticatable
{
    use HasFactory, Notifiable;
     protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'emergency_contact',
        'membership_fee',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'membership_date' => 'date',
        'approved_at' => 'datetime',
        'membership_fee' => 'decimal:2',
    ];

    public function monthlyFees()
    {
        return $this->hasMany(MonthlyFee::class);
    }
    public function customNotifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function meetings()
    {
        return $this->belongsToMany(
            Meeting::class,
            'meeting_member',   // pivot table
            'member_id',        // current model key in pivot
            'meeting_id'        // related model key in pivot
        )->withPivot('attendance')
         ->withTimestamps();
    }
}
