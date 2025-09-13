<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::query()
            // Search by name or email
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // Filter by status
            ->when($request->input('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn($member) => [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
                'status' => $member->status,
                'membership_date' => $member->created_at->format('Y-m-d'), // match front-end
            ]);

        return Inertia::render('Admin/MemberList', [
            'members' => $members,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
}
