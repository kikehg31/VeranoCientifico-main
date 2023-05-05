<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoremoduloRequest extends FormRequest
{
    protected string $tableName = 'c_modulo';
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
            'key'         => "required|string|max:255|min:1|unique:{$this->tableName},key" . (isset($this->route('modulo')->id) ? ',' . $this->route('modulo')->id : ''),
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
