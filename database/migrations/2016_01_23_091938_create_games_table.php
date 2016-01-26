<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('team');
            $table->timestamp('date');
            $table->tinyInteger('score1')->nullable();
            $table->tinyInteger('score2')->nullable();
            $table->tinyInteger('home')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('place')->nullable();
            $table->string('round')->nullabe();
            $table->integer('tournament_id')->defautl(1);
            $table->integer('mls_id')->nullable();
            $table->string('mls_url')->nullable();
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
        Schema::drop('games');
    }
}
