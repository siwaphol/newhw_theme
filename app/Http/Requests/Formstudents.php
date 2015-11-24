<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 22/6/2558
 * Time: 20:10
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class Formstudents extends FormRequest {
    public function rules()
    {
        return [
            'course_id' => 'required',
            'section'=>'required',
            'student_id'=>'required'

        ];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }
} 