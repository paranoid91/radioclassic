<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BillingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'short_desc'=>'required|max:30',
            'long_desc'=>'max:125',
            'merchant_trx'=>'required|max:55',
            'merchant_id'=>'required|max:55',
            'account_id'=>'required|max:55',
            'page_id'=>'required|max:55',
            'currency'=>'required|max:9',
            'exponent'=>'required|max:9',
            'url'=>'required',
            'back_url_s'=>'required',
            'back_url_f'=>'required'
        ];
    }
}
