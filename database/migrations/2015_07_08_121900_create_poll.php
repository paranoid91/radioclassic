<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls',function(Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('title');
            $table->string('slug',100);
            $table->tinyInteger('answers')->unsigned();
            $table->enum('status',[0,1]);
            $table->char('lang',5);
            $table->timestamps();
            $table->timestamp('published_at');
        });

        Schema::create('poll_vote',function(Blueprint $table){
            $table->increments('id');
            $table->integer('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->integer('children_id')->unsigned();
            $table->integer('ip')->unsigned();
            $table->char('cookie',32);
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
        Schema::drop('polls');
        Schema::drop('poll_vote');
    }
}
