<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('cat_id')->unsigned();
            $table->text('value');
            $table->char('trans',55);
            $table->enum('tag',['input','select','textarea']);
            $table->enum('type',['text','checkbox','radio','number','color','range','option']);
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
        //
    }
}
