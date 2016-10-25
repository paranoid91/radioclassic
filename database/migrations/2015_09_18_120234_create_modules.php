<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules',function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->char('name',55);
            $table->char('controller',55);
            $table->char('trans',55);
            $table->char('icon',55);
            $table->enum('status',[0,1]);
            $table->integer('sort')->unsigned();
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
        Schema::drop('modules');
    }
}
