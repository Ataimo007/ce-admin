<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Member;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
//    function begin()
//    {
//        $service = Service::create(request([ 'name', 'date', 'type' ] ) );
//        $service->attendance = 0;
//        $service->start_time = now();
//        $service->status = 'ONGOING';
//        $service->save();
//    }

    function begin()
    {
        return Service::create(json_decode( request()->getContent(), true ));
    }

    function test()
    {
        return request([]);
    }

    function attends()
    {
        $i = 0;
        $attendees = json_decode( request()->getContent(), true );
        foreach ( $attendees as $attendee )
        {
            $attended = Attendance::create( $attendee );
            if ( $attended != null )
                ++$i;
        }
        return $i;
    }

    function attend()
    {
        $attendees = json_decode( request()->getContent(), true );
        $attended = [];
        foreach ( $attendees as $attendee )
        {
            if ( Attendance::where( 'member_id', $attendee[ 'member_id' ] )
                    ->where( 'service_id', $attendee[ 'service_id' ] )->get()->count() != 0 ) {
                continue;
            }

            $attend = Attendance::create( $attendee );
            
            if ( $attend != null )
            {
                $service = Service::find( $attendee[ 'service_id' ] );
                ++$service->attendance;
                $service->save();
                
                $attend->load('member');
                array_push( $attended, $attend );
            }
        }
        return $attended;
    }

    function close()
    {
        $request = json_decode( request()->getContent(), true );
        $service = Service::find( $request[ 'id' ] );
        $service->attendance = $request[ 'attendance' ];
        $service->offering = $request[ 'offering' ];
        $service->status = 'CLOSED';
        $service->end_time = $request[ 'end_time' ];
        $service->description = $request[ 'description' ];
        $service->save();
        return $service;
    }

    function updateAttendance()
    {
        $request = json_decode( request()->getContent(), true );
        $service = Service::find( $request[ 'id' ] );
        $service->attendance = $request[ 'attendance' ];
        $service->save();
        return $service;
    }

    // function attend()
    // {
    //     $service = Service::find( request( 'id' ) );
    //     $service->attendance = request( 'attendance' );
    //     $members = request( 'members' );
    //     $attendance = new AttendanceController();
    //     $attendance->attends( $members );
    //     $service->save();
    // }

    function getAll()
    {
        return Service::query()->orderBy( 'date', 'desc' )->get();
    }

    function attendees()
    {
        return Attendance::with( 'member' )->attendees( request( 'service_id' ) )->get();
    }

    function absentees()
    {
        return Member::absentees( request( 'service_id' ) );
    }

    function recentAttendees()
    {
        $size = Attendance::attendees( request( 'service_id' ) )->count();
        $offset = $size - request( 'recent' );
        return Attendance::with('member' )->attendees( request( 'service_id' ) )
            ->offset( $offset )->limit( request( 'recent' ) )->get();
    }

    function searchAbsents()
    {
        $present = Attendance::with( 'member' )->attendees( request( 'service_id' ) )->get();
        $members = $present->map( function( $item, $key) {
            return $item->member;
        });

        $controller = new MemberController();
        $controller->searchByName()->filter( function( $value, $key ) use($members) {
            return !$members->contains( 'id', $value->id );
        });

        return $absentees->values()->all();
    }

    
}
