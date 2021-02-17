<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListPostRequest extends FormRequest
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
            'order'=>'required|numeric|unique:list_posts',
            'name'=>'required',
            'post_place'=>'required',
        ];
    }

	public function messages()
	{
		return [
			'order.required'    => 'order - ушбу қатор тўлдирилиши шарт!',
			'name.required'    => 'name - ушбу қатор тўлдирилиши шарт!',
			'post_place.required'     => 'post_place - ушбу қатор тўлдирилиши шарт!',
			'order.unique'     => 'order - ушбу қаторда киритилган маьлумот мавжуд!',
			'order.numeric'     => 'order - ушбу қаторда фақат рақамли маьлумот мавжуд!',

		];
	}
}
