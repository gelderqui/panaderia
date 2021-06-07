<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    protected $fillable =[
        'idclase','nombre','codigo','costo','preciosucursal',
        'preciofranquicia','condiciontemporada','condicion'
    ];
    //Nombre del modelo
    public function clase(){
        return $this->belongsTo('App\Clase');
    }
}
