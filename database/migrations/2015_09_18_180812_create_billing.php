<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing',function(Blueprint $table){
             $table->increments('id');
             $table->string('short_desc',30);
             $table->string('long_desc',125);
             $table->string('url',255);
             $table->string('back_url_s',255);
             $table->string('back_url_f',255);
             $table->char('merchant_trx',55);
             $table->char('merchant_id',55);
             $table->char('account_id',55);
             $table->char('page_id',55);
             $table->integer('currency');
             $table->tinyInteger('exponent');
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
        Schema::drop('billing');
    }
}
