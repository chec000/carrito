<?php


namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoolsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "eo_number" => "required",
            "eo_name" => "required",
            "eo_email" => "required|email",


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