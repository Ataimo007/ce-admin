<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CellAttendee extends Model
{
//    protected $table = "attendees";
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function scopeAttendees($query, $cell_id)
    {
        return $query->where( 'cell_meeting_id', $cell_id );
    }

    public function member()
    {
        return $this->belongsTo( Member::class );
    }
}
