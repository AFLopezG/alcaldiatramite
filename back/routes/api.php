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
        Route::apiResource('delegado', App\Http\Controllers\DelegadoController::class);

        Route::apiResource('cargo',\App\Http\Controllers\CargoController::class);
        Route::apiResource('tramite',\App\Http\Controllers\TramiteController::class);
        Route::apiResource('formulario',\App\Http\Controllers\FormularioController::class);
        Route::apiResource('log',\App\Http\Controllers\LogController::class);
        Route::apiResource('/profile',\App\Http\Controllers\ProfileController::class);
        Route::apiResource('/rectificado',\App\Http\Controllers\RectificadoController::class);
        Route::apiResource('/adjunto',\App\Http\Controllers\AdjuntoController::class);
        Route::post('/unitTramite',[\App\Http\Controllers\TramiteController::class,'unitTramite']); 
        Route::post('/listForm2',[\App\Http\Controllers\FormularioController::class,'listForm2']);
        
        Route::post('/micorreo',[\App\Http\Controllers\FormularioController::class,'micorreo']);
        Route::post('/searchProp',[\App\Http\Controllers\PropietarioController::class,'searchProp']);
        Route::post('/listuser',[\App\Http\Controllers\UserController::class,'listuser']);
        Route::post('/listuserUnit',[\App\Http\Controllers\UserController::class,'listuserUnit']);

        Route::post('/suspender',[\App\Http\Controllers\FormularioController::class,'suspender']);
        Route::post('/finalizar',[\App\Http\Controllers\FormularioController::class,'finalizar']);

        Route::post('/updateform',[\App\Http\Controllers\FormularioController::class,'updateform']);
        Route::post('/reporteDiaIng',[\App\Http\Controllers\ReporteController::class,'reporteDiaIng']);
        Route::post('/reporteDiaDerv',[\App\Http\Controllers\ReporteController::class,'reporteDiaDerv']);
        Route::post('/reporteFinalizado',[\App\Http\Controllers\ReporteController::class,'reporteFinalizado']);
        Route::post('/reportAsig',[\App\Http\Controllers\ReporteController::class,'reportAsig']);
        Route::post('/reportEstado',[\App\Http\Controllers\ReporteController::class,'reportEstado']);

        Route::post('/consulta2',[\App\Http\Controllers\FormularioController::class,'consulta2']);
        Route::post('/habilitar',[\App\Http\Controllers\FormularioController::class,'habilitar']);

        Route::post('/reportAnual1',[\App\Http\Controllers\FormularioController::class,'reportAnual1']);
        Route::post('/reportAnual2',[\App\Http\Controllers\FormularioController::class,'reportAnual2']);

        Route::get('/printReq/{id}',[\App\Http\Controllers\FormularioController::class,'printReq']);
        Route::get('/printRuta/{id}',[\App\Http\Controllers\FormularioController::class,'printRuta']); 
        Route::get('/listGestor',[\App\Http\Controllers\FormularioController::class,'listGestor']); 
        Route::post('/reasignar',[\App\Http\Controllers\LogController::class,'reasignar']); 
        
        Route::put('/upPerfilProc/{proceso}',[\App\Http\Controllers\ProcesoController::class,'upPerfilProc']);
        Route::post('/agregarRequisito',[\App\Http\Controllers\TramiteController::class,'agregarRequisito']); 
        Route::post('/retirarRequisito',[\App\Http\Controllers\TramiteController::class,'retirarRequisito']); 
        Route::post('/agregarProceso',[\App\Http\Controllers\TramiteController::class,'agregarProceso']); 
        Route::post('/retirarProceso',[\App\Http\Controllers\TramiteController::class,'retirarProceso']);  

        Route::post('/nextProc',[\App\Http\Controllers\TramiteController::class,'nextProc']); 
        Route::post('/rechazar',[\App\Http\Controllers\TramiteController::class,'rechazar']);

        Route::post('/upload',[\App\Http\Controllers\UploadController::class,'upload']); 
        Route::get('/download/{id}',[\App\Http\Controllers\UploadController::class,'download']); 
        Route::post('/listAdjunto',[\App\Http\Controllers\AdjuntoController::class,'listAdjunto']); 
         
        Route::post('/listTramite',[\App\Http\Controllers\FormularioController::class,'listTramite']); 
        Route::post('/listProcUser',[\App\Http\Controllers\TramiteController::class,'listProcUser']); 
        Route::post('/cambioUserProc',[\App\Http\Controllers\TramiteController::class,'cambioUserProc']); 
        
        
});
