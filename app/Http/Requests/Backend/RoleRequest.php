<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class RoleRequest extends Request
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
        switch ($this->method()) {
            case 'POST': {
                return [
                    'name' => 'required|min:1|max:50|alpha_num|unique:roles',
                    'description' => 'required|min:1|max:255'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name' => 'required|min:1|max:50|alpha_num|unique:roles,name,' . $this->segment(3),
                    'description' => 'required|min:1|max:255'
                ];
            }
        }
    }
}
