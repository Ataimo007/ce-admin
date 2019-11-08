<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CellMeeting extends Model
{
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
    //
    public function cell()
    {
        return $this->belongsTo( Cell::class, 'cell_id', 'id' );
    }

    public function scopeOfCell( $query, $id )
    {
        return $query->where( 'cell_id', $id );
    }
}
