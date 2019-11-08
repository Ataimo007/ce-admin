<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('email_address', 50 )->unique();
            $table->string('first_name', 20 );
            $table->string('surname', 20 );
            $table->string('other_names', 20 );
            $table->enum('gender', ["MALE", "FEMALE"] );
            $table->enum('rank', [ "First Timer", "Visitor", "Member", "Leader", "Senior Leader", "Cell Executive", "Cell Leader", "Coordinator", "Pastor", "Sub Group Pastor",
            "Group Pastor", "Zonal Pastor", "Deacon" ] );
            $table->unsignedInteger('cell_id')->default( 0 );
            $table->string('phone_number', 15);
            $table->string('kings_chat_no', 15);
            $table->string('date_of_birth', 12);
            $table->string('home_address', 50);
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
        Schema::dropIfExists('members');
    }
}
