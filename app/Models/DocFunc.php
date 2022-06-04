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
        "Anio",
        "ID_OP_E",
        "ID_OP_LDT_P_DE",
        "ID_OP_R",
        "ID_OP_LDT_P_DR",
        "ID_Documento",
        "ActivoEnvio",
        "FechaR",
        "FechaE",
        "Estado",
        "Visto", 
        "Fecha_V",
        "Mensaje_E",
        "Mensaje_R"

    ]; 
}
