<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class MostrarPDFExterno extends Controller
{
    public function index(Request $request)    
    { 

        $nombreArchivo   = $request->input('nombreArchivo');
       
		$contents = Storage::disk('ZIP')->get($nombreArchivo);

        $Fecha = date("Y/m/d"); 

        $Hora = date("h:i:s"); 

        $numeroDiaFC = date('d', strtotime($Fecha));
        $mesFC = date('F', strtotime($Fecha));

        if($mesFC=='January'){
        $mesFC= 'Enero';
        }
        elseif($mesFC=='February'){   
        $mesFC= 'Febrero';
        }
        elseif($mesFC=='March'){  
        $mesFC= 'Marzo';
        }
        elseif($mesFC=='April'){ 
            $mesFC= 'Abril';
        }
        elseif($mesFC=='May'){
            $mesFC= 'Mayo';
        }
        elseif($mesFC=='June'){
            $mesFC= 'Junio';
        }
        elseif($mesFC=='July'){ 
            $mesFC= 'Julio';
        }
        elseif($mesFC=='August'){  
            $mesFC= 'Agosto';
        }
        elseif($mesFC=='September'){  
            $mesFC= 'Septiembre';
        }
        elseif($mesFC=='October'){  
            $mesFC= 'Octubre';
        }
        elseif($mesFC=='November'){  
            $mesFC= 'Noviembre';
        }
        else{  
            $mesFC= 'Diciembre';
        }
     
        $NombreDescarga='Documentos Firmados el '.$numeroDiaFC.' de '.$mesFC.' a las '.$Hora;
       
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=.$NombreDescarga.zip");
        echo($contents);

    }
}
