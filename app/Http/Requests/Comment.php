<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Comment extends FormRequest
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
            //
            'name'=> 'required',
            'body'=> 'required|string',
            'id'=> 'required|integer',
            'type'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'commenttable_id.required' => 'A please comment on the right place (episodes,Groups) is required',
            'body.required' => 'A body is required',
            'commenttable_type.required' => 'A please comment on the right place (episodes,Groups) is required',
        ];
    }
}
