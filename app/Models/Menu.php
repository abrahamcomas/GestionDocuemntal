<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="Menu";
    protected $primaryKey="id_Menu";
 
    //pongo los caampos para permitir insert multiple
    protected $fillable=[
         "NombreMenu"
    ]; 

    public $timestamps = false;
}
