<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id','item_id','transaction_id','amount','status','currency','updated_at'];
}
