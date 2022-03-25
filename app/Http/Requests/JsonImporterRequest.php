<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JsonImporterRequest extends FormRequest
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
			'json_file' => [
				function($attribute, $value, $fail) {
					$extension = $value->getClientOriginalExtension();
					if($extension !== 'json') {
						$fail('Invalid type of file.');
					}
				}
			]
        ];
    }
}
