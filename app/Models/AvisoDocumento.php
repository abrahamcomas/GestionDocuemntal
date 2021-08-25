<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvisoDocumento extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="AvisoDocumento";
    protected $primaryKey="ID_Aviso_T";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "ID_Funcionario",
        "ID_Documento",
        "Visto",
        "Fecha",
        "Observacion"

    ]; 
}
