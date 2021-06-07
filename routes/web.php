<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido/contenido');
});

Route::get('/clase', 'ClaseController@index');
Route::post('/clase/registrar', 'ClaseController@store');
Route::put('/clase/actualizar', 'ClaseController@update');
Route::put('/clase/desactivar', 'ClaseController@desactivar');
Route::put('/clase/activar', 'ClaseController@activar');
Route::get('/clase/selectClase', 'ClaseController@selectClase');

Route::get('/producto', 'ProductoController@index');
Route::post('/producto/registrar', 'ProductoController@store');
Route::put('/producto/actualizar', 'ProductoController@update');
Route::put('/producto/desactivar', 'ProductoController@desactivar');
Route::put('/producto/activar', 'ProductoController@activar');
Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
Route::get('/producto/listar', 'ProductoController@listar');

Route::get('/sucursal', 'SucursalController@index');
Route::post('/sucursal/registrar', 'SucursalController@store');
Route::put('/sucursal/actualizar', 'SucursalController@update');
Route::put('/sucursal/desactivar', 'SucursalController@desactivar');
Route::put('/sucursal/activar', 'SucursalController@activar');
Route::get('/sucursal/buscarSucursal', 'SucursalController@buscarSucursal');
Route::get('/sucursal/listar', 'SucursalController@listar');

Route::get('/area', 'AreaController@index');
Route::post('/area/registrar', 'AreaController@store');
//Route::put('/area/actualizar', 'AreaController@update');
//sRoute::post('/area/actualizar2', 'AreaController@update2');
Route::put('/area/desactivar', 'AreaController@desactivar');
Route::put('/area/activar', 'AreaController@activar');
Route::get('/area/obtenerdetalle', 'AreaController@obtenerDetalle');
Route::get('/area/obtenerdetalle2', 'AreaController@obtenerDetalle2');