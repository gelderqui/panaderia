<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areasucursal extends Model
{
    protected $table ='areasucursales';
    protected $fillable =['idarea','idsucursal','condicion'];
}
