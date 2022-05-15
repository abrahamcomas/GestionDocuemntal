<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoFirma11 extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="DocumentoFirma11";
     protected $primaryKey="ID_DocumentoFirma";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "ID_Funcionario",
         "ID_Documento",
         "FechaFirma",
         "Firmado"
     ];  

     public $timestamps = false;
}
