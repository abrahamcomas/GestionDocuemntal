<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\Portafolio;
use App\Models\DocumentoFirma;
use App\Models\DestinoDocumento;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;

class DocumentosNuevos extends Component
{
    use WithFileUploads;
    
    public $Titulo_T,$Tipo_T,$Folio,$Fecha_T,$Materia_T,$NumeroIngresado;

    public $PDF= [];
    public $Pagina=0; 

    protected $rules = ['Titulo_T' => 'required',  
                        'Tipo_T' => 'required',
                        'Fecha_T' => 'required', 
                        'PDF' => 'required']; 

	protected $messages = [ 'Titulo_T.required' =>'El campo Título es obligatorio.',
                            'Tipo_T.required' =>'El campo Tipo es obligatorio.',
                            'Fecha_T.required' =>'El campo Fecha Urgencia es obligatorio.',
                            'PDF.required' =>'El campo Archivo es obligatorio.'];

    public function Ingresar()
    {   
        $this->validate(); 
            $Funcionario  =  Auth::user()->ID_Funcionario_T;

            $AnioActual = date("y");  

            $Numero = DB::table('Portafolio')
                    ->select('NumeroInterno','Anio')
                    ->orderBy('ID_Documento_T', 'DESC')->first();

            if ($Numero==null) {
                $NumeroInterno  = '0';
                $Anio        = $AnioActual; 
    
            }
            else{
                $NumeroInterno  = $Numero->NumeroInterno;
                $Anio           = $Numero->Anio; 
            }
             

            if ($Anio==$AnioActual){ 
                    
                $NumeroInterno=$NumeroInterno+1;
            }
            else{ 
                
                $NumeroInterno=1;
            } 

            $ID_OficinaPartes =  DB::table('LugarDeTrabajo') 
                ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT')
                ->select('Id_OP')
                ->where('ID_Funcionario_LDT', '=',$Funcionario)
                ->where('Estado_LDT', '=',1)
                ->first();
 
            $DiasTotal= date("Y/m/d",strtotime("+ $this->Fecha_T days")); 
            
            $Portafolio                      = new Portafolio;
            $Portafolio->ID_Funcionario_Sol  = $Funcionario;
            $Portafolio->ID_OficinaP         = $ID_OficinaPartes->Id_OP;
            $Portafolio->NumeroInterno       = $NumeroInterno;
            $Portafolio->Folio               = $this->Folio;
            $Portafolio->Estado_T            = 0;
            $Portafolio->Titulo_T            = $this->Titulo_T;
            $Portafolio->Tipo_T              = $this->Tipo_T;
            $Portafolio->Fecha_T             = date("Y/m/d");
            $Portafolio->Anio                = date("y");
            $Portafolio->FechaUrgencia_T     = $DiasTotal;
            $Portafolio->Observacion_T       = $this->Materia_T;
            $Portafolio->save();  
        
            $ID_Documento_T  = $Portafolio->ID_Documento_T;    
             
            $this->NumeroIngresado=$NumeroInterno.''.date("y");    
 
            foreach ($this->PDF as $Archivos) {  

                $codificado = Storage::disk('PDF')->put('', $Archivos);

                $DestinoDocumento                   = new DestinoDocumento;
                $DestinoDocumento->ID_FSube         = $Funcionario;
                $DestinoDocumento->DOC_ID_Documento = $ID_Documento_T;
                $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                $DestinoDocumento->Ruta_T           = $codificado;   
                $DestinoDocumento->save(); 

                $DocumentoFirma                  = new DocumentoFirma;
                $DocumentoFirma->ID_Funcionario  = $Funcionario;
                $DocumentoFirma->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                $DocumentoFirma->Firmado         = 0;  
                $DocumentoFirma->save(); 
            }

            $this->Pagina=1;
        
    } 

    public function Volver()
    {  
        $this->Pagina=0;
    }
 
    public $TipoDocumento; 
    public $Existe;
    public function render()
    {
        $this->TipoDocumento =  DB::table('TipoDocumento')->get();

        $Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Lista =  DB::table('ImagenFirma') 
        ->where('id_Funcionario_T', '=',$Funcionario)
        ->get(); 

        $this->Existe=count($Lista);


        return view('livewire.documentos.documentos-nuevos',[
            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")
            ->first(),
      ]); 
    }
}
