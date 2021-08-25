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
        "Activo",
        "TipoFirma",
    	"Root ",
    	"Rut",
    	"Nombres",
        "Apellidos", 
        "Email", 
        "Telefono",
        "password",
        "CorreoActivo"

    ]; 
}
