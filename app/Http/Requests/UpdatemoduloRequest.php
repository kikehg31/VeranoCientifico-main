<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatemoduloRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'key' => 'required|max:255'
        ];
    }
    public function attributes(): array
    {
        return [
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'key' => 'Clave'
        ];
    }
}
