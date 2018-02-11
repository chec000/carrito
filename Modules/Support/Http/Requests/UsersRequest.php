<?php

namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            case 'POST': {
                return [
                    "name" => "required",
                    "email" => "required",
                    "username" => "required",
                    "password" => "required",
                    "role_id" => "required",
                    "estatus" => "required"
                ];
            }
            case 'PUT': {
                return [
                    "name" => "required",
                    "email" => "required",
                    "username" => "required",
                    "password" => "confirmed",
                    "role_id" => "required",
                    "estatus" => "required"
                ];
            }
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
