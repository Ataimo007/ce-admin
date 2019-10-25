<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = "attendees";
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function scopeAttendees($query, $service_id)
    {
        return $query->where( 'service_id', $service_id );
    }

    public function member()
    {
        return $this->belongsTo( Member::class );
    }

    //
}
