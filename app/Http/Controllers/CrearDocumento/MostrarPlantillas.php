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

        $plantillas =  DB::table('PlantillasCredas')->select('text_plantilla')->where('id_plantillas', $id_plantillas)->first(); 

        return view('CrearDocumento/NuevoDocumento')->with('id_plantillas', $plantillas->text_plantilla);
        
    } 



    public function GuardarPlantillas(Request $request){ 
 

    
        $TextArea   = $request->input('text_plantilla');
        $Nombre   = $request->input('Nombre');


       $IngresoPlantilla             = new IngresoPlantilla;
       $IngresoPlantilla->id_funcionario  =45;
       $IngresoPlantilla->nombre_plantilla = $Nombre;
       $IngresoPlantilla->text_plantilla    = $TextArea;
       $IngresoPlantilla->save();
        
    }

    public function PDFPlantilla(Request $request){

        $text_plantilla = $request->input('text_plantilla'); 

		$pdf = \PDF::loadHTML($text_plantilla); 

		return $pdf->download('PDF.pdf');

        $PDF2 = $pdf->output();

        file_put_contents("archivo.pdf", $PDF2);

    }
}
