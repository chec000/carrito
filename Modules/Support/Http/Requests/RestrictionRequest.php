<?php


namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestrictionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id'=> 'required',
            'state_id'=> 'required',
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