<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntePortSubrog extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="IntePortSubrog";
    protected $primaryKey="Id_IntePortSubrog";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "ID_Documento_T_P",
        "Id_subrogante_P"
    ]; 

    public $timestamps = false;
}
