<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProyectosRequest extends FormRequest
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
            'title' => 'required',
            'studentnum' => 'required',
            'thematic_id'=> 'required',
            'subthematic_id'=> 'required',
            'generalobject'=> 'required',
            'modality'=> 'required',
            'requirements'=> 'required',
            'keywords' => 'required',
            'institution_id' => 'required',
            'user_id' => 'required',
            
        ];
    }
    public function attributes(): array
    {
        return [
            'title' => 'Titulo del proyecto',
            'studentnum' => 'Numero de alumnos',
            'thematic_id'=> "Tematica",
            'subthematic_id'=> "Subtematica",
            'generalobject'=> "Objetivo General",
            'modality'=> "Modalidad",
            'requirements'=> "Requisitos del proyecto",
            'keywords' => "Palabras clave"
        ];
    }
}
