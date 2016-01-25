<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'provider_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'email',
            'screen_name' => 'alpha_num',
            'status' => 'required|integer',
            'roleList' => 'required|array'
        ];
    }
}
