<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency',function(Blueprint $table){
            $table->increments('id');
            $table->string('title',100);
            $table->char('name',55);
            $table->float('currency');
            $table->enum('arrow',[0,1]);
            $table->float('last');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('currency');
    }
}
