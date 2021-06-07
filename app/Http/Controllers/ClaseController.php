<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clase;
class ClaseController extends Controller
{
    public function index(Request $request)
    {
        /*
        $clases = Clase::all();
        return $clases;
        */
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $clases = Clase::orderBy('id', 'desc')->paginate(8);
        }
        else{
            $clases = Clase::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(8);
        }
        

        return [
            'pagination' => [
                'total'        => $clases->total(),
                'current_page' => $clases->currentPage(),
                'per_page'     => $clases->perPage(),
                'last_page'    => $clases->lastPage(),
                'from'         => $clases->firstItem(),
                'to'           => $clases->lastItem(),
            ],
            'clases' => $clases
        ];
    } 
    
    public function selectClase(Request $request){
        if (!$request->ajax()) return redirect('/');
        $clases = Clase::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['clases' => $clases];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clase = new Clase();
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->condicion = '1';
        $clase->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clase = Clase::findOrFail($request->id);
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->condicion = '1';
        $clase->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clase = Clase::findOrFail($request->id);
        $clase->condicion = '0';
        $clase->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clase = Clase::findOrFail($request->id);
        $clase->condicion = '1';
        $clase->save();
    }

}
