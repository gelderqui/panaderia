<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sucursal;

class SucursalController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $sucursales = Sucursal::orderBy('id', 'desc')->paginate(8);
        }
        else{
            $sucursales = Sucursal::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(8);
        }
        

        return [
            'pagination' => [
                'total'        => $sucursales->total(),
                'current_page' => $sucursales->currentPage(),
                'per_page'     => $sucursales->perPage(),
                'last_page'    => $sucursales->lastPage(),
                'from'         => $sucursales->firstItem(),
                'to'           => $sucursales->lastItem(),
            ],
            'sucursales' => $sucursales
        ];
        
    }
    public function listar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $sucursales = Sucursal::orderBy('id', 'desc')->paginate(8);
        }
        else{
            $sucursales = Sucursal::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(8);
        }
        return ['sucursales' => $sucursales];
    }
    public function buscarSucursal(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $filtro=$request->filtro;
        $sucursales=Sucursal::where('alias','=', $filtro)
        ->select('id','nombre','alias','tipo','ubicacion','condicion')->OrderBy('nombre','asc')->take(1)->get();
        
        return['sucursales'=>$sucursales];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = new Sucursal();
        $sucursal->nombre = $request->nombre;
        $sucursal->alias = $request->alias;
        $sucursal->codigo = $request->codigo;
        $sucursal->tipo = $request->tipo;
        $sucursal->ubicacion = $request->ubicacion;
        $sucursal->condicion = '1';
        $sucursal->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id);
        $sucursal->nombre = $request->nombre;
        $sucursal->alias = $request->alias;
        $sucursal->codigo = $request->codigo;
        $sucursal->tipo = $request->tipo;
        $sucursal->ubicacion = $request->ubicacion;
        $sucursal->condicion = '1';
        $sucursal->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id);
        $sucursal->condicion = '0';
        $sucursal->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id);
        $sucursal->condicion = '1';
        $sucursal->save();
    }

}
