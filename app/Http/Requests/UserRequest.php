<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;


class UserRequest extends Request {

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $id = User::where('email',$this->email)->where('name',$this->name)->pluck('id');
                if($id > 0){
                    return [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                    ];
                }else{
                    return [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users',
                    ];
                }
            }
            default:break;
        }
    }


}
