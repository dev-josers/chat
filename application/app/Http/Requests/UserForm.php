<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use JWTAuth;

class UserForm extends FormRequest
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
        $user = JWTAuth::toUser();
        return [
            "name" => "required|between:5,60",
            "email" => "required|email|between:5,100|unique:users,email,".$user->id,
            "password" => "required|confirmed|between:6,15"
        ];    
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.between' => 'The :attribute must be between :min - :max.',
            'name.required' => 'The :attribute is required!',
            'email.between' => 'The :attribute must be between :min - :max.',
            'email.required' => 'The :attribute is required!',
            'password.between' => 'The :attribute must be between :min - :max.'
        ];
    }

    /**
     * Get the error custom response
     *
     * @return object
     */
    public function response(array $errors)
    {
        return response()->json(['message' => "Validation Failed" , 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
