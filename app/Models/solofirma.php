<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solofirma extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="solofirma";
        protected $primaryKey="id";
    
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "NombreDocumento",
            "Ruta_T"
        ]; 
 
        public $timestamps = false;
}
