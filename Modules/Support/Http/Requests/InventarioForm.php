<?php

namespace Modules\Support\Http\Requests;

//namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarioForm extends FormRequest
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
        return [
            "almacen" => "required"
        ];      
    }
    
    /**
     * Get the validation messagges that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
//            'name.required' => 'El nombre del producto es requerido', 
//            'product_code.required' => 'El nombre del producto es requerido', 
//            'imagen.required' => 'Seleccione la imagen del producto',
        ];
    }
}
