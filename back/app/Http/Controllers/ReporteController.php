<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Log;
use App\Models\Propietario;
use App\Models\User;
use App\Models\Tramite;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    //
    public function reporteDiaIng(Request $request){
            return DB::SELECT("SELECT f.codigo,t.nombre tramite,p.nombre,p.apellido
            FROM formularios f inner join logs l on f.id=l.formulario_id
            INNER join propietarios p on f.propietario_id=p.id
            inner join tramites t on t.id=f.tramite_id
            where l.fecha='$request->fecha' and l.user_id2=".$request->user()->id." 
            group by f.codigo,tramite,p.nombre,p.apellido
            order by t.nombre;");
    
         }
    
    public function reporteDiaDerv(Request $request){
    return DB::SELECT("SELECT f.codigo,t.nombre tramite,p.nombre,p.apellido
    FROM formularios f inner join logs l on f.id=l.formulario_id
    INNER join propietarios p on f.propietario_id=p.id
    inner join tramites t on t.id=f.tramite_id
    where l.fecha='$request->fecha' and l.user_id=".$request->user()->id." 
    group by f.codigo,tramite,p.nombre,p.apellido
    order by t.nombre;");
    }

    public function reporteFinalizado(Request $request){
        $user=User::with('units')->where('id',$request->user()->id)->first();
        $list=[];
        foreach ($user->units as $value) {
            # code...
            array_push($list,$value->id);
        }
        return DB::SELECT("SELECT f.codigo,t.nombre tramite,p.nombre,p.apellido
        FROM formularios f 
        INNER join propietarios p on f.propietario_id=p.id
        inner join tramites t on t.id=f.tramite_id
        where f.id in (select l2.formulario_id from logs l2 
                        where l2.fecha>='$request->ini' and l2.fecha<='$request->fin' and l2.estado='FINALIZADO' 
                        group by l2.formulario_id)
        and f.estado='FINALIZADO' 
        and f.unit_id in (select u.unit_id from users s inner join unit_user u on s.id=u.user_id where s.id=".$request->user()->id.")
        group by f.codigo,tramite,p.nombre,p.apellido
        order by t.nombre;");
     }

     public function reportAsig(Request $request){

        return DB::SELECT("SELECT count(*) cantidad, t.nombre tramite
        from formularios f inner join tramites t on f.tramite_id=t.id
        where f.fecha>='$request->fecha1' and f.fecha<='$request->fecha2'
        and f.unit_id in (select u.unit_id from users s inner join unit_user u on s.id=u.user_id where s.id=".$request->user()->id.")       
        group BY t.nombre;");
     }

     public function reportEstado(Request $request){

        //return $list;
        return DB::SELECT("SELECT t.nombre tramite,f.estado,count(*) cantidad
        from formularios f inner join tramites t on f.tramite_id=t.id
        where f.unit_id in (select u.unit_id from users s inner join unit_user u on s.id=u.user_id where s.id=".$request->user()->id.")
        and f.estado in ('EN PROCESO','RECTIFICAR')
        group by t.nombre,f.estado
        ");


       
     }
}
