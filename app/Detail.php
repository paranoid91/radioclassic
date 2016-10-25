<?php
/**
 * Created by PhpStorm.
 * User: vatichild
 * Date: 10/30/15
 * Time: 4:01 PM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Detail extends Model
{
    protected $table = 'details';

    function users(){
        $this->hasOne('App\User');
    }
}