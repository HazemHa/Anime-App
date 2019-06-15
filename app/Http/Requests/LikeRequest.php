<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
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
            'likestable_id' => 'required|integer',
            'likestable_type' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'likestable_id.required' => 'A please put like on the right place (episodes,Groups) is required',
            'likestable_type.required' => 'A please put like on the right place (episodes,Groups) is required',
        ];
    }
}
