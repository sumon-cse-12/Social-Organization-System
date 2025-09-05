<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
        protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'budget',
        'collected_funds',
        'expenses',
        'organizer_id',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'collected_funds' => 'decimal:2',
        'expenses' => 'decimal:2',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function expenses()
    {
        return $this->hasMany(EventExpense::class);
    }

    public function funds()
    {
        return $this->hasMany(EventFund::class);
    }

    public function media()
    {
        return $this->hasMany(EventMedia::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
