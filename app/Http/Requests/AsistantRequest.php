<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use DB;
use App\Http\Requests\Input;


class AsistantRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $assistant=DB::select('select * from course_ta where course_id=? and section=? and student_id=?',array(Input::get('courseId'),Input::get('sectionId'),Input::get('taId')));
//        $count=count($assistant);
//        if($count>0){
//            return false;
//        }
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
            'courseId'=>'required',
            'sectionId'=>'required',
            'taId'=>'required|min:9|max:9'
        ];
    }

}
