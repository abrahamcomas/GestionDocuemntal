<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoFirma extends Model
{
    use HasFactory;

       //referencia a una tabla
       protected $table="DocumentoFirma";
       protected $primaryKey="ID_DocumentoFirma";
   
       //pongo los caampos para permitir insert multiple
       protected $fillable=[
           "ID_Funcionario",
           "ID_Documento",
           "FechaFirma",
           "Firmado",
           "ObservacionFirma"
       ];  

       public $timestamps = false;
}
