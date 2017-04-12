<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use JWTAuth;

class ChatForm extends FormRequest
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
        switch($this->method()) {            
            case 'POST': {
                return [
                    "name" => "required|between:1,60",
                    "message" => "required|between:1,100",
                ];    
            }            
            case 'PATCH': {
                return [
                    "name" => "required|between:1,60",
                ];    
            }
            default:break;
        }        
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
            'message.between' => 'The :attribute must be between :min - :max.',
            'message.required' => 'The :attribute is required!',
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
