<?php

namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuncionarioModels;
use App\Models\FirmadosDD; 
use App\Models\FirmadosFunc; 
use App\Models\AnioDD; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{ 
    public function index(Request $request)
    {  
        
        $NumeroMes =date("n") - 1;
        $NumeroAnio =date("Y") - 1;

        $Funcionario = FirmadosFunc::where('Mes_Func', date("n"))->where('Anio_Func', date("Y"))->orderBy('NumeroFunc', 'DESC')->take(10)->get();

        if(sizeof($Funcionario)){
            foreach($Funcionario as $n){
                $puntosFuncionario[] =['name' => $n['Nombres'], 'y'=>floatval($n['NumeroFunc'])];
            }
        }
        else{

            $Funci = FirmadosFunc::where('Mes_Func', $NumeroMes)->where('Anio_Func', date("Y")) ->orderBy('NumeroFunc', 'DESC')->take(10)->get();
            foreach($Funci as $n){
                $puntosFuncionario[] =['name' => $n['Nombres'], 'y'=>floatval($n['NumeroFunc'])];
            } 

            if(empty($puntosFuncionario)){

                $puntosFuncionario=0;
            }
        }

        $FirmadosDD = FirmadosDD::where('Mes_DD', date("n"))->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

        if(sizeof($FirmadosDD)){
            foreach($FirmadosDD as $navegador){
                
                $puntos[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }
        }
        else{ 

            $FirDD = FirmadosDD::where('Mes_DD', $NumeroMes)->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();
            foreach($FirDD as $navegador){
                
                $puntos[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }

            if(empty($puntos)){

                $puntos=0;
            }

        }

        $Anio = AnioDD::where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get(); 

        if(sizeof($Anio)){
            foreach($Anio as $navegador){
                $puntosAnio[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }
        }
        else{  

            $A = AnioDD::where('Anio_DD', $NumeroAnio)->orderBy('Numero_DD', 'DESC')->take(10)->get();

            foreach($A as $navegador){
                
                $puntosAnio[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }

            if(empty($puntosAnio)){

                $puntosAnio=0;
            }
        }

        $FuncionarioTodos = FirmadosFunc::where('Mes_Func', date("n"))->where('Anio_Func', date("Y"))->orderBy('NumeroFunc', 'DESC')->take(10)->get();

        $FirmadosDDTodos = FirmadosDD::where('Mes_DD', date("n"))->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

        $AnioTodos = AnioDD::where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

    	$rules = [
            'RUN' => 'required', 
            'password' => 'required|min:6',
        ];

        $messages = [
            'RUN.required' =>'El campo Rut es obligatorio.',
            'password.required' =>'El campo Contraseña es obligatorio.' 
        ];

        $this->validate($request, $rules, $messages);

        $RUN = $request->input('RUN'); 
        $password = $request->input('password');   
        $Activo0=0;

        $ExisteRUT=FuncionarioModels::Select('ID_Funcionario_T')->whereRut($RUN)->first();

        if (!empty($ExisteRUT->ID_Funcionario_T))
        {
            $Colores =  DB::table('Colores') 
            ->where('ID_Funcionario', '=',$ExisteRUT->ID_Funcionario_T) 
            ->first(); 
            
            if (!empty($Colores->ColorPrincipal)){
                $ColorPrincipal   = $Colores->ColorPrincipal; 
                session(['ColorPrincipal' => $ColorPrincipal]);
            }

            if (!empty($Colores->ColorSecundario)){
                $ColorSecundario  = $Colores->ColorSecundario;
                session(['ColorSecundario' => $ColorSecundario]);  
            }

            if (!empty($Colores->BodyPrincipal)){
                $BodyPrincipal    = $Colores->BodyPrincipal; 
                session(['BodyPrincipal' => $BodyPrincipal]);
            }

            if (!empty($Colores->BodySecundario)){
                $BodySecundario   = $Colores->BodySecundario;
                session(['BodySecundario' => $BodySecundario]); 
            }   
                
            if (!empty($Colores->FocoNoSelecLetra)){
                $FocoNoSelecLetra = $Colores->FocoNoSelecLetra; 
                session(['FocoNoSelecLetra' => $FocoNoSelecLetra]); 
            }
            
            if (!empty($Colores->FocoNoSelecFondo)){
                $FocoNoSelecFondo = $Colores->FocoNoSelecFondo;
                session(['FocoNoSelecFondo' => $FocoNoSelecFondo]);
            }  

            if (!empty($Colores->FocoSelecLetra)){
                $FocoSelecLetra       = $Colores->FocoSelecLetra;
                session(['FocoSelecLetra' => $FocoSelecLetra]);
            }    
            
            if (!empty($Colores->FocoSelecFondo)){
                $FocoSelecFondo  = $Colores->FocoSelecFondo;
                session(['FocoSelecFondo' => $FocoSelecFondo]);  
            }
                
            if (!empty($Colores->LetraLista)){
                $LetraLista       = $Colores->LetraLista;
                session(['LetraLista' => $LetraLista]);
            }    
            
            if (!empty($Colores->LetraPrincipal)){
                $LetraPrincipal  = $Colores->LetraPrincipal;
                session(['LetraPrincipal' => $LetraPrincipal]);  
            }

            $ROOT =  DB::table('Funcionarios')  
            ->where('Rut', '=',$RUN)
            ->where(function($query) {
                $query->orwhere('Root', '=', 1) 
                    ->orwhere('Root', '=', 2);  
            })  
            ->select('Rut') 
            ->first();  


            $JEFE =  DB::table('Funcionarios') 
            ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.ID_Jefatura') 
            ->where('Rut', '=',$RUN)
            ->where('Activo', '=',1)
            ->where('ID_Jefatura', '!=',NULL)
            ->select('Rut')
            ->first();

            $LugarDeTrabajo =  DB::table('LugarDeTrabajo')
            ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('Nombre_DepDir')
            ->where('ID_Funcionario_LDT', '=',$ExisteRUT->ID_Funcionario_T)->first();

            $LugarDeTrabajo = $LugarDeTrabajo->Nombre_DepDir;
            session(['LugarDeTrabajo' => $LugarDeTrabajo]);  
            
            if (!empty($ROOT->Rut))
            { 

                if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                {

                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                    $OficinaPartes =  DB::table('OficinaPartes')  
                    ->select('id_Funcionario_OP')
                    ->where('id_Funcionario_OP', '=',$ID_Funcionario)
                    ->count(); 

                    if($OficinaPartes>=2){

                        $DatosOficinaPartes =  DB::table('OficinaPartes')  
                            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
                            ->select('ID_DepDir','Nombre_DepDir')
                            ->where('id_Funcionario_OP', '=',$ID_Funcionario)
                            ->get();
                    }else{

                        $DatosOficinaPartes=1;
                    }

                    return view('Sistema/Principal',["DataFunc"=>json_encode($puntosFuncionario),"data"=>json_encode($puntos),"DatatAnio"=>json_encode($puntosAnio)])->with('FuncionarioTodos', $FuncionarioTodos)->with('FirmadosDDTodos', $FirmadosDDTodos)->with('AnioTodos', $AnioTodos)->with('DatosOficinaPartes', $DatosOficinaPartes);

                } 
                else
                { 
                return back()
                        ->withErrors(['Contraseña Incorrecta'])
                        ->withInput(request(['RUN']));
                }

            }
            elseif (!empty($JEFE->Rut))
            { 

                if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                { 

                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                    $id_Funcionario_OP =  DB::table('OficinaPartes') 
                    ->select('id_Funcionario_OP')
                    ->where('ID_Jefatura', '=',$ID_Funcionario)
                    ->first(); 

                    $OficinaPartes =  DB::table('OficinaPartes')  
                                ->select('id_Funcionario_OP')
                                ->where('id_Funcionario_OP', '=',$ID_Funcionario)
                                ->count(); 

                                if($OficinaPartes>=2){

                                    $DatosOficinaPartes =  DB::table('OficinaPartes')  
                                        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
                                        ->select('ID_DepDir','Nombre_DepDir')
                                        ->where('id_Funcionario_OP', '=',$ID_Funcionario->ID_Funcionario_T)
                                        ->get();
                                }else{

                                    $DatosOficinaPartes=1;
                                }

                    if(!empty($id_Funcionario_OP->id_Funcionario_OP)){
                        return view('Sistema/Principal',["DataFunc"=>json_encode($puntosFuncionario),"data"=>json_encode($puntos),"DatatAnio"=>json_encode($puntosAnio)])->with('FuncionarioTodos', $FuncionarioTodos)->with('FirmadosDDTodos', $FirmadosDDTodos)->with('AnioTodos', $AnioTodos)->with('DatosOficinaPartes', $DatosOficinaPartes);
                    } 
                    else{

                        return view('Posts/EncargadoODP/EncargadoODP');
                    }


                } 
                else
                {
                return back()
                        ->withErrors(['Contraseña Incorrecta'])
                        ->withInput(request(['RUN']));
                }

            }
            else
            {
 
                $ID_Funcionario =  DB::table('Funcionarios')->select('ID_Funcionario_T')
                ->where('Rut', '=',$RUN)
                ->first();

                $LugarDeTrabajo =  DB::table('LugarDeTrabajo') 
                ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT') 
                ->select('id_Funcionario_OP','ID_Jefatura')
                ->where('ID_Funcionario_LDT', '=',$ID_Funcionario->ID_Funcionario_T)
                ->first();

                if (!empty($LugarDeTrabajo->ID_Jefatura))  
                { 
                    if (!empty($LugarDeTrabajo->id_Funcionario_OP))
                    { 
                        $idLogin=FuncionarioModels::Select('ID_Funcionario_T','Activo','Rut','password')->whereRut($RUN)->first();

                        if (!empty($idLogin->Rut) AND !empty($idLogin->Activo==1))
                        { 

                            if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                            {

                                $OficinaPartes =  DB::table('OficinaPartes')  
                                ->select('id_Funcionario_OP')
                                ->where('id_Funcionario_OP', '=',$ID_Funcionario->ID_Funcionario_T)
                                ->count(); 

                                if($OficinaPartes>=2){

                                    $DatosOficinaPartes =  DB::table('OficinaPartes')  
                                        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
                                        ->select('ID_DepDir','Nombre_DepDir')
                                        ->where('id_Funcionario_OP', '=',$ID_Funcionario->ID_Funcionario_T)
                                        ->get();

                          
                                }else{

                                    $DatosOficinaPartes=1;
                                }

                             
                                return view('Sistema/Principal',["DataFunc"=>json_encode($puntosFuncionario),"data"=>json_encode($puntos),"DatatAnio"=>json_encode($puntosAnio)])->with('FuncionarioTodos', $FuncionarioTodos)->with('FirmadosDDTodos', $FirmadosDDTodos)->with('AnioTodos', $AnioTodos)->with('DatosOficinaPartes', $DatosOficinaPartes);

                            } 
                            else
                            {
                            return back()
                                    ->withErrors(['Contraseña Incorrecta'])
                                    ->withInput(request(['RUN']));
                            }
                        }
                        elseif(!empty($idLogin->Rut) AND !empty($idLogin->Activo==0))
                        {
                            return back()
                                ->withErrors(['Usuario desactivado, o en espera de confirmación de ingreso.'])
                                ->withInput(request(['RUN']));
                        }
                        elseif(!empty($idLogin->Rut) AND !empty($idLogin->Activo==2))
                        {
                            return back()
                                ->withErrors(['Usuario desactivado.'])
                                ->withInput(request(['RUN']));
                        }
                        else
                        {
                            return back()
                                ->withErrors(['Usuario No Registrado'])
                                ->withInput(request(['RUN']));
                        }           
                    }
                    else  
                    {
                        $Nombre =  DB::table('Funcionarios') 
                        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                        ->select('Nombre_DepDir')
                        ->where('Rut', '=',$RUN)
                        ->first(); 
                        
                        return back()
                        ->withErrors([$Nombre->Nombre_DepDir.' NO SE ENCUENTRA HABILITADO ACTUALMENTE.'])
                        ->withInput(request(['RUN']));
                    }
                }
                else 
                {
                    $Nombre =  DB::table('Funcionarios') 
                    ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                    ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                    ->select('Nombre_DepDir')
                    ->where('Rut', '=',$RUN)
                    ->first(); 
                    
                    return back()
                    ->withErrors([$Nombre->Nombre_DepDir.' NO SE ENCUENTRA HABILITADO ACTUALMENTE.'])
                    ->withInput(request(['RUN']));
                }
            }
        }
        else
        {
            return back()
                ->withErrors(['Usuario No Registrado'])
                ->withInput(request(['RUN']));
        }
    }
}
