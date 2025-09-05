<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'member_id',
        'position',
        'manifesto',
        'votes_count'
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
