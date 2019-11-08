<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    function getAll()
    {
        return Member::orderBy('first_name')->orderBy('surname')->orderBy('other_names')->get();
    }

    function get( Member $member )
    {
        $member->load( 'cell' );
        return $member;
    }

    function searchName()
    {
        $builder = Member::query();

        if ( request()->has( 'query' ) )
            $builder->where( function ($query) {
                $query->where( 'first_name', 'like', '%' . request( 'query' ) . '%' )
                    ->orWhere( 'last_name', 'like', '%' . request( 'query' ) . '%' );
            } );

        if ( request()->has( 'offset' ) )
        {
            $builder->offset( request( 'offset' ) );
            if ( request()->has( 'count' ) )
                $builder->take( request( 'count' ) );
            else
                $builder->take( 50 );

        }

        if ( request()->has( 'order' ) )
            $builder->orderBy( request( 'order' ), 'asc' );
        else
            $builder->orderBy( 'first_name', 'asc' );

        return $builder->get();
    }

    function register()
    {
        $member = json_decode( request()->getContent(), true );
        $exist = $this->memberExistOnArray( $member );
        
        if (!$exist['existence'])
        {
            $newMember = Member::create($member);
            $exist['member'] = $newMember;
            return $exist;
        }
        else
        {
            $exist['member'] = $member;
            return $exist;
        }
    }

    function update()
    {
        $member = json_decode( request()->getContent(), true );
        $updated = Member::find($member['id'])->update( $member );

        $success = $updated != 0;
        $message = "Your Details Has Been Updated";
        $result = $member;
        return compact( 'success', 'message', 'result' );
    }

    function noCell()
    {
        return Member::noCell()->get();
    }

    function updateCell()
    {
        $i = 0;
        $members = json_decode( request()->getContent(), true );
        foreach ( $members as $member )
        {
            Member::updateCell( $member[ 'id' ], $member[ 'cell_id' ] );
            ++$i;
        }
        return $i;
    }

    function updateCellMember()
    {
        $member = json_decode( request()->getContent(), true );
        Member::updateCell( $member[ 'id' ], $member[ 'cell_id' ] );
    }

    function searchByName()
    {
        $builder = Member::query();
        $names = explode(" ", request("name"));

        foreach ($names as $name) {
            strtolower($name);
            $build = $builder->where( function ( $query ) use( $name )
            {
                $query->whereRaw( 'trim( first_name ) like ?', [ $name ] )
                ->orWhereRaw( 'trim( surname ) like ?', [ $name ] )
                ->orWhereRaw( 'trim( other_names ) like ?', [ $name ] );
            } );

            $count = $build->get()->count();

            if ( $count > 0 ) {
                $builder = $build;
            }
        }
        
        return $builder->get();
    }

    function memberExist()
    {
        $param = [ 'first_name' => request('first_name'), 'surname' => request('surname'), 
            'other_names' => request('other_names'), 'phone_number' => request('phone_number') ];
        return $this->memberExistOnArray( $param );
    }

    function memberExistOnArray( $request )
    {
        $builder = Member::query();
        if ( isset( $request['phone_number'] ) )
            $builder->whereRaw('trim( phone_number ) like ?', $request['phone_number'] );
        
        $builder->orWhere( function ($query) use( $builder, $request ) {
            if ( isset( $request['first_name'] ) )
                $query->whereRaw('trim( first_name ) like ?', $request['first_name'] );
            else
                $query->where('first_name', null );
            
            if ( isset( $request['surname'] ) )
                $query->whereRaw('trim( surname ) like ?', $request['surname'] );
            else
                $query->where('surname', null );
            
            if ( isset( $request['other_names'] ) )
                $query->whereRaw('trim( other_names ) like ?', $request['other_names'] );
            else
                $query->where('other_names', null );
        });

        $members = $builder->get();
        $existence = $members->count() != 0;

        $first_name = isset( $request['first_name'] ) ? Member::whereRaw( 'trim( first_name ) like ?', $request["first_name"] )->get()->count() != 0 : false;
        $surname = isset( $request['surname'] ) ? Member::whereRaw( 'trim( surname ) like ?', $request["surname"] )->get()->count() != 0 : false;
        $other_names = isset( $request['other_names'] ) ? Member::whereRaw( 'trim( other_names ) like ?', $request["other_names"] )->get()->count() != 0 : false;
        $phone_number = isset( $request['phone_number'] ) ? Member::whereRaw( 'trim( phone_number ) like ?', $request["phone_number"] )->get()->count() != 0 : false;

        $result = compact('existence', 'first_name', 'surname', 'other_names', 'phone_number');
        return $result;
    }


    function memberExistGson( $request )
    {
        $members = Member::whereRaw( 'trim( first_name ) like ?', $request["phone_number"] )->
            orWhere( function ($query) use ($request) {
            $query->whereRaw( 'trim( first_name ) like ?', $request["first_name"] )
                ->WhereRaw( 'trim( surname ) like ?', $request["surname"] )
                ->WhereRaw( 'trim( other_names ) like ?', $request["other_names"] );
        })->get();

        $existence = $members->count() != 0;
        $first_name = Member::whereRaw( 'trim( first_name ) like ?', $request["first_name"] )->get()->count() != 0;
        $surname = Member::whereRaw( 'trim( surname ) like ?', $request["surname"] )->get()->count() != 0;
        $other_names = Member::whereRaw( 'trim( other_names ) like ?', $request["other_names"] )->get()->count() != 0;
        $phone_number = Member::whereRaw( 'trim( phone_number ) like ?', $request["phone_number"] )->get()->count() != 0;
        $result = compact('existence', 'first_name', 'surname', 'other_names', 'phone_number');
        return $result;
    }

    function test()
    {
        return Member::where( 'phone_number', null )->get();
    }
}
