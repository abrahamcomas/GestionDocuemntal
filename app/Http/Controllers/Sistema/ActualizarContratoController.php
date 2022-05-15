<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuncionarioModels;
use App\Models\FirmadosDD; 
use App\Models\FirmadosFunc; 
use App\Models\AnioDD; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; 

class ActualizarContratoController extends Controller
{
    public function index(Request $request)
    {  
        $Contrato = $request->input('Contrato'); 
        
        $Id_Funcionario = Auth::user()->ID_Funcionario_T; 

        $user = FuncionarioModels::find($Id_Funcionario);
        $user->Contrato = $Contrato;
        $user->save();

        return view('Posts/Principal/PrincipalPosts');
   
    }
}
  