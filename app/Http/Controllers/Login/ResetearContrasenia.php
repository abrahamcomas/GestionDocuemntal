<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\RecuperarPasword;   
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\FuncionarioModels;

class ResetearContrasenia extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'Email' => 'required',  
        ]; 
 
        $messages = [ 
            'Email.required' =>'El campo Email es obligatorio.',
        ]; 

        $this->validate($request, $rules, $messages);

        $Email = $request->input('Email');

		$DatosFuncionario=DB::table('Funcionarios')->where('Email', $Email)->exists(); 

		if ($DatosFuncionario==1)  
			{
                
				$datos=DB::table('Funcionarios')->Select('ID_Funcionario_T','Nombres','Apellidos')->whereEmail($Email)->first();

				$token1=Str::random(120); 

				$user = FuncionarioModels::find($datos->ID_Funcionario_T);
				$user->CorreoActivo = 2;  
	            $user->Token = $token1;
	            $user->save();

				$resultado='Funcionario/a '.$datos->Nombres.' '.$datos->Apellidos.', correo enviado correctamente';
				
				$token= 'http://sgd.municipalidadcurico.cl/ResetearContrasenia?id='.$datos->ID_Funcionario_T.'&token='.$token1;

				Mail::to($Email)->send(new RecuperarPasword($datos,$token));
 
			}
            
		else
			{

 				$resultado='Error, Email no existe en los registros';
			}

        return view('Registro/RespuestaRegstro')->with('resultado', $resultado);
	}
}
