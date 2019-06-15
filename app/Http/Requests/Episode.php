<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Episode extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check() && \Auth::user()->role_id !=2;
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
            'group_id'=> 'required|integer',
            'number'=>'required|integer',
            'description'=>'required|string',
            'image'=> 'nullable',
            
        ];
    }
}
