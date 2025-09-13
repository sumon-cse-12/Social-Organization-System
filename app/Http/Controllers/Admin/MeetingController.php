<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
  public function index(Request $request)
{
    $meetings = Meeting::query()
        ->when($request->input('search'), function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString()
        ->through(fn($meeting) => [
            'id'        => $meeting->id,
            'title'     => $meeting->title,
            'type'     => $meeting->type,
            'date_time' => Carbon::parse($meeting->date_time)->format('d M, Y h:i A'),
            'agenda'    => $meeting->agenda,
        ]);

    return Inertia::render('Admin/Meetings/Index', [
        'meetings' => $meetings,
        'filters'   => $request->only('search'),
    ]);
}


    public function create(){
        return Inertia::render('Admin/Meetings/Create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'agenda'       => 'required|string|max:1000',
            'date_time'    => 'required|date|after:now',
            'type'         => 'required|in:online,offline',
            'location'     => 'nullable|required_if:type,offline|string|max:255',
            'meeting_link' => 'nullable|required_if:type,online|url|max:255',
            'minutes'      => 'nullable|string|max:2000',
            'decisions'    => 'nullable|string|max:2000',
        ]);
      $validated['created_by'] = Auth::id();
        // Save to database
        $meeting = Meeting::create($validated);

        // Redirect back with success flash
        return redirect()->route('admin.meeting.index')
                         ->with('success', 'Meeting created successfully.');
    }
}
