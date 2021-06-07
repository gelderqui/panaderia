<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    //Indicar al modelo con que tabla trabjar, orm eloquen asume por defecto la tabla a la que hace referencia es en plural.
    //protected $table ='clases';

    //definir cual es la clave primaria, orm eloquen asume por defecto 'id'.
    //protected $primarykey = 'id';

    //definir los atributos del modelo que se quiere agregar en masa.
    protected $fillable=['nombre','descripcion','condicion']; 
    
    //Nombre del modelo en plural
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
    
}
