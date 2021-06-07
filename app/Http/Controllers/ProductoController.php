<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
      //  if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar=='')
        {   //('unir con la tabla clases','llave foranea en la tabla producto'='llave primaria de la tabla clases')
            $productos = Producto::join('clases','productos.idclase','=','clases.id')
            ->select('productos.id','productos.idclase','productos.nombre','clases.nombre as nombre_clase',
            'productos.codigo','productos.costo','productos.preciosucursal','productos.preciofranquicia',
            'productos.condiciontemporada','productos.condicion')
         //   ->where('productos.condicion','=','1')
            ->orderBy('productos.id', 'desc')->paginate(8);
        }
        else
        {
            $productos = Producto::join('clases','productos.idclase','=','clases.id')
            ->select('productos.id','productos.idclase','productos.nombre','clases.nombre as nombre_clase',
            'productos.codigo','productos.costo','productos.preciosucursal','productos.preciofranquicia',
            'productos.condiciontemporada','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
          //  ->where('productos.condicion','=','1')
            ->orderBy('productos.id', 'desc')->paginate(8);
        }
        

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function listar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar=='')
        {   //('unir con la tabla clases','llave foranea en la tabla producto'='llave primaria de la tabla clases')
            $productos = Producto::join('clases','productos.idclase','=','clases.id')
            ->select('productos.id','productos.idclase','productos.nombre','clases.nombre as nombre_clase',
            'productos.codigo','productos.costo','productos.preciosucursal','productos.preciofranquicia',
            'productos.condiciontemporada','productos.condicion')
            ->where('productos.condicion','=','1')
            ->orderBy('productos.id', 'desc')->paginate(100);
        }
        else
        {
            $productos = Producto::join('clases','productos.idclase','=','clases.id')
            ->select('productos.id','productos.idclase','productos.nombre','clases.nombre as nombre_clase',
            'productos.codigo','productos.costo','productos.preciosucursal','productos.preciofranquicia',
            'productos.condiciontemporada','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('productos.condicion','=','1')
            ->orderBy('productos.id', 'desc')->paginate(100);
        }
        
        return ['productos' => $productos];
    }

    public function buscarProducto(Request $request)
        {
         //   if (!$request->ajax()) return redirect('/');
            $filtro=$request->filtro;
            $productos=Producto::join('clases','productos.idclase','=','clases.id')
            ->select('productos.id','productos.idclase','productos.nombre','clases.nombre as nombre_clase','productos.condicion')
            ->where('codigo','=', $filtro)
            ->OrderBy('nombre','asc')->take(1)->get();
            //$productos=Producto::where('codigo','=', $filtro)
            //->select('id','nombre','idclase')->OrderBy('nombre','asc')->take(1)->get();
            
            return['productos'=>$productos];
        }

    /*public function selectProducto(Request $request){
        if (!$request->ajax()) return redirect('/');
        $productos = Producto::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['productos' => $productos];
    }*/
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->idclase = $request->idclase;
        $producto->nombre = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->costo = $request->costo;
        $producto->preciosucursal = $request->preciosucursal;
        $producto->preciofranquicia = $request->preciofranquicia;
        $producto->condiciontemporada = $request->condiciontemporada;
        $producto->condicion = '1';
        $producto->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->idclase = $request->idclase;
        $producto->nombre = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->costo = $request->costo;
        $producto->preciosucursal = $request->preciosucursal;
        $producto->preciofranquicia = $request->preciofranquicia;
        $producto->condiciontemporada = $request->condiciontemporada;
        $producto->condicion = '1';
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '1';
        $producto->save();
    }
}
