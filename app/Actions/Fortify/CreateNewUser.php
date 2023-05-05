<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\tematica;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    protected string $source;
    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */

    public function __construct()
    {
        $this->source = "Auth/";
    }

    public function create(array $input)
    {   
        

       Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidop' => ['required', 'string', 'max:255'],
            'apellidom' => ['required', 'string', 'max:255'],
            'curp' => ['required', 'string', 'max:18', 'min:18'],
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'correocon' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['required', 'string', 'max:255'],
            /*'institucionproced' => [ 'string', 'max:255'],
            'formatosolicitud' => ['string', 'max:255'],
            'areaconoc' => ['string', 'max:255'],
            'subareaconoc' => ['string', 'max:255'],
            'nivelsni' => ['string', 'max:255'],
            'gradomax' => [ 'string', 'max:255'],
            'lineainv' => ['string', 'max:255'],
            'puesto' => [ 'string', 'max:255'],
            'constancia' => [ 'string', 'max:255'],*/
            'password_confirmation' => ['required', 'min:8'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'tipouser' => $input['tipouser'],
            'nombre' => $input['nombre'],
            'apellidop' => $input['apellidop'],
            'apellidom' => $input['apellidom'],
            'curp' => $input['curp'],
            'correo' => $input['correo'],
            'correocon' => $input['correocon'],
            'telefono' => $input['telefono'],
            'institucionproced' => $input['institucionproced'],
            'formatosolicitud' => $input['formatosolicitud'],
            'areaconoc' => $input['areaconoc'],
            'subareaconoc' => $input['subareaconoc'],
            'nivelsni' => $input['nivelsni'],
            'gradomax' => $input['gradomax'],
            'lineainv' => $input['lineainv'],
            'puesto' => $input['puesto'],
            'constancia' => $input['constancia'],
            'password' => Hash::make($input['password']),
            
        ]);

        /*return Inertia::render("{$this->source}Register", [
            'tematica'=> tematica::orderBy('name')->get(),
        ]);*/
    }
}
