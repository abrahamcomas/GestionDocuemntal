<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;    
use Illuminate\Support\Facades\Auth; 
use setasign\Fpdi\Fpdi;

class IngresarQRController extends Controller
{
    public function index(Request $request)   
    {

        $Ruta  = $request->input('Ruta');
        $NuevaRuta2  = $request->input('NuevaRuta2');
                                          
        $pdf = new FPDI(); 
        $pagecount =  $pdf->setSourceFile('PDF'.'/'.$Ruta);
        $UltimaPagina=$pagecount;

        for($i =1; $i<=$pagecount; $i++){
            
            if($i!=$UltimaPagina){
                $pdf->AddPage();
                $pdf->setSourceFile('PDF'.'/'.$Ruta);
                $template = $pdf->importPage($i);
                $pdf->useTemplate($template,0, 0, 215, 280, true);
            }
            else{ 
                $pdf->AddPage();
                $pdf->setSourceFile('PDF'.'/'.$Ruta);
                $template = $pdf->importPage($i);
                $pdf->useTemplate($template,0, 0, 215, 280, true);
                $pdf->Image('QR/'.$NuevaRuta2, 177, 242, 40, 40);
            }
        }

        $pdf->Output('F', 'PDF/'.$Ruta);



        $status='OK';
        return view('Documentos/DocumentoFirmado', compact('status'));



















    }
}
