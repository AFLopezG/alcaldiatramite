<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'orden' => 'required',
            'nombre' => 'required',
            'formulario_id' => 'required',
            'proceso_id' => 'required',
        ]);

        $num=Adjunto::where('formulario_id',$request->formulario_id)->where('proceso_id',$request->proceso_id)->count() + 1;

        if ($request->hasFile('file')) {
            $file    = $request->file('file');
            $nombre  = $request->formulario_id."-".$request->proceso_id."-".$num.".".$file->getClientOriginalExtension();
            $ruta = 'adjunto';
            $file->storeAs($ruta, $nombre,'public');

            $adjunto= new Adjunto();
            $adjunto->ruta=$nombre;
            $adjunto->nombre=$request->nombre;
            $adjunto->orden=$request->orden;
            $adjunto->formulario_id=$request->formulario_id;
            $adjunto->proceso_id=$request->proceso_id;
            return $adjunto->save();
       
        }
        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function download($id)
    {
        $file = Adjunto::findOrFail($id);

        $path = storage_path("app/public/adjunto/{$file->ruta}");
        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }
            return response()->streamDownload(function() use ($path) {
                readfile($path);
            }, $file->ruta, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $file->ruta . '"'
            ]);

        
    }
}
