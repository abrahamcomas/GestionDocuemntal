<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use App\Models\MPlantillas;   
use Illuminate\Support\Facades\Storage;

class Plantillas extends Controller
{
    public function index(Request $request)
    {   
   
        $plantillas =  DB::table('plantillas')->get(); 

        return view('Plantillas/AgregarPlantillas')->with('plantillas', $plantillas);
      
    }

    public function DescargarPlantillas(Request $request)
    {   
   
        $id_plantillas  = $request->input('id_plantillas');

        $plantillas =  DB::table('plantillas')->select('nombre_plantilla','Ruta_T')->where('id_plantillas', '=', $id_plantillas)->first(); 
        
        $Ruta_T = $plantillas->Ruta_T;
        $nombre_plantilla = $plantillas->nombre_plantilla;

        $file = Storage::disk('WORD')->get($Ruta_T);
        	
        header('Content-Type: application/docx');
        header('Content-Disposition: inline; filename="'.basename($nombre_plantilla).'"');
        echo $file;
     
      
    }


    public function EliminarPlantillas(Request $request)
    {   
        $id_plantillas  = $request->input('id_plantillas');

        $plantillas =  DB::table('plantillas')->select('Ruta_T')->where('id_plantillas', '=', $id_plantillas)->first(); 
        
        $Ruta_T = $plantillas->Ruta_T;

        $codificado = Storage::disk('WORD')->delete($Ruta_T);
                
        $MPlantillas                   = MPlantillas::find($id_plantillas);
        $MPlantillas->delete();

        $Resultado='Plantilla eliminada correctamente.';

        return view('Plantillas/Resultado')->with('Resultado', $Resultado);
      
    }



    public function DescargarPlantillasU(Request $request)
    {   

        $plantillas =  DB::table('plantillas')->get(); 

        return view('Plantillas/DescargarPlantillasU')->with('plantillas', $plantillas);
      
    }
  
}
