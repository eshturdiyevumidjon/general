<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListPostEditRequest extends FormRequest
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
			'name_edit'=>'required',
			'post_place_edit'=>'required',
		];
	}

	public function messages()
	{
		return [
			'name_edit.required'    => 'name - ушбу қатор тўлдирилиши шарт!',
			'post_place_edit.required'     => 'post_place - ушбу қатор тўлдирилиши шарт!',

		];
	}
}
