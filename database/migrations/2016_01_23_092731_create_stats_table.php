<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('visit')->nullable()->default(null);
            $table->integer('goal')->nullable()->default(null);
            $table->integer('assist')->nullable()->default(null);
            $table->integer('yc')->nullable()->default(null);
            $table->integer('rc')->nullable()->default(null);
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
        Schema::drop('stats');
    }
}
