<?php

namespace App\Admin\Requests;

class RoleRequest extends AdminRequest
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
            'slug' => 'required|unique:admin_roles|max:20',
            'name' => 'required|unique:admin_roles|max:20'
        ];
    }
}
