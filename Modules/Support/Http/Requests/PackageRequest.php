<?php

namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "image_package" => ($this->id? '' : 'required|')."image|mimes:jpeg,jpg,png|max:3072",
            "name" => "required",
            "language_id" => "required",
            "price" => "required|numeric|min:1",
            "points" => "required|numeric",
            "estatus" => "required",
            "products" => "required",
            "video_url" => "nullable|url",
            "description" => "required"
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
