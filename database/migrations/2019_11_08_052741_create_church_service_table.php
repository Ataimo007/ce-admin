<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChurchServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('church_id');
            $table->string('name');
            $table->date('date');
            $table->string('type', 15 );
            $table->integer('attendance');
            $table->integer('offering');
            $table->enum( "status", ["ONGOING", "CLOSED"] );
            $table->string('description');
            $table->time('start_time' );
            $table->time('end_time' );
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
        Schema::dropIfExists('services');
    }
}
