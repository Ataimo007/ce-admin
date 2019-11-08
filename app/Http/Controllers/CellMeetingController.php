<?php

namespace App\Http\Controllers;

use App\CellAttendee;
use App\CellMeeting;
use App\Member;
use App\Cell;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CellMeetingController extends Controller
{
    const MINISTRY_YEAR_END = "1st November Last Year";

    function begin()
    {
        $meeting = CellMeeting::create(json_decode( request()->getContent(), true ));
        $meeting->date = Carbon::now()->toDateString();
        $meeting->start_time = Carbon::now()->toTimeString();
        $meeting->year = Carbon::now()->year;
        $meeting->week = Carbon::now()->diffInWeeks( self::MINISTRY_YEAR_END );
        $meeting->offering = 0;
        $meeting->attendance = 0;
        $meeting->status = 'ONGOING';
        $meeting->description = "";
        $meeting->save();
        return $meeting;
    }

    function test()
    {
        return new Carbon( 'apr 25,' );
    }

    function getAllWeeks()
    {
        return CellMeeting::selectRaw( 'week, count(*) meetings_held' )->groupBy( 'week' )->get();
    }

    function getByWeek()
    {
        return CellMeeting::with('cell')->where( 'week', request( 'week' ) )->get();
    }

    function attends()
    {
        $i = 0;
        $attendees = json_decode( request()->getContent(), true );
        foreach ( $attendees as $attendee )
        {
            $attended = CellAttendee::create( $attendee );
            if ( $attended != null )
                ++$i;
        }
        return $i;
    }

    function close()
    {
        $request = json_decode( request()->getContent(), true );
        $cell_meeting = CellMeeting::find( $request[ 'id' ] );
        $cell_meeting->attendance = $request[ 'attendance' ];
        $cell_meeting->offering = $request[ 'offering' ];
        $cell_meeting->status = 'CLOSED';
        $cell_meeting->end_time = $request[ 'end_time' ];
        $cell_meeting->description = $request[ 'description' ];
        $cell_meeting->save();
        return $cell_meeting;
    }

    function updateAttendance()
    {
        $request = json_decode( request()->getContent(), true );
        $cell_meeting = CellMeeting::find( $request[ 'id' ] );
        $cell_meeting->attendance = $request[ 'attendance' ];
        $cell_meeting->save();
        return $cell_meeting;
    }

    function getAll()
    {
        return CellMeeting::query()->orderBy( 'date', 'desc' )->get();
    }

    function attendees()
    {
        return CellAttendee::with( 'member' )->attendees( request( 'cell_meeting_id' ) )->get();
    }

    function absentees()
    {
        return Member::cellAbsentees( request( 'cell_id' ), request( 'cell_meeting_id' ) );
    }

    function recentAttendees()
    {
        $size = CellAttendee::attendees( request( 'cell_meeting_id' ) )->count();
        $offset = $size - request( 'recent' );
        return CellAttendee::with('member' )->attendees( request( 'cell_meeting_id' ) )
            ->offset( $offset )->limit( request( 'recent' ) )->get();
    }

    function getMeetings( Cell $cell )
    {
        return CellMeeting::with('cell')->ofCell( $cell->id )->get();
    }
}
