<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
    {
        // dd('Dashboard');
        return Inertia::render('Dashboard',[
            'title' => 'Admin Dashboard'
        ]);
    }

    public function create()
    {
       return Inertia::render('CreateTest',[
            'title' => 'Create Dashboard'
        ]);
    }
}
