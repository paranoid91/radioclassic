<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billing';
    protected $fillable = ['short_desc','long_desc','url','back_url_s','back_url_f','merchant_trx','merchant_id','account_id','page_id','currency','exponent','update_at'];
}
