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
            'Rut' => 'required',   
        ];  
 
        $messages = [ 
            'Rut.required' =>'El campo Rut es obligatorio.',
        ]; 

        $this->validate($request, $rules, $messages);

        $Rut = $request->input('Rut');

		$DatosFuncionario=DB::table('Funcionarios')->where('Rut', $Rut)->exists(); 

		if ($DatosFuncionario==1)  
			{
              
				$datos=DB::table('Funcionarios')->Select('ID_Funcionario_T','Nombres','Apellidos','Email')->whereRut($Rut)->first();

				$token1=Str::random(120); 

				$user = FuncionarioModels::find($datos->ID_Funcionario_T);
				$user->CorreoActivo = 2;  
	            $user->Token = $token1;
	            $user->save();
            
				$resultado='Funcionario/a '.$datos->Nombres.' '.$datos->Apellidos.', correo enviado correctamente a '.$datos->Email;
				
				$token= 'http://sgd.municipalidadcurico.cl/ResetearContrasenia?id='.$datos->ID_Funcionario_T.'&token='.$token1;

				Mail::to($datos->Email)->send(new RecuperarPasword($datos,$token));
 
			}
            
		else
			{

 				$resultado='Error, Email no existe en los registros';
			}

        return view('Registro/RespuestaRegstro')->with('resultado', $resultado);
	}
}
