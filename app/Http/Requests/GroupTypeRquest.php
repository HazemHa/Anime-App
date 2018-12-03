<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupTypeRquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check() && \Auth::user()->role_id == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'=> 'required|string',
            'description'=> 'required|string',
        ];
    }
}
