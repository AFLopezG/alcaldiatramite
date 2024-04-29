<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Http\Requests\StoreFormularioRequest;
use App\Http\Requests\UpdateFormularioRequest;
use App\Models\Log;
use App\Models\Propietario;
use App\Models\User;
use App\Models\Tramite;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function consulta(Request $request){
        return Formulario::where('gestion',$request->gestion)
        ->where('numero',$request->numero)
        ->where('tramite_id',$request->tramite_id)
        ->where('oficina',$request->oficina)->whereNull('deleted_at')
        ->with('propietario')->with('tramite')->with('logs')->first();
     }

     public function consulta2(Request $request){
        return Formulario::where('gestion',$request->gestion)
        ->where('numero',$request->numero)
        ->where('tramite_id',$request->tramite_id)
        ->where('oficina',$request->oficina)->whereNull('deleted_at')
        ->with('propietario')->with('tramite')->with('logs')->get();
     }

     public function todos(Request $request)
     {
         $mailIds = Log::select('formulario_id')
         ->whereNull('deleted_at')->get();

         return Formulario::with('logs')
         ->whereIN('id',$mailIds)
         ->orwhere('numero','like','%'.$request->input('numero').'%')
         ->skip(0)->take(25)->get();
     }

     public function suspender(Request $request){

        $formulario = Formulario::find($request->id);
        $formulario->estado='SUSPENDIDO';
        $formulario->observacion=$request->observacion;
        $formulario->save();

        $log=Log::where('formulario_id',$request->id)->orderBy('id','desc')->first();
        $log->obs = $log->obs.'  '.$request->observacion;
        $log->save();
    }

    public function finalizar(Request $request){
        $formulario = Formulario::find($request->id);
        $formulario->estado='FINALIZADO';
        $formulario->observacion=$request->observacion;
        $formulario->save();
    }
    public function habilitar(Request $request){
        $formulario = Formulario::find($request->id);
        $formulario->estado='PROCESO';
        $formulario->habilita=$request->habilita;
        $formulario->save();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormularioRequest $request)
    {
        //
        $user=User::where('id',$request->user()->id)->with('cargo')->get();
        $unit=Unit::where('id',$request->user()->unit_id)->first();
        $tramite=Tramite::where('id',$request->tramite_id)->first();

        $comp=$request->propietario['complemento'];
        if($comp==null)
            $comp='';
        if(Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->count()==0)
            {
                $propietario=new Propietario;
                $propietario->cedula=$request->propietario['cedula'];
                $propietario->complemento=strtoupper($comp);
                $propietario->nombre=strtoupper($request->propietario['nombre']);
                $propietario->apellido=strtoupper($request->propietario['apellido']);
                $propietario->save();

            }
        else{
            $propietario=Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->first();
            $propietario->nombre=strtoupper($request->propietario['nombre']);
            $propietario->apellido=strtoupper($request->propietario['apellido']);
            $propietario->save();
        }

        if($request->numero == null){
            $gestion = date('Y'); 
            if(Formulario::where('unit_id',$request->user()->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count()>=0)
                $numero=1;
            else{
            $form = Formulario::where('unit_id',$request->user()->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count();
            $numero = $form->numero + 1; }            
        }
        else
        {
            $numero=$request->numero;
            $gestion = $request->gestion; 
        }

        if(Formulario::where('numero',$numero)->where('gestion',$gestion)->where('unit_id',$unit->id)->where('tramite_id',$request->tramite_id)->count()>0)
            return response(['message' => 'YA SE ENCUENTRA REGISTRADO'],500);

        $formulario=new Formulario();
        $formulario->numero=$numero;
        $formulario->gestion=$gestion;
        $formulario->codigo=$tramite->codigo.'-'.$unit->codigo.str_pad($request->numero, 6, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->codtram=str_pad($request->numero, 6, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->distrito=$request->distrito;
        $formulario->detalle=$request->detalle;
        $formulario->observacion=$request->observacion;
        $formulario->estado='PROCESO';

        $formulario->fecha=date('Y-m-d');
        $formulario->hora=date('H:i:s');
        $formulario->propietario_id=$propietario->id;
        $formulario->tramite_id=$request->tramite_id;
        $formulario->unit_id=$unit->id;
        $formulario->user_id=$request->user()->id;
        $formulario->cargo_id=$request->user()->cargo_id;
        $formulario->save();

        $log=new Log();
        $log->formulario_id=$formulario->id;
        $log->user_id=null;
        $log->user_id2=$request->user()->id;
        $log->cargo_id=$request->user()->cargo_id;
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->save();

        return $formulario;
    }

    public function updateform(Request $request)
    {

        $user=User::where('id',$request->user()->id)->with('cargo')->get();
        $unit=Unit::where('id',$request->user()->unit_id)->first();
        $tramite=Tramite::where('id',$request->tramite_id)->first();

        $comp=$request->propietario['complemento'];
        if($comp==null)
            $comp='';

        if(Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->count()==0)
            {
                $propietario=new Propietario;
                $propietario->cedula=$request->propietario['cedula'];
                $propietario->complemento=strtoupper($comp);
                $propietario->nombre=strtoupper($request->propietario['nombre']);
                $propietario->apellido=strtoupper($request->propietario['apellido']);
                $propietario->save();

            }
        else{
            $propietario=Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->first();
            $propietario->nombre=strtoupper($request->propietario['nombre']);
            $propietario->apellido=strtoupper($request->propietario['apellido']);
            $propietario->save();
        }

        $f1=Formulario::find($request->id);
        if($f1->numero==$request->numero && $f1->gestion==$request->gestion && $f1->tramite_id==$request->tramite_id){
            $numero = $request->numero;
            $gestion = $request->gestion; 
        }
            else{
                
        if($request->numero == null){
            $gestion = date('Y'); 
            if(Formulario::where('unit_id',$request->user()->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count()>=0)
                $numero=1;
            else{
            $form = Formulario::where('unit_id',$request->user()->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count();
            $numero = $form->numero + 1; }  
        }
        else
        {
            $numero=$request->numero;
            $gestion = $request->gestion; 
        }
        if(Formulario::where('numero',$numero)->where('gestion',$gestion)->where('unit_id',$unit->id)->where('tramite_id',$request->tramite_id)->count()>0)
        return response(['message' => 'YA SE ENCUENTRA REGISTRADO'],500);
    }

        $formulario=Formulario::find($request->id);
        $formulario->numero=$numero;
        $formulario->gestion=$gestion;
        $formulario->codigo=$tramite->codigo.'-'.$unit->codigo.str_pad($request->numero, 6, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->codtram=str_pad($request->numero, 6, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->distrito=$request->distrito;
        $formulario->detalle=$request->detalle;
        $formulario->observacion=$request->observacion;
        $formulario->estado='PROCESO';

        $formulario->fecha=date('Y-m-d');
        $formulario->hora=date('H:i:s');
        $formulario->propietario_id=$propietario->id;
        $formulario->tramite_id=$request->tramite_id;
        $formulario->unit_id=$unit->id;
        $formulario->user_id=$request->user()->id;
        $formulario->cargo_id=$request->user()->cargo_id;
        $formulario->save();

        return $formulario;
    }

    /**
     * Display the specified resource.
     */
    public function micorreo (Request $request)
    {

            $list=[];
            $paginate = 20;
            $searchdata=$request->search;
            switch($request->tipoasignacion){
                case 'proceso':
                    $listlog=DB::SELECT("SELECT max(id) id,formulario_id
                    from logs
                    where formulario_id in (SELECT l2.formulario_id from logs l2
                    inner join formularios f on f.id=l2.formulario_id
                    inner join propietarios p on p.id=f.propietario_id
                    where l2.user_id2=".$request->user()->id." and f.estado IN ('PROCESO') and f.deleted_at is null and f.unit_id = ".$request->user()->unit_id."
                    and (f.codtram like '%".$searchdata."%'  or p.apellido LIKE '%".$searchdata."%' or p.nombre LIKE '%".$searchdata."%'))
                    GROUP by formulario_id order by id desc");
                    break;
                case 'suspendido':
                    $listlog=DB::SELECT("SELECT max(id) id,formulario_id
                    from logs
                    where formulario_id in (SELECT l2.formulario_id from logs l2 inner join formularios f on f.id=l2.formulario_id
                    inner join propietarios p on p.id=f.propietario_id
                    where l2.user_id2=".$request->user()->id." and f.estado IN ('SUSPENDIDO') and f.deleted_at is null and f.unit_id = ".$request->user()->unit_id."
                    and (f.codtram like '%".$searchdata."%'  or p.apellido LIKE '%".$searchdata."%' or p.nombre LIKE '%".$searchdata."%'))
                    GROUP by formulario_id order by id desc");
                    break;
                case 'finalizado':
                    $listlog=DB::SELECT("SELECT max(id) id,formulario_id
                    from logs
                    where formulario_id in (SELECT l2.formulario_id from logs l2 inner join formularios f on f.id=l2.formulario_id
                    inner join propietarios p on p.id=f.propietario_id
                    where l2.user_id2=".$request->user()->id." and f.estado IN ('FINALIZADO') and f.deleted_at is null and f.unit_id = ".$request->user()->unit_id."
                    and (f.codtram like '%".$searchdata."%'  or p.apellido LIKE '%".$searchdata."%' or p.nombre LIKE '%".$searchdata."%'))
                    GROUP by formulario_id order by id desc");
                    break;
                case 'todo':
                $listlog=DB::SELECT("SELECT max(id) id,formulario_id
                from logs
                where formulario_id in (SELECT l2.formulario_id from logs l2
                inner join formularios f on f.id=l2.formulario_id
                inner join propietarios p on p.id=f.propietario_id
                where l2.user_id2=".$request->user()->id." and f.deleted_at is null and f.unit_id = ".$request->user()->unit_id."
                  and (f.codtram like '%".$searchdata."%'  or p.apellido LIKE '%".$searchdata."%' or p.nombre LIKE '%".$searchdata."%'))
                  GROUP by formulario_id order by id desc");
                break;
                default:
                $listlog=DB::SELECT("SELECT max(id) id,formulario_id
                from logs
                where formulario_id in (SELECT l2.formulario_id from logs l2
                inner join formularios f on f.id=l2.formulario_id
                inner join propietarios p on p.id=f.propietario_id
                where l2.user_id2=".$request->user()->id." and f.deleted_at is null
                  and (f.codtram like '%".$searchdata."%'  or p.apellido LIKE '%".$searchdata."%' or p.nombre LIKE '%".$searchdata."%'))
                  GROUP by formulario_id order by id desc");
                    break;
            }

           foreach ($listlog as $r) {
                    array_push($list,$r->id);
            }
            if($request->tipoasignacion=='proceso')
    {
        return Log::whereIn('id', $list)
        ->where('user_id2',$request->user()->id)
        ->with('user')
        ->with('user2')
        ->with('cargo')
        ->with(['formulario' => function ($query) {
                 $query->with('logs');
                 $query->with('tramite');
                 $query->with('propietario');
             }])
        ->whereNull('deleted_at')
        ->orderBy('id','desc')->paginate($paginate);
    }
    else{
            return Log::whereIn('id', $list)
            ->with('user')
            ->with('user2')
            ->with('cargo')
            ->with(['formulario' => function ($query) {
                     $query->with('logs');
                     $query->with('tramite');
                     $query->with('propietario');
                 }])
            ->whereNull('deleted_at')
            ->orderBy('id','desc')->paginate($paginate);
        }
    }

    public function cambioAsignado(Request $request){
        $form1 = Formulario:: find($request->id);
        $logult= Log::where('formulario_id',$form1->id)->max('id');
        $logult->user_id2=$request->user_id;
        $logult->save();
    }

    public function printReq($id){
        $cadena='';
        $formulario  = Formulario::find($id);
        $propietario=Propietario::find($formulario->propietario_id);
        $tramite=Tramite::where('id',$formulario->tramite_id)->with('requisitos')->first();
        if(sizeof($tramite->requisitos)<1)
            return '';
        else
            return Formulario::where('id',$id)->with('propietario')->with('tramite')->first();
        $detalle='';
        foreach ($tramite->requisitos as $r) {
            # code...
            $detalle.="<tr><td><input type='checkbox' class='largerCheckbox'/></td><td>".$r->detalle."</td></tr>";
        }
        $cadena="<html><style>
        .cuerpo{
            padding: 0px;
            margin: 0px;
            margin-left: 5px;
            border: 0px;}
        table{
                width:100%;
              }
              .titulo{
              text-align:center;
              font-weight:bold;
              }
         input.largerCheckbox {
                width: 40px;
                height: 40px;
            }
        </style>
        <body class='cuerpo'>
        <table><tr><td>
        <h3 class='titulo'>REQUISITOS TRAMITE:<br>
        ".$tramite->nombre."</h3>
        <div><b>CODIGO : </b> ".$formulario->codigo."</div>
        <div><b>CEDULA : </b> ".$propietario->cedula." ".$propietario->complemento."</div>
        <div><b>PROPIETARIO: </b>".$propietario->nombre." ".$propietario->apellido."</div><br>
        <table>".$detalle."</table> <br>
        <div><b>Observaciones: </b></div>
        </td>
        <td style='width:50%'></td>
        </tr>
        </table>
        </body>
        </html>";
        return $cadena;
    }
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulario $formulario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormularioRequest $request, Formulario $formulario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulario $formulario)
    {
        //
    }
}
