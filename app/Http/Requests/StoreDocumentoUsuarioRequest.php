<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoUsuarioRequest extends FormRequest
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

        ];

        if ( $this->hasFile('requestform') ){
                $rules['requestform'] = ['max:2000','mimes:pdf'];
            }

        if ( $this->hasFile('academicdoc') ){
                $rules['academicdoc'] = ['max:2000','mimes:pdf'];
            }

        if ( $this->hasFile('motivedoc') ){
                $rules['motivedoc'] = ['max:2000','mimes:pdf'];
            }

        if ( $this->hasFile('ine') ){
                $rules['ine'] = ['max:2000','mimes:pdf'];
            }

        if ( $this->hasFile('cvu') ){
                $rules['cvu'] = ['max:2000','mimes:pdf'];
            }

        if ( $this->hasFile('foto') ){
                $rules['foto'] = ['max:2000','mimes:pdf'];
            }


        return $rules;
    }

    public function attributes(): array
    {
        return [
            'requestform' => 'Formato Solicitud',
            'academicdoc' => 'Carta Academica',
            'motivedoc' => 'CARTA Motivos',
            'ine' => 'INE',
            'cvu' => 'CVU',
            'foto' => 'Foto',
        ];
    }
}
