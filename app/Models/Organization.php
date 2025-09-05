<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

        protected $fillable = [
        'mission',
        'vision',
        'slogan',
        'short_term_plans',
        'long_term_plans',
        'logo'
    ];
}
