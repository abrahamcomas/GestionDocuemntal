<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuncionarioModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Registro extends Controller
{
   public function index(Request $request){
    $rules = [
        'Rut' => 'required', 
        'Nombres' => 'required', 
        'Apellidos' => 'required', 
        'Contrasenia' => 'required|min:6',
        'Confirmar_Contrasenia' => 'required:Contrasenia|same:Contrasenia|min:6|different:password',
        'Email' => 'required',
        'Telefono' => 'required',
    ];

    $messages = [
        'Rut.required' =>'El campo Rut es obligatorio.',
        'Nombres.required' =>'El campo Nombres es obligatorio.',
        'Apellidos.required' =>'El campo Apellidos es obligatorio.',
        'Contrasenia.required' =>'El campo Contraseña es obligatorio.',
        'Confirmar_Contrasenia.required' =>'El campo Confirmar Contraseña es obligatorio.',
        'Email.required' =>'El campo Email es obligatorio.',
        'Telefono.required' =>'El campo teléfono es obligatorio.'
    ];

    $this->validate($request, $rules, $messages);  

    $Rut = $request->input('Rut');
    $Nombres = $request->input('Nombres');
    $Apellidos = $request->input('Apellidos');
    $Contrasenia = $request->input('Contrasenia');
    $Confirmar_Contrasenia = $request->input('Confirmar_Contrasenia');
    $Email = $request->input('Email');
    $Telefono = $request->input('Telefono');
    $Activo = 0;

    $Funcionario=FuncionarioModels::select('Rut','Nombres')->whereRut($Rut)->first();

        if((isset($Funcionario->Rut)) AND (!isset($Funcionario->Nombres))) 
        {
            $ExisteEmail=DB::table('Funcionarios')->whereEmail($Email)->exists();
            if ($ExisteEmail==0) 
            {
                $id=FuncionarioModels::Select('ID_Funcionario_T','Activo')->whereRut($Rut)->first();

                if ($id->Activo==1) { 
                    $user = FuncionarioModels::find($id->ID_Funcionario_T);
                    $user->Nombres = $Nombres;
                    $user->Apellidos = $Apellidos;
                    $user->Email = $Email;
                    $user->Telefono = $Telefono;
                    $user->password = Hash::make($Contrasenia);
                    $user->save();

                    $resultado='Registro Realizado Correctamente.';
                }
                else
                {
                    $resultado='Error, Usuario con cuenta desactiva, registro denegado.';
                }
            }
            else
            {
                $resultado='Error, Email registrado anteriormenete, registro denegado.';
            }
        }
        elseif((isset($Funcionario->Rut)) AND (isset($Funcionario->Nombres)))
        {
            $resultado='Error, Usuario registrado anteriormente.';
        }
        else
        {
            $resultado='Error, Usuario sin autorización, registro denegado.';
        }

        return view('Registro/RespuestaRegstro')->with('resultado', $resultado);

    }
}
