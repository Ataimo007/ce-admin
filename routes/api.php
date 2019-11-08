<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get( 'members/getAll', 'MemberController@getAll' );

Route::get( 'cell/getAll', 'CellController@getAll' );

Route::get( 'members/search', 'MemberController@searchName' );

Route::post( 'service/begin', 'ServiceController@begin' );

Route::post( 'service/attends', 'ServiceController@attends' );

Route::post( 'service/attend', 'ServiceController@attend' );

Route::post( 'cell_meeting/attends', 'CellMeetingController@attends' );

Route::post( 'member/register', 'MemberController@register' );

Route::post( 'member/update', 'MemberController@update' );

Route::post( 'cell/register', 'CellController@register' );

Route::post( 'service/close', 'ServiceController@close' );

Route::post( 'cell_meeting/close', 'CellMeetingController@close' );

Route::post( 'service/update_attendance', 'ServiceController@updateAttendance' );

Route::post( 'cell_meeting/update_attendance', 'CellMeetingController@updateAttendance' );

Route::get( 'service/getAll', 'ServiceController@getAll' );

Route::get( 'service/getAbsentees', 'ServiceController@absentees' );

Route::get( 'service/searchAbsentees', 'ServiceController@searchAbsents' );

Route::get( 'cell_meeting/getAbsentees', 'CellMeetingController@absentees' );

Route::get( 'service/getAttendees', 'ServiceController@attendees' );

Route::get( 'service/getRecentAttendees', 'ServiceController@recentAttendees' );

Route::get( 'cell_meeting/getRecentAttendees', 'CellMeetingController@recentAttendees' );

Route::post( 'cell_meeting/begin', 'CellMeetingController@begin' );

Route::post( 'members/update_cell', 'MemberController@updateCell' );

Route::post( 'member/update_cell', 'MemberController@updateCellMember' );

Route::get( 'members/no_cell', 'MemberController@noCell' );

Route::get( 'cell_meeting/get_by_week', 'CellMeetingController@getByWeek' );

Route::get( 'cell_meeting/get_all_week', 'CellMeetingController@getAllWeeks' );

Route::get( 'cell_meeting/get_attendees', 'CellMeetingController@attendees' );

Route::get( 'member/get/{member}', 'MemberController@get' );

Route::get( 'cell/get/{cell}', 'CellController@get' );

Route::get( 'cell/members/{cell}', 'CellController@getMembers' );

Route::get( 'cell_meeting/cell/{cell}', 'CellMeetingController@getMeetings' );

Route::get( 'cell_meeting/test', 'CellMeetingController@test' );

Route::get( 'members/search/name', 'MemberController@searchByName');

Route::get( 'members/search/exist', 'MemberController@memberExist');

Route::get( 'members/test', 'MemberController@test');