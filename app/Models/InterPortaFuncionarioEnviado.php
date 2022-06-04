<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterPortaFuncionarioEnviado extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="InterPortaFuncionarioEnviado"; 
    protected $primaryKey="IPFE_ID"; 

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "IPF_ID_Funcionario",
        "IPF_Portafolio",
        "IPF_Id_OP",
        "ID_OP_LDT_P_E",
        "FechaR",
        "Visto",
        "Estado",
        "Observacion", 
        "ObservacionResp"
    ]; 
    
    public $timestamps = false;
}
