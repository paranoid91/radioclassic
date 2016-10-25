<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Articles extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->text('head');
            $table->text('body');
            $table->string('slug');
            $table->string('meta_key',100);
            $table->string('meta_desc',100);
            $table->string('img');
            $table->char('author',55);
            $table->enum('status',array(0,1,2,3,4));
            $table->text('extra_fields');
            $table->char('lang',5);
            $table->timestamps();
            $table->timestamp('published_at');
            $table->timestamp('finished_at');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }

}
