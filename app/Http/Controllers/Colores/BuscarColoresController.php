<?php

namespace App\Http\Controllers\Colores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;  

class BuscarColoresController extends Controller
{
    public function Buscar(){  

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $Datos =  DB::table('Colores')->where('ID_Funcionario', '=',$ID_Funcionario)->first();

        if(!empty($Datos->ColorPrincipal)){
            $ColorPrincipal  = $Datos->ColorPrincipal;

        }
        else{
            $ColorPrincipal  = "#09818F";

        }

        if(!empty($Datos->ColorSecundario)){
            $ColorSecundario  = $Datos->ColorSecundario;

        }
        else{
            $ColorSecundario  = "#000000";

        }
        
        if(!empty($Datos->BodyPrincipal)){
            $BodyPrincipal  = $Datos->BodyPrincipal;

        }
        else{
            $BodyPrincipal  = "#8AB3D3";

        }
       
        if(!empty($Datos->BodySecundario)){
            $BodySecundario  = $Datos->BodySecundario;

        }
        else{
            $BodySecundario  = "#FFFFFF";

        }
      
        if(!empty($Datos->FocoNoSelecLetra)){
            $FocoNoSelecLetra  = $Datos->FocoNoSelecLetra;

        }
        else{
            $FocoNoSelecLetra  = "#56FF02";

        }
   
        if(!empty($Datos->FocoNoSelecFondo)){
            $FocoNoSelecFondo  = $Datos->FocoNoSelecFondo;

        }
        else{
            $FocoNoSelecFondo  = "#0E8B85";

        }
        
        if(!empty($Datos->FocoSelecLetra)){
            $FocoSelecLetra  = $Datos->FocoSelecLetra;

        }
        else{
            $FocoSelecLetra  = "#FFFFFF";

        }

        if(!empty($Datos->FocoSelecFondo)){
            $FocoSelecFondo  = $Datos->FocoSelecFondo;

        }
        else{
            $FocoSelecFondo  = "#0E8B85";

        }
       
        if(!empty($Datos->LetraLista)){
            $LetraLista  = $Datos->LetraLista;

        }
        else{
            $LetraLista  = "#56FF02";

        }
        
        if(!empty($Datos->LetraPrincipal)){
            $LetraPrincipal  = $Datos->LetraPrincipal;

        }
        else{
            $LetraPrincipal  = "#FFFFFF";

        }
        
        return view('Colores/Colores')->with('ColorPrincipal', $ColorPrincipal)->with('ColorSecundario', $ColorSecundario)->with('BodyPrincipal', $BodyPrincipal)
        ->with('BodySecundario', $BodySecundario)->with('FocoNoSelecLetra', $FocoNoSelecLetra)->with('FocoNoSelecFondo', $FocoNoSelecFondo)->with('FocoSelecLetra', $FocoSelecLetra)
        ->with('FocoSelecFondo', $FocoSelecFondo)->with('LetraLista', $LetraLista)->with('LetraPrincipal', $LetraPrincipal);
    }
}
