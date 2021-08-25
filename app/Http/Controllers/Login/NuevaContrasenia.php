<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\FuncionarioModels;
class NuevaContrasenia extends Controller
{
    public function index(Request $request){
    	$rules = [ 
            'Contrasenia' => 'required|min:6', 
            'Confirmar_Contrasenia' => 'required:Contrasenia|same:Contrasenia|min:6|different:password', 
        ]; 

        $messages = [  
            'Contrasenia.required' =>'El campo contraseña es obligatorio.',
            'Confirmar_Contrasenia.required' =>'El campo Confirmar contraseña es obligatorio.'
        ];  
 
        $this->validate($request, $rules, $messages); 

        $Id_Funcionario = $request->input('Id_Funcionario');
        $Contrasenia = $request->input('Contrasenia');

        $user = FuncionarioModels::find($Id_Funcionario);
        $user->CorreoActivo = 1;
        $user->password = Hash::make($Contrasenia);
        $user->save();

        $resultado='Contraseña restaurada correctamente';

        return view('Registro/RespuestaRegstro')->with('resultado', $resultado);


    }
}
