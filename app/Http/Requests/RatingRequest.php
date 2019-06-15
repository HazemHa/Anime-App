<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'rating_id' => 'required|integer',
            'rating_type' => 'required|string',
            'count' => 'required|digits_between:1,5|integer',
        ];
    }
    public function messages()
    {
        return [
            'rating_id.required' => 'A please rating on the right place (episodes,Groups) is required',
            'count.required' => 'A rate value is required',
            'rating_type.required' => 'A please rating on the right place (episodes,Groups) is required',
        ];
    }
}
