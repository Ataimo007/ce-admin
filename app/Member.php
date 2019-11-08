<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public static function absentees( $service_id )
    {
//        $present = Attendance::with( 'member' )->attendees( request( 'service_id' ) )->get();
        $present = Attendance::with( 'member' )->attendees( $service_id )->get();
        $members = $present->map( function( $item, $key) {
            return $item->member;
        });

        $absentees = static::all()->filter( function( $value, $key ) use($members) {
            return !$members->contains( 'id', $value->id );
        });

        return $absentees->values()->all();
    }

    public static function cellAbsentees( $cell_id, $cell_meeting_id )
    {
        // $present = Attendance::attendees( request( 'id' ) )->get();
        $present = CellAttendee::with( 'member' )->attendees( $cell_meeting_id )->get();
        $members = $present->map( function( $item, $key) {
            return $item->member;
        });

        $absentees = static::where( 'cell_id', $cell_id )->get()->filter( function( $value, $key ) use($members) {
            return !$members->contains( 'id', $value->id );
        });

        return $absentees->values()->all();
    }

    public static function updateCell($id, $cell_id = null )
    {
        $member = static::find( $id );
        $member->cell_id = $cell_id;
        $member->save();
        return $member;
    }

    public function scopeNoCell( $query )
    {
        return $query->where( 'cell_id', null );
    }

    public function cell()
    {
        return $this->belongsTo( Cell::class );
    }

    public function scopeOfCell( $query, $id )
    {
        return $query->where( 'cell_id', $id );
    }
    
}
