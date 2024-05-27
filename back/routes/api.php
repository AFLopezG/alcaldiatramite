<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('/consulta',[\App\Http\Controllers\FormularioController::class,'consulta']);
Route::post('/listForm',[\App\Http\Controllers\FormularioController::class,'listForm']);
Route::post('/consprop',[\App\Http\Controllers\FormularioController::class,'consprop']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        //return $request->user();

        Route::post('me', [App\Http\Controllers\UserController::class, 'me']);
        Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);
        Route::apiResource('user', App\Http\Controllers\UserController::class);
        Route::put('/updatePassword/{user}',[\App\Http\Controllers\UserController::class,'updatePassword']);
        Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
        Route::put('/updateperfil/{user}',[\App\Http\Controllers\UserController::class,'updateperfil']);
        Route::put('/updateunits/{user}',[\App\Http\Controllers\UserController::class,'updateunits']);
        Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
        Route::post('/cambioEstado/{id}',[\App\Http\Controllers\UserController::class,'cambioEstado']);

        Route::apiResource('permiso', App\Http\Controllers\PermisoController::class);
        Route::apiResource('cargo', App\Http\Controllers\CargoController::class);
        Route::apiResource('unit', App\Http\Controllers\UnitController::class);
        Route::apiResource('requisito', App\Http\Controllers\RequisitoController::class);
        Route::apiResource('proceso', App\Http\Controllers\ProcesoController::class);

        Route::resource('/cargo',\App\Http\Controllers\CargoController::class);
        Route::resource('/tramite',\App\Http\Controllers\TramiteController::class);
        Route::resource('/formulario',\App\Http\Controllers\FormularioController::class);
        Route::resource('/log',\App\Http\Controllers\LogController::class);
        Route::resource('/profile',\App\Http\Controllers\ProfileController::class);
        Route::post('/unitTramite',[\App\Http\Controllers\TramiteController::class,'unitTramite']); 
        Route::post('/listForm2',[\App\Http\Controllers\FormularioController::class,'listForm2']);
        

        Route::post('/micorreo',[\App\Http\Controllers\FormularioController::class,'micorreo']);
        Route::post('/searchProp',[\App\Http\Controllers\PropietarioController::class,'searchProp']);
        Route::post('/listuser',[\App\Http\Controllers\UserController::class,'listuser']);
        Route::post('/listuserUnit',[\App\Http\Controllers\UserController::class,'listuserUnit']);

        Route::post('/suspender',[\App\Http\Controllers\FormularioController::class,'suspender']);
        Route::post('/finalizar',[\App\Http\Controllers\FormularioController::class,'finalizar']);

        Route::post('/updateform',[\App\Http\Controllers\FormularioController::class,'updateform']);
        Route::post('/reporteDiaIng',[\App\Http\Controllers\FormularioController::class,'reporteDiaIng']);
        Route::post('/reporteDiaDerv',[\App\Http\Controllers\FormularioController::class,'reporteDiaDerv']);

        Route::post('/consulta2',[\App\Http\Controllers\FormularioController::class,'consulta2']);
        Route::post('/habilitar',[\App\Http\Controllers\FormularioController::class,'habilitar']);

        Route::post('/reportAsig',[\App\Http\Controllers\FormularioController::class,'reportAsig']);
        Route::post('/reportEstado',[\App\Http\Controllers\FormularioController::class,'reportEstado']);
        Route::post('/reporteFinalizado',[\App\Http\Controllers\FormularioController::class,'reporteFinalizado']);
        Route::post('/reportAnual1',[\App\Http\Controllers\FormularioController::class,'reportAnual1']);
        Route::post('/reportAnual2',[\App\Http\Controllers\FormularioController::class,'reportAnual2']);

        Route::get('/printReq/{id}',[\App\Http\Controllers\FormularioController::class,'printReq']);
        Route::get('/printRuta/{id}',[\App\Http\Controllers\FormularioController::class,'printRuta']); 
        Route::get('/listGestor',[\App\Http\Controllers\FormularioController::class,'listGestor']); 
        Route::post('/reasignar',[\App\Http\Controllers\LogController::class,'reasignar']); 
        
});
