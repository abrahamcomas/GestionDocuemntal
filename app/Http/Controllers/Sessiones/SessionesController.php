<?php

namespace App\Http\Controllers\Sessiones; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 

class SessionesController extends Controller
{
    public function index(Request $request)  
    {
	
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;   
                                            
        $sessiones =  DB::table('sessions')->where('user_id', '=', $ID_Funcionario)->get();
    
        return view('Vinculados/DispositivosVinculados')->with('sessiones', $sessiones);
    }
}
