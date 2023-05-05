<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroRequest extends FormRequest
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

        $rules = [
            'id_rol' => 'required|max:255',
            'name' => 'required|max:255',
            'lastnamep' => 'required|max:255',
            'lastnamem' => 'required|max:255',
            'curp' => 'max:18|unique:users,curp',
            'email' => 'required|max:255|unique:users,email',
            'emailcon' => 'required|max:255|same:email',
            'phone' => 'required|numeric|digits_between:10,10',
            'institution_id' => '',
            'name_doc' => 'max:255',
            'thematic_id' => '',
            'subthematic_id' => '',
            'snilevel' => 'max:255',
            'maxgrade' => 'max:255',
            'invline' => 'max:255',
            'job' => 'max:255',
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|max:255|min:8|same:password',
        ];

        if ( $this->hasFile('constancy') ){
                $rules['constancy'] = ['max:2000','mimes:pdf'];
        }

        if ( $this->hasFile('requestform') ){
                $rules['requestform'] = ['max:2000','mimes:pdf'];
        }

        if ( $this->hasFile('photo') ){
            $rules['photo'] = ['max:2000','mimes:png, jpg, jpeg'];
        }


        return $rules;
    }

    public function attributes(): array
    {
        return [
            'id_rol' => 'Tipo de usuario',
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
            'photo' => 'Foto de perfil',
            'password' => 'Contraseña',
            'password_confirmation' => 'Contraseña de confirmación',
        ];
    }
}
