<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 22/6/2558
 * Time: 15:53
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class Formtas extends FormRequest{
    public function rules()
    {
        return [
            'id' => 'required',
            'taName' => 'required'
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