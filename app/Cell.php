<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function leader()
    {
        return $this->belongsTo( Member::class, 'leader_id', 'id' );
    }

    public function assistant()
    {
        return $this->belongsTo( Member::class, 'assistant_id', 'id' );
    }
    
}
