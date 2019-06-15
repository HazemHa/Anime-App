<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Notification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
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
            'receiver_id'=> 'required|integer',
            'body'=>'required|string',
        ];
    }

    public function messages()
    {
        return [
            'receiver_id.required' => 'select someone to send him notifications',
            'body.required' => 'A body is required',
        ];
    }
}
