<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosExterno extends Model
{
    use HasFactory;

         //referencia a una tabla
         protected $table="DocumentosExterno";
         protected $primaryKey="ID";
     
         //pongo los caampos para permitir insert multiple
         protected $fillable=[
             "id_Funcionario",
             "NombreZip",
             "Firmado", 
             "NombreDocumento",
             "Ruta_T",
             "DIA"
         ]; 
  
         public $timestamps = false;
}
