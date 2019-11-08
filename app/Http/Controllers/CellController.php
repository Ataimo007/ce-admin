<?php

namespace App\Http\Controllers;

use App\Cell;
use App\Member;

class CellController extends Controller
{
    function getAll()
    {
        return Cell::with( 'leader', 'assistant' )->get();
    }

    function get( Cell $cell )
    {
    	$cell->load( 'leader' );
    	$cell->load( 'assistant' );
    	$cell->membership_strength = Member::ofCell( $cell->id )->get()->count();
    	return $cell;
    }

    function getMembers( Cell $cell )
    {
    	return Member::ofCell( $cell->id )->get();;
    }

    function register()
    {
        $request = json_decode( request()->getContent(), true );
        unset( $request[ 'membership_strength' ] );
        $cell = Cell::create($request);
        
        if ($cell->leader_id != 0) {
            Member::updateCell( $cell->leader_id, $cell->id );    
        }
        if ($cell->assistant_id != 0) {
            Member::updateCell( $cell->assistant_id, $cell->id );    
        }
        
        return $cell;
    }
}