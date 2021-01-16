<?php

namespace App\Admin\Requests;

use App\Admin\Requests\BackendRequest;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends BackendRequest
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
            'title' => 'required|unique:admin_menu|max:20',
            'icon' => 'required',
            'uri' => 'required|unique:admin_menu|max:20',
            'show' => 'int',
            'roles' => 'array',
        ];
    }
}
