<?php

namespace App\Http\Controllers\Member;

use Inertia\Inertia;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('member.login');
        }

        return Inertia::render('Member/Profile/Show', [
            'member' => $member,
            'editUrl' => route('member.profile.edit'),
        ]);
    }


    public function edit()
    {
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('member.login');
        }

        return Inertia::render('Member/Profile/Edit', [
            'member' => $member,
        ]);
    }

    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('member.login');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            // Add other fields as necessary
        ]);

        $member->update($validatedData);

        return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
    }

    public function all_member(Request $request)
    {
        return Inertia::render('Member/Profile/AllMembers', [
            'filters' => $request->only('search', 'status'),
            'members' => Member::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%");
                    });
                })
                ->when($request->input('status'), function ($query, $status) {
                    $query->where('status', $status);
                })
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'status' => $member->status,
                    'created_at' => $member->created_at,
                ]),
        ]);
    }

    public function details($id)
    {
        $member = Member::findOrFail($id);
        return Inertia::render('Member/Profile/Details', [
            'member' => $member,
            'editUrl' => route('member.profile.edit'),
        ]);
    }

    public function notifications(Request $request)
    {
        $member = auth('member')->user();
        $notifications = $member->customNotifications()
            ->whereNull('read_at') // only unread
            ->orderBy('created_at', 'desc') // latest first
            ->get();

        return response()->json($notifications);
    }
}
