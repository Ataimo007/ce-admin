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
            $table->bigInteger('church_id')->default(1);
            $table->string('email_address', 50 )->nullable()->unique();
            $table->string('first_name', 20 );
            $table->string('surname', 20 );
            $table->string('other_names', 20 );
            $table->enum('gender', ["MALE", "FEMALE"] );
            $table->enum('rank', [ "First Timer", "Visitor", "Member", "Leader", "Senior Leader", "Cell Executive", "Cell Leader", "Coordinator", "Pastor", "Sub Group Pastor",
            "Group Pastor", "Zonal Pastor", "Deacon" ] )->default("First Timer");
            $table->unsignedInteger('cell_id')->default( null )->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('kings_chat_no', 15)->nullable();
            $table->string('date_of_birth', 12)->nullable();
            $table->string('home_address', 50)->nullable();
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
