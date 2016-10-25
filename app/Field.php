<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Facades\Input;

class Field extends Model
{
    protected $fillable = ['cat_id','value','trans','tag','type'];

}
