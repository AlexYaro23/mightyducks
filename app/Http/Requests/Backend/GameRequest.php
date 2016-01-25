<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class GameRequest extends Request
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
            'team' => 'required|string',
            'date' => 'required|date',
            'score1' => 'integer',
            'score2' => 'integer',
            'home' => 'integer',
            'status' => 'integer',
            'place' => 'string'
        ];
    }
}
