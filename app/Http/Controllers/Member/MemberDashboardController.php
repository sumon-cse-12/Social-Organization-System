<?php

namespace App\Http\Controllers\Member;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Member/Dashboard');
    }
}
