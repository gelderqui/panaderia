<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table ='sucursales';

    protected $fillable=['nombre','alias','tipo','ubicacion','condicion']; 
    
}
