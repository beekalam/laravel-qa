<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votables', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('votable_id');
            $table->string('votable_type');
            $table->tinyInteger('vote')->comment('-1:vote down, 1: vote up');
            $table->timestamps();

            $table->unique(['user_id','votable_id','votable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votables');
    }
}
