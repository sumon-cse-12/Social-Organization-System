<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeetingController extends Controller
{
    public function index(Request $request){
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
        return Inertia::render('Member/Meetings/Index',[
            'meetings' => $meetings,
            'filters'   => $request->only('search'),
        ]);
    }

    public function joinMeeting($id){
        $meeting = Meeting::findOrFail($id);
        dd($meeting);
        return Inertia::render('Member/Meetings/Join');
    }

    public function join(Request $request){
        $meeting = Meeting::where('id',$request->meeting_id)->firstOrFail();
        $member = Member::where('id',auth()->user()->id)->firstOrFail();

$meeting->members()->updateExistingPivot($member->id, [
    'attendance' => 'present',
    'joined_at' => now(),
]);

    }
}
