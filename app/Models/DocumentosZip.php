<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosZip extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="DocumentosZip";
    protected $primaryKey="ID";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "id_Funcionario",
        "NombreDocumento",
        "Ruta_T",
        "DIA"
    ]; 

    public $timestamps = false;

}
