<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\Documento;
use App\Models\DocumentoFirma;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;




class DocumentosNuevos extends Component
{
    use WithFileUploads;
    
    public $Titulo_T,$Tipo_T,$Fecha_T,$Materia_T,$PDF;

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
            

            $codificado = Storage::disk('PDF')->put('', $this->PDF);

       
            $Documento                      = new Documento;
            $Documento->ID_Funcionario_Sol  = $Funcionario;
            $Documento->Estado_T            = 0;
            $Documento->Titulo_T            = $this->Titulo_T;
            $Documento->Tipo_T              = $this->Tipo_T;
            $Documento->Fecha_T             = date("Y/m/d");
            $Documento->Anio                = date("Y");
            $Documento->FechaUrgencia_T     = $this->Fecha_T;
            $Documento->Observacion_T       = $this->Materia_T;
            $Documento->Ruta_T              = $codificado;  
            $Documento->save(); 
        
            $ID_Documento_T  = $Documento->ID_Documento_T;            

            $DocumentoFirma                   = new DocumentoFirma;
            $DocumentoFirma->ID_Funcionario    = $Funcionario;
            $DocumentoFirma->ID_Documento      = $ID_Documento_T;
            $DocumentoFirma->Firmado            = 0; 
            $DocumentoFirma->save();


            $this->Pagina=1;
        
    }

    public function Volver()
    { 

        $this->Pagina=0;
    }

    public $TipoDocumento;
    public function render()
    {
        $this->TipoDocumento =  DB::table('TipoDocumento')->get();
        return view('livewire.documentos.documentos-nuevos');
    }
}
