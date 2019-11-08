<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cell', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20 );
            $table->bigInteger('leader_id');
            $table->bigInteger('assistant_id');
            $table->smallInteger('membership_strength');
            $table->string('subject');
            $table->string('venue');
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
        Schema::dropIfExists('cell');
    }
}
