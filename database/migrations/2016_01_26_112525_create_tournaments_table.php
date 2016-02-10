<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('link')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('team_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tournaments');
    }
}
