<?php

namespace App\Http\Livewire\ODP;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\Portafolio;
use App\Models\DocumentoFirma;
use App\Models\DestinoDocumento;
use App\Models\LinkFirma;
use App\Models\InterPortaFuncionario;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;

class NuevoPortafolioODP extends Component
{

    public $Ayuda=0; 
    
    public function Ayuda(){ 
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
     
    use WithFileUploads;
 
    //Crear imagen firma 
    public $Nombres;
    public $Apellidos;  
    public $Rut;
    public $Oficina;
    public $Cargo;
    public $ID_Plantilla=0;
    public $Creado=1;

    public function Creada(){

        $this->Creado = 0;  

    }
    
    public $DestinoFuncionario,$Titulo_T,$Tipo_T,$Folio,$Fecha_T,$Materia_T,$Privado,$NumeroIngresado;

    public $PDF= [];
    public $Pagina=0; 

    protected $rules = ['DestinoFuncionario' => 'required',
                        'Titulo_T' => 'required',  
                        'Tipo_T' => 'required',
                        'Fecha_T' => 'required', 
                        'PDF' => 'required']; 

	protected $messages = [ 'DestinoFuncionario.required' =>'El campo "Crear solicitud a" es obligatorio.',
                            'Titulo_T.required' =>'El campo "Título" es obligatorio.',
                            'Tipo_T.required' =>'El campo "Tipo" es obligatorio.',
                            'Fecha_T.required' =>'El campo "Dias para finalizar" es obligatorio.',
                            'PDF.required' =>'El campo "Archivo" es obligatorio.'];

    public function Ingresar()
    {   
        $this->validate(); 
        $Funcionario  =  $this->DestinoFuncionario;

        $SubroganteActivo =  DB::table('Subrogante') 
            ->select('Activo')
            ->where('Id_Subrogante_O', '=',$Funcionario)
            ->where('Activo', '=',1)
            ->count();

        if($SubroganteActivo==0){

                $DatosFuncionario = DB::table('Funcionarios')
                ->select('Nombres','Apellidos','Email')
                ->where('ID_Funcionario_T', '=', $Funcionario)->first();
    
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
                $Portafolio->Encargado           = 1;
                $Portafolio->ODP                 = 1;
                $Portafolio->ID_OficinaP         = $ID_OficinaPartes->Id_OP;
                $Portafolio->NumeroInterno       = $NumeroInterno;
                $Portafolio->Privado             = $this->Privado;
                $Portafolio->Folio               = $this->Folio;
                $Portafolio->Estado_T            = 11;
                $Portafolio->Titulo_T            = $this->Titulo_T;
                $Portafolio->Tipo_T              = $this->Tipo_T;
                $Portafolio->Fecha_T             = date("Y/m/d");
                $Portafolio->Anio                = date("y");
                $Portafolio->FechaUrgencia_T     = $DiasTotal;
                $Portafolio->Observacion_T       = $this->Materia_T;
                $Portafolio->save();  
     
     
                $LinkFirma                   = new LinkFirma;
                $LinkFirma->ID_Documento_L   = $Portafolio->ID_Documento_T; 
                $LinkFirma->Titulo_T         = $this->Titulo_T; 
                $LinkFirma->ID_Funcionario_L = $Funcionario;   
                $LinkFirma->Nombres_L        = $DatosFuncionario->Nombres; 
                $LinkFirma->Apellidos_L      = $DatosFuncionario->Apellidos;    
                $LinkFirma->Observacion      = $this->Materia_T;   
                $LinkFirma->Estado           = 0;
                $LinkFirma->Email            = 0;
                $LinkFirma->direccionEmail   = $DatosFuncionario->Email; 
                $LinkFirma->save();
    
                $DatosEncargado =  DB::table('OficinaPartes')
                ->leftjoin('Funcionarios', 'OficinaPartes.ID_Jefatura', '=', 'Funcionarios.ID_Funcionario_T')
                ->select('ID_Funcionario_T','Nombres','Apellidos','Email')
                ->where('Id_OP', '=', $ID_OficinaPartes->Id_OP)
                ->first();
    
    



                if($Funcionario!=$DatosEncargado->ID_Funcionario_T){ 
             
                    $LinkFirmaE                   = new LinkFirma;
                    $LinkFirmaE->ID_Documento_L   = $Portafolio->ID_Documento_T; 
                    $LinkFirmaE->Titulo_T         = $this->Titulo_T; 
                    $LinkFirmaE->ID_Funcionario_L = $DatosEncargado->ID_Funcionario_T;   
                    $LinkFirmaE->Nombres_L        = $DatosEncargado->Nombres; 
                    $LinkFirmaE->Apellidos_L      = $DatosEncargado->Apellidos;    
                    $LinkFirmaE->Observacion      = $this->Materia_T;   
                    $LinkFirmaE->Estado           = 0;
                    $LinkFirmaE->Email            = 0;
                    $LinkFirmaE->direccionEmail   = $DatosEncargado->Email; 
                    $LinkFirmaE->save();


                    $LugarDeTrabajo =  DB::table('Funcionarios')
                    ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                    ->select('ID_DepDirecciones_LDT')  
                    ->where('ID_Funcionario_T', '=', $DatosEncargado->ID_Funcionario_T)->first();
            
                    $OficinaPartes =  DB::table('OficinaPartes')
                    ->select('Id_OP')  
                    ->where('ID_OP_LDT', '=', $LugarDeTrabajo->ID_DepDirecciones_LDT)->first();
             
                
                    $InterPortaFuncionario                      = new InterPortaFuncionario;
                    $InterPortaFuncionario->IPF_ID_Funcionario  = $DatosEncargado->ID_Funcionario_T;
                    $InterPortaFuncionario->IPF_Portafolio      = $Portafolio->ID_Documento_T;  
                    $InterPortaFuncionario->IPF_Id_OP           = $OficinaPartes->Id_OP;  
                    $InterPortaFuncionario->FechaR              = date("Y/m/d");  
                    $InterPortaFuncionario->Visto               = 0;  
                    $InterPortaFuncionario->Estado              = 11;
                    $InterPortaFuncionario->save();
    
                } 
            
                $ID_Documento_T  = $Portafolio->ID_Documento_T;    
                  
                $this->NumeroIngresado=$NumeroInterno.''.date("y");     
     
                foreach ($this->PDF as $Archivos) {  
    
                    $codificado = Storage::disk('PDF')->put('', $Archivos);
    
                    $token = md5($Archivos->getClientOriginalName());
    
                    $DestinoDocumento                   = new DestinoDocumento;
                    $DestinoDocumento->ID_FSube         = $Funcionario;
                    $DestinoDocumento->DOC_ID_Documento = $ID_Documento_T;
                    $DestinoDocumento->Token            = $token; 
                    $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                    $DestinoDocumento->Ruta_T           = $codificado;    
                    $DestinoDocumento->save(); 
     
                    $DocumentoFirma                  = new DocumentoFirma;
                    $DocumentoFirma->ID_Funcionario  = $Funcionario;
                    $DocumentoFirma->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                    $DocumentoFirma->Firmado         = 0;  
                    $DocumentoFirma->save(); 

                    if($Funcionario!=$DatosEncargado->ID_Funcionario_T){ 

                    $DocumentoFirma2                  = new DocumentoFirma;
                    $DocumentoFirma2->ID_Funcionario  = $DatosEncargado->ID_Funcionario_T;
                    $DocumentoFirma2->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                    $DocumentoFirma2->Firmado         = 0;  
                    $DocumentoFirma2->save();
    
                    }

                    $contenido='sgd.municipalidadcurico.cl/MostrarDocumentoQR/'.$DestinoDocumento->ID_DestinoDocumento.'/'.$token.'';
    
                    $NuevaRuta = substr($codificado, 0, -4);
                    $NuevaRuta2 = $NuevaRuta.'.png';
    
                    $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
                    \QRCode::url($contenido)->setOutfile($qrimage)->png();
    
                               
                    $pdf = new FPDI(); 
                    $pagecount =  $pdf->setSourceFile('PDF'.'/'.$codificado);
                    $UltimaPagina=$pagecount;
            
                    for($i =1; $i<=$pagecount; $i++){
                        
                        if($i!=$UltimaPagina){
                            $pdf->AddPage();
                            $pdf->setSourceFile('PDF'.'/'.$codificado);
                            $template = $pdf->importPage($i);
                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                        }
                        else{ 
                            $pdf->AddPage();
                            $pdf->setSourceFile('PDF'.'/'.$codificado);
                            $template = $pdf->importPage($i);
                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                            $pdf->Image('QR/'.$NuevaRuta2, 183, 250, 30, 30);
                            $pdf->SetY(247);
                            $pdf->SetFont('Arial','B',7);
                            $pdf->Cell(182);
                            $pdf->Cell(0,6,utf8_decode("VALIDAR FIRMAS Y V°B°"),0,0,'C');
                            $pdf->Ln(4);
                        }
                    }
             
                    $pdf->Output('F', 'PDF/'.$codificado);
                    $pdf->Output('F', 'ImagenPDF/'.$codificado);
    
     
                    Storage::disk('QR')->delete($NuevaRuta2);
                
                }
    
                $this->Pagina=1; 

            }else
            { 
               
                $SubroganteActivo =  DB::table('Subrogante') 
                ->leftjoin('Funcionarios', 'Subrogante.Id_Subrogante_S', '=', 'Funcionarios.ID_Funcionario_T')
                ->select('Nombres','Apellidos')
                ->where('Id_Subrogante_O', '=',$Funcionario)
                ->where('Subrogante.Activo', '=',1)
                ->first();

                session()->flash('message', 'ERROR. Funcionario con subrogante activado '.$SubroganteActivo->Nombres.' '.$SubroganteActivo->Apellidos);  
            
            
            }  
    } 

    public function Volver()
    {  
        $this->Pagina=0;
    } 
 
    public $TipoDocumento; 
    public $Existe;
    public $ListaFuncionariosOP; 
 
    public function render()
    {
        $this->TipoDocumento =  DB::table('TipoDocumento')
        ->where('EstadoTipoDocumento','=', 1)
        ->get();

        $Funcionario  =  Auth::user()->ID_Funcionario_T; 
 
        $OficinaPartes =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('id_Funcionario_OP', '=', $Funcionario)->get();
        
        $Numero = count($OficinaPartes);

        if($Numero!=0){

            foreach ($OficinaPartes as $user){
                $this->NombreDireccion = $user->Nombre_DepDir;
                $ID_DepDir = $user->ID_DepDir;
            }
 
               
            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('ID_DepDirecciones_LDT', '=', $ID_DepDir)->get();
            $this->mostrar=1;

        } 


 
        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Rut','Nombres','Apellidos','Nombre_DepDir','Cargo','ID_DepDir')->where('ID_Funcionario_T', '=',$Funcionario)->first();

  
        $this->Rut = $DatosFirma->Rut;
        $this->Nombres = $DatosFirma->Nombres;
        $this->Apellidos = $DatosFirma->Apellidos;   
        $this->Oficina = $DatosFirma->Nombre_DepDir;
        $this->Cargo = $DatosFirma->Cargo;

        $ID_DepDir = $DatosFirma->ID_DepDir;

        $Lista =  DB::table('ImagenFirma') 
        ->where('id_Funcionario_T', '=',$Funcionario)
        ->get(); 

        $this->Existe=count($Lista);

        return view('livewire.o-d-p.nuevo-portafolio-o-d-p',[
            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
            ->first(),
            'plantillas' =>  DB::table('plantillas')->get(), 
      ]);
    }
}
