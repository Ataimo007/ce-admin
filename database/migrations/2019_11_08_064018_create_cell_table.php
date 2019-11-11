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
        Schema::create('cells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20 );
            $table->bigInteger('leader_id');
            $table->bigInteger('assistant_id')->nullable();
            $table->smallInteger('membership_strength')->default(1);
            $table->string('subject')->nullable();
            $table->string('venue')->nullable();
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
        Schema::dropIfExists('cells');
    }
}
