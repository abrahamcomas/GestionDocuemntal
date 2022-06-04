<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterPortaFuncionario extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="InterPortaFuncionario"; 
    protected $primaryKey="IPF_ID"; 

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
    	"IPF_ID_Funcionario",
    	"IPF_Portafolio",
        "IPF_Id_OP",
        "ID_OP_LDT_P_IP",
    	"FechaR",
        "Visto",
        "Estado",
        "Observacion",
        "ObservacionE"
    ]; 
    
    public $timestamps = false;
}
