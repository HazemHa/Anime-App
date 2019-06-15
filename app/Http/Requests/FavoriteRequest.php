<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
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
            'favoritetable_id'=> 'required|integer',
            'favoritetable_type'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'favoritetable_id.required' => 'A please put favorite on the right place (episodes,Groups) is required',
            'favoritetable_type.required' => 'A please favorite on the right place (episodes,Groups) is required',
        ];
    }
}
