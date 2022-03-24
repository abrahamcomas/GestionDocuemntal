<?php

namespace App\Http\Controllers\CrearDocumento;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IngresoPlantilla;

class MostrarPlantillas extends Controller
{
    public function index(Request $request){ 

        $id_plantillas   = $request->input('id_plantillas');

        $plantillas =  DB::table('plantillas')->select('text_plantilla')->where('id_plantillas', $id_plantillas)->first(); 

        
         echo $plantillas->text_plantilla;
        
    }



    public function GuardarPlantillas(Request $request){ 

      
        $N_plantilla   = $request->input('N_plantilla');
        $TextArea   = $request->input('TextArea');

      

       $IngresoPlantilla             = new IngresoPlantilla;
       $IngresoPlantilla->id_funcionario  =45;
       $IngresoPlantilla->nombre_plantilla = $N_plantilla;
       $IngresoPlantilla->text_plantilla    = $TextArea;
       $IngresoPlantilla->save();
        
    }
}
