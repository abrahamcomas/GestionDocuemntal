<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocFunc extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="DocFunc";
    protected $primaryKey="ID_IntDocFunc";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "ID_Funcionario",
        "ID_Documento",
        "Asignador",
        "ActivoEnvio",
        "FechaR",
        "FechaE",
        "Estado",
        "Visto", 
        "Fecha_V",
        "Mensaje_Cre"

    ]; 
}
