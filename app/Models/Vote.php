<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

     protected $fillable = [
        'election_id',
        'candidate_id',
        'voter_id',
        'voted_at'
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function voter()
    {
        return $this->belongsTo(Member::class, 'voter_id');
    }
}
