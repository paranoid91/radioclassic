<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Vote extends Model
{
    protected $fillable = ['poll','vote_id','ip','cookie'];

    protected $table = 'votes';

    public function polls(){
        return $this->belongsToMany('App\Poll');
    }


}
