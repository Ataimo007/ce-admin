<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cell_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('church_id');
            $table->bigInteger('cell_id');
            $table->unsignedTinyInteger('week');
            $table->unsignedSmallInteger('year');
            $table->date('date');
            $table->integer('attendance');
            $table->integer('offering');
            $table->string('description');
            $table->enum( "status", ["ONGOING", "CLOSED"] );
            $table->time( "start_time" );
            $table->time( "end_time" );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cell_meeting');
    }
}
