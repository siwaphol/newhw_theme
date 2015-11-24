<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;


class CourseRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

//    protected function formatErrors(Validator $validator)
//    {
//        dd($validator);
//        return $validator->errors()->getMessages();
//    }
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
            'course_id' => 'required|min:6|max:6',
            'course_name' => 'required'
        ];
	}

}
