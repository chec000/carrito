<?php


namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required',
            'nutritional_table'=> 'required',
            'sku'=> 'required',
            'price'=> 'required',
            'points'=> 'required',
            'description'=> 'required',
            'short_description'=> 'required',
            'consupsion_tips'=> 'required',
            'video_url'=> 'max:255',
            'language_id'=> 'required',
            'is_kit'=> 'required',
            'estatus'=> 'required'
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