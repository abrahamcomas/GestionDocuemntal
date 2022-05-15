<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioModels extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="Funcionarios";
    protected $primaryKey="ID_Funcionario_T";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "Contrato",
        "Activo",
        "TipoFirma",
        "Root",
        "Acta",
        "Jefe",
        "Secretaria",
        "FirmaMasiva",
    	"Rut",
    	"Nombres",
        "Apellidos", 
        "Email", 
        "Telefono",
        "Cargo", 
        "password",
        "CorreoActivo"

    ]; 
}
