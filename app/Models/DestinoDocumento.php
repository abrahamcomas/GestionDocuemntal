<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoDocumento extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="DestinoDocumento";
        protected $primaryKey="ID_DestinoDocumento";
    
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "ID_FSube",
            "DOC_ID_Documento",
            "Token",
            "NombreDocumento",
            "Ruta_T"
        ]; 
 
        public $timestamps = false;
}
