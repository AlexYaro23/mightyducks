<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class PlayerRequest extends Request
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
            'user_id' => 'integer|exists:users,id',
            'mls_id' => 'integer',
            'team_id' => 'required|integer|exists:teams,id',
            'name' => 'required|string',
            'date_of_birth' => '',
            'position' => 'required|integer',
        ];
    }
}
