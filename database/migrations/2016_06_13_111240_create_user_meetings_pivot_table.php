<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMeetingsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meetings', function (Blueprint $table) {
            $table->integer('meeting_id')->unsigned()->index();
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_meetings');
    }
}
