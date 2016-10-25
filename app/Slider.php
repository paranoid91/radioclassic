<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title','sub_title','poster','link','is_publish'];

    /**
     * @var string
     */
    protected $table = 'slider';
}
