<?php

namespace App\Admin\Requests;


class PermissionRequest extends AdminRequest
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
            'parent_id' => 'int',
            'slug' => 'required|unique:admin_permissions|max:20',
            'name' => 'required',
            'http_method' => 'array',
            'http_path' => 'array',
        ];
    }
}
