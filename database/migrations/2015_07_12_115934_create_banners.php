<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners',function(Blueprint $table){
             $table->increments('id');
             $table->string('title');
             $table->string('url');
             $table->string('banner');
             $table->char('size_x',5);
             $table->char('size_y',5);
             $table->char('lang',5);
             $table->timestamps();
             $table->timestamp('published_at');
             $table->timestamp('finished_at');
        });

        Schema::create('banner_cat', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('banner_id')->unsigned()->index();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
            $table->integer('cat_id')->unsigned()->index();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::drop('banners');
        Schema::drop('banner_cat');
    }
}
