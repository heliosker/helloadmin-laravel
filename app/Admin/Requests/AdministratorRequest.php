<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdministratorRequest extends BackendRequest
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
//            'username' => [
//                'required',
//                Rule::unique('admin_users')->ignore($this->administrator),
////                '|unique:admin_users,username,{$this->administrator}|max:30'
//            ],
            'username' => 'required|max:30|unique:admin_users,username,' . $this->administrator,
            'name' => 'required|max:30',
            'password' => 'required|min:6',
            'avatar' => ''
        ];
    }
}
