<?php

namespace App\Http\Livewire\DocumentoExterno;

use Livewire\Component; 
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Auth; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentosExterno;  
use App\Models\DocumentosZip;  
use App\Models\DocumentoFirma;  
use setasign\Fpdi\Fpdi;

class SubirDocumento extends Component
{

    use WithFileUploads;  

 
    //Crear imagen firma
    public $Nombres;
    public $Apellidos; 
    public $Rut;
    public $Oficina;
    public $Cargo;

    public $Creado=1;

    public function Creada(){ 

        $this->Creado = 0;  

    }

    public $Existe; 
    public $PDF= [];
    public $Subido=0; 
    public $Ruta;
    public $RutaImagenFirma;

    protected $RulesRevision = ['PDF' => 'required'];
	protected $RelusMessagesRevision2 = ['PDF.required' =>'El campo PDF es obligatorio.'];

    protected $RulesRevision3 = ['PDF' => 'required',
                                'RutaImagenFirma' => 'required'];

	protected $RelusMessagesRevision3 = ['PDF.required' =>'El campo PDF es obligatorio.',
                                        'RutaImagenFirma.required' =>'El campo TIPO DE IMAGEN DE FIRMA es obligatorio.'];

    public function SubirArchivo(){ 

        $Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Numero =  DB::table('ImagenFirma') 
        ->where('id_Funcionario_T', '=',$Funcionario)
        ->count();


        if($Numero>1){
            
            $this->validate($this->RulesRevision3,$this->RelusMessagesRevision3); 

        }
        else{
            
            $this->validate($this->RulesRevision,$this->RelusMessagesRevision2); 
        }
       

    
        
        $milisegundos = round(microtime(true) * 1000);
        
        $NombreZip = md5($milisegundos);

        foreach ($this->PDF as $Archivos) {  

            
            //Nueva Ruta
            $NuevaRuta = date("y");
            $RutaBase = Storage::disk('ImagenPDF')->put($NuevaRuta, $Archivos);
            $codificado = Storage::disk('PDF')->put($NuevaRuta, $Archivos);
            //FIN

            $DIA=date("d");

            $BorrarDocumentos =  DB::table('DocumentosExterno')->where('id_Funcionario', '=',$Funcionario)->where('DIA', '!=',$DIA)->get();

            foreach ($BorrarDocumentos as $user){  
                        
                Storage::disk('PDF')->delete($user->Ruta_T);

                $DocumentoFirma             =DocumentosExterno::find($user->ID);
                $DocumentoFirma->delete();
        
            } 

            $BorrarZip =  DB::table('DocumentosZip')->where('id_Funcionario', '=',$Funcionario)->where('DIA', '!=',$DIA)->get();

            foreach ($BorrarZip as $user){  
 
               Storage::disk('ZIP')->delete($user->NombreDocumento);

               $DocumentoFirma             =DocumentosZip::find($user->ID);
               $DocumentoFirma->delete();

            }

    
            $DocumentosExterno                   = new DocumentosExterno;
            $DocumentosExterno->id_Funcionario   = $Funcionario;
            $DocumentosExterno->NombreZip        = $NombreZip;
            $DocumentosExterno->Firmado          = 0;
            $DocumentosExterno->NombreDocumento  = $Archivos->getClientOriginalName(); 
            $DocumentosExterno->Ruta_T           = $RutaBase;   
            $DocumentosExterno->DIA              = $DIA;   
            $DocumentosExterno->save();   

            //CREAR IMAGEN DE PDF
            $contenido='sgd.municipalidadcurico.cl';

            $NuevaRuta = substr($codificado, 3, -4);
            $NuevaRuta2 = $NuevaRuta.'.png';

            $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
            \QRCode::url($contenido)->setOutfile($qrimage)->png();

            $filepdf = fopen('PDF'.'/'.$codificado,"r");
            $line_first = fgets($filepdf);

            if($line_first == "%PDF-1.5\r\n"){
                
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
                        $pdf->Image('QR/'.$NuevaRuta2, 173, 240, 40, 40);
                        $pdf->SetY(239);
                        $pdf->SetFont('Arial','B',7);
                        $pdf->Cell(172);
                        $pdf->Cell(0,6,utf8_decode("VALIDAR FIRMAS Y V°B°"),0,0,'C');
                        $pdf->Ln(4);
                    }
                }
     
                $pdf->Output('F', 'ImagenPDF/'.$codificado);
                Storage::disk('QR')->delete($NuevaRuta2);
                //FIN CREAR IMAGEN DE PDF
    
    
                $this->Subido = 1;   
                $this->Ruta = $DocumentosExterno->Ruta_T; 
                 
            }else{
                session()->flash('message2', '"PDF NO COMPATIBLE".');  
            }
 

            
        }

    }

    public function render()
    { 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
 
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

    
        return view('livewire.documento-externo.subir-documento',[
            'Numero' =>  DB::table('ImagenFirma') 
                ->where('id_Funcionario_T', '=',$Funcionario)
            ->count(),
            'ImagenFirma' =>  DB::table('ImagenFirma') 
                ->where('id_Funcionario_T', '=',$Funcionario)
            ->get(),
        ]);
    }
}
