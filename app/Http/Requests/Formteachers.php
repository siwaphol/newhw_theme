<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 22/6/2558
 * Time: 14:06
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class Formteachers extends FormRequest {
    public function rules()
    {
        return [
            //'username' => 'required',
            'firstname_en' => 'required',
            'lastname_en' => 'required',
           'email' => 'required'
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