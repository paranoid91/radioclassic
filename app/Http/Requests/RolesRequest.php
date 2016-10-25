<?php namespace App\Http\Requests;

use App\Group;
use App\Http\Requests\Request;
use App\Role;

class RolesRequest extends Request {

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
                    'name' => 'required|max:100|unique:roles'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $id = Role::where('name',$this->name)->pluck('id');
                return [
                    'name' => 'required|max:100|unique:roles,name,'.$id.''
                ];
            }
            default:break;
        }

	}

}
