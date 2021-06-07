<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para poder usar transacciones
use Carbon\Carbon;
use App\Area;
use App\Areaproducto;
use App\Areasucursal;
use App\Sucursal;
use App\Producto;
use App\Clase;


class AreaController extends Controller
{
public function index(Request $request)
{
    if (!$request->ajax()) return redirect('/');

    $buscar = $request->buscar;
    $criterio = $request->criterio;
    
    if ($buscar==''){
        $areas = Area::where('condicion','=','1')->orderBy('id', 'desc')->paginate(8);
    }
    else{
        $areas = Area::where($criterio, 'like', '%'. $buscar . '%')
        ->where('condicion','=','1')
        ->orderBy('id', 'desc')->paginate(8);
    }
    

    return [
        'pagination' => [
            'total'        => $areas->total(),
            'current_page' => $areas->currentPage(),
            'per_page'     => $areas->perPage(),
            'last_page'    => $areas->lastPage(),
            'from'         => $areas->firstItem(),
            'to'           => $areas->lastItem(),
        ],
        'areas' => $areas
    ];
}

public function obtenerDetalle(Request $request)
{
    if (!$request->ajax()) return redirect('/');

    $id = $request->id;
    $detalles = Areasucursal::join('areas','areasucursales.idarea','=','areas.id')
    ->join('sucursales','areasucursales.idsucursal','=','sucursales.id')
    ->select('sucursales.nombre as sucursal','sucursales.alias','sucursales.tipo','sucursales.condicion as estado')
    ->where('idarea','=',$id)
    ->orderBy('areasucursales.idsucursal','asc')->get();;

    return['detalles'=>$detalles]; 
}
public function obtenerDetalle2(Request $request)
{
    if (!$request->ajax()) return redirect('/');

    $id = $request->id;
    $detalles = Areaproducto::join('areas','areaproductos.idarea','=','areas.id')
    ->join('productos','areaproductos.idproducto','=','productos.id')
    ->join('clases','productos.idclase','=','clases.id')
    ->select('productos.codigo','productos.nombre as producto','clases.nombre as clase','productos.condicion')
    ->where('idarea','=',$id)
    ->orderBy('areaproductos.idproducto','asc')->get();;

    return['detalles'=>$detalles]; 
}

public function store(Request $request)
{
    
    if (!$request->ajax()) return redirect('/');
    try{
        DB::beginTransaction();
        $area = new Area();
        $area->nombre = $request->nombre;
        $area->descripcion=$request->descripcion;
        $area->condicion = '1';
        $area->save();
   
        $detalles = $request->data;//Array de areaproducto
        //Recorro todos los elementos
        foreach($detalles as $ep=>$det)
        {
            $detalle = new Areaproducto();
            $detalle->idarea = $area->id;
            $detalle->idproducto = $det['idproducto'];
            $detalle->condicion = '1';         
            $detalle->save();
        }

        $detalles2 = $request->data2;//Array de areaproducto
        //Recorro todos los elementos
        foreach($detalles2 as $ep=>$det2)
        {
            $detalle2 = new Areasucursal();
            $detalle2->idarea = $area->id;
            $detalle2->idsucursal = $det2['idsucursal'];
            $detalle2->condicion = '1';         
            $detalle2->save();
        }

    
        DB::commit();
    } catch (Exception $e){
            DB::rollBack();
    }
}
/*
public function update(Request $request)
{
    
    if (!$request->ajax()) return redirect('/');
        $area = Area::findOrFail($request->id);
        $area->nombre = $request->nombre;
        $area->descripcion=$request->descripcion;
        $area->condicion = '1';
        $area->save();    

}
public function update2(Request $request)
{
    $detalles = $request->datas;//Array de areaproducto
    //Recorro todos los elementos
    foreach($detalles as $ep=>$det)
    {
        $detalle = new Areaproducto();
        $detalle->idarea = $request->id;
        $detalle->idproducto = $det['idproducto'];
        $detalle->condicion = '1';         
        $detalle->save();
    }

    $detalles2 = $request->datas2;//Array de areaproducto
    //Recorro todos los elementos
    foreach($detalles2 as $ep=>$det2)
    {
        $detalle2 = new Areasucursal();
        $detalle2->idarea = $request->id;
        $detalle2->idsucursal = $det2['idsucursal'];
        $detalle2->condicion = '1';         
        $detalle2->save();
    }
}
*/
public function desactivar(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $area = Area::findOrFail($request->id);
    $area->condicion = '0';
    $area->save();
}

public function activar(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $area = Area::findOrFail($request->id);
    $area->condicion = '1';
    $area->save();
}
}
