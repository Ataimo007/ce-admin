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
            $table->bigInteger('church_id')->default(1);
            $table->string('name');
            $table->date('date');
            $table->string('type', 15 )->nullable();
            $table->integer('attendance')->default(1);
            $table->integer('offering')->default(0);
            $table->enum( "status", ["ONGOING", "CLOSED"] )->default("ONGOING");
            $table->string('description')->nullable();
            $table->time('start_time' );
            $table->time('end_time' )->nullable();
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
