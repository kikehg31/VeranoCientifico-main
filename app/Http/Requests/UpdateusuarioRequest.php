<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateusuarioRequest extends FormRequest
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
            'name' => 'max:255',
            'lastnamep' => 'max:255',
            'lastnamem' => 'max:255',
            'phone' => 'numeric',
            'institution_id' => '',
            'thematic_id' => '',
            'subthematic_id' => '',
            'snilevel' => 'max:255',
            'maxgrade' => 'max:255',
            'invline' => 'max:255',
            'job' => 'max:255', 
            'password' => 'max:255',
            'password_confirmation' => 'max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'rol' => 'Tipo de usuario',
            'name' => 'Nombre',
            'lastnamep' => 'Apellido paterno',
            'lastnamem' => 'Apellido materno',
            'curp' => 'CURP',
            'email' => 'Correo',
            'emailcon' => 'Correo de confirmación',
            'phone' => 'Teléfono',
            'institution_id' => 'Institución de procedencia',
            'requestform' => 'Formato de solicitud',
            'thematic_id' => 'Área de conocimiento',
            'subthematic' => 'Subárea de conocimiento',
            'snilevel' => 'Nivel SNI',
            'maxgrade' => 'Grado máximo de estudios',
            'invline' => 'Línea de investigación',
            'job' => 'Puesto',
            'constancy' => 'Constancia',
            'password' => 'Contraseña',
            'password_confirmation' => 'Contraseña de confirmación',
        ];
    }
}
