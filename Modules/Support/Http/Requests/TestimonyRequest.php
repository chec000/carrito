<?php

namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "photo" => ($this->id? '' : 'required|')."image|mimes:jpeg,jpg,png|max:3072",
            "name" => "required|max:45",
            "language_id" => "required",
            "estatus" => "required",
            "testimony"=> "required",
            "product_id" => "required",
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
