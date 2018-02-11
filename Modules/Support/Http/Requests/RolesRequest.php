<?php

namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            "alias" => "required|unique:roles,alias".( $this->id? ','.$this->id : '' ),
            "name" => "required|unique:roles,name".( $this->id? ','.$this->id : '' ),
            "estatus" => "required",
            "description" => "required",
            "language_id" => "required",
            "permissions" => "required"
        ];
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
