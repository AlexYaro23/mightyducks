<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class StatRequest extends Request
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
            'game_id' => 'required|integer|exists:games,id',
            'player_id' => 'required|integer|exists:players,id',
            'parameter' => 'required|alpha_num',
            'value' => 'required|integer'
        ];
    }
}
