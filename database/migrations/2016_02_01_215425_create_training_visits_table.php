<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_visits', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('training_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->tinyInteger('visit')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('training_visits');
    }
}
