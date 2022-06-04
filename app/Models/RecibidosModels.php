<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibidosModels extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="Recibidos";
     protected $primaryKey="ID_Ricibidos";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "Anio",
         "R_ID_ODPE",
         "ID_OP_LDT_P_RE",
         "R_ID_ODPR",
         "ID_OP_LDT_P_RR",
         "R_ID_Documento",
         "R_Estado",
         "R_Visto", 
         "R_FechaVisto",
         "R_Fecha",
         "R_ObservacionE"
     ]; 
}
