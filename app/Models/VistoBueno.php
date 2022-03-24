<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistoBueno extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="VistoBueno";
    protected $primaryKey="ID_Aviso_T";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "ID_OP_E",
        "ID_OP_R",
        "ID_Documento",
        "Estado",
        "Visto",
        "FechaVisto",
        "Fecha",
        "ObservacionE",
        "ObservacionR"
    ]; 
}
