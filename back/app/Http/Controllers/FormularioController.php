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
use App\Models\Delegado;
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

    public function listTramite(Request $request){
        $units=$request->user()->units;
        $list=[];
        foreach ($units as $value) {
            # code...
            array_push($list,$value->id);
        }
        //return $list;
        return Formulario::with(['tramite','propietario','delegado','latestLog'])
        ->whereIn('unit_id',$list)
        ->whereDate('fecha','>=',$request->fecha)
        ->orderBy('id','desc')
        ->get();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormularioRequest $request)
    {
        //
        $user=User::where('id',$request->user()->id)->with('cargo')->get();
        $tramite=Tramite::where('id',$request->tramite_id)->first();
        $unit=Unit::where('id',$tramite->unit_id)->first();

        $proceso=DB::SELECT("SELECT pr.*,pt.orden from procesos pr inner join proceso_tramite pt on pr.id = pt.proceso_id 
        where pt.tramite_id=$tramite->id  and pt.orden=(SELECT min(orden) from proceso_tramite pt2 where pt2.tramite_id=pt.tramite_id)");

        if(sizeof($proceso)>0)
        {   $proceso2=$proceso[0];}
        else
        return response(['message' => 'ERROR DE PROCESO'],500);

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
                $propietario->celular=$request->propietario['celular'];
                $propietario->save();

            }
        else{
            $propietario=Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->first();
            $propietario->nombre=strtoupper($request->propietario['nombre']);
            $propietario->apellido=strtoupper($request->propietario['apellido']);
            $propietario->celular=$request->propietario['celular'];
            $propietario->save();
        }

        if($request->numero == null){
            $gestion = date('Y');
            $canTram=Formulario::where('unit_id',$tramite->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count(); 
            if( $canTram < 1)
                $numero=1;
            else{
                $numero = Formulario::where('unit_id',$tramite->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->max('numero') + 1; 
            }            
        }
        else
        {
            $numero=$request->numero;
            $gestion = $request->gestion; 
        }

        if(isset($request->delegado['cedula']) && isset($request->delegado['nombre'])){
            if(isset($request->delegado['id']))
            {
                $delegado=Delegado::find($request->delegado['id']);
                $delegado->cedula=$request->delegado['cedula'];
                $delegado->nombre=$request->delegado['nombre'];
                $delegado->celular=$request->delegado['celular'];
                $delegado->save();
            }
            else{
                $delegado= new Delegado();
                $delegado->cedula=$request->delegado['cedula'];
                $delegado->nombre=$request->delegado['nombre'];
                $delegado->celular=$request->delegado['celular'];
                $delegado->save();
            }
            $delegado_id=$delegado->id;
        }
        else{
            $delegado_id=null;
        }

        if(Formulario::where('numero',$numero)->where('gestion',$gestion)->where('unit_id',$tramite->unit_id)->where('tramite_id',$request->tramite_id)->count() > 0)
            return response(['message' => 'YA SE ENCUENTRA REGISTRADO'],500);

        $formulario=new Formulario();
        $formulario->numero=$numero;
        $formulario->gestion=$gestion;
        $formulario->codigo=$tramite->codigo.'-'.$unit->codigo.str_pad($request->numero, 6, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->codtram=str_pad($request->numero, 4, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->distrito=$request->distrito;

        $formulario->detalle=$request->detalle;
        $formulario->observacion=$request->observacion;
        $formulario->estado='EN PROCESO';

        $formulario->fecha=date('Y-m-d');
        $formulario->hora=date('H:i:s');
        $formulario->propietario_id=$propietario->id;
        $formulario->delegado_id=$delegado_id;
        $formulario->tramite_id=$request->tramite_id;
        $formulario->unit_id=$unit->id;
        $formulario->user_id=$request->user()->id;
        $formulario->save();

        $log=new Log();
        $log->formulario_id=$formulario->id;
        $log->user_id=null;
        $log->user_id2=$request->user()->id;
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->estado='EN PROCESO';
        $log->proceso_id=$proceso2->id;
        $log->orden=$proceso2->orden;
        $log->save();
        return $formulario;
    }

    public function updateform(Request $request)
    {

        $user=User::where('id',$request->user()->id)->with('cargo')->get();
        $tramite=Tramite::where('id',$request->tramite_id)->first();
        $unit=Unit::where('id',$tramite->unit_id)->first();

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
                $propietario->celular=$request->propietario['celular'];
                $propietario->save();

            }
        else{
            $propietario=Propietario::where('cedula',$request->propietario['cedula'])->where('complemento',$comp)->first();
            $propietario->nombre=strtoupper($request->propietario['nombre']);
            $propietario->apellido=strtoupper($request->propietario['apellido']);
            $propietario->celular=$request->propietario['celular'];
            $propietario->save();
        }

        if(isset($request->delegado['cedula']) && isset($request->delegado['nombre'])){
            if(isset($request->delegado['id']))
            {
                $delegado=Delegado::find($request->delegado['id']);
                $delegado->cedula=$request->delegado['cedula'];
                $delegado->nombre=$request->delegado['nombre'];
                $delegado->celular=$request->delegado['celular'];
                $delegado->save();
            }
            else{
                $delegado= new Delegado();
                $delegado->cedula=$request->delegado['cedula'];
                $delegado->nombre=$request->delegado['nombre'];
                $delegado->celular=$request->delegado['celular'];
                $delegado->save();
            }
            $delegado_id=$delegado->id;
        }
        else{
            $delegado_id=null;
        }

        
        $f1=Formulario::find($request->id);
        if($f1->numero==$request->numero && $f1->gestion==$request->gestion && $f1->tramite_id==$request->tramite_id){
            $numero = $request->numero;
            $gestion = $request->gestion; 
        }
            else{
                
        if($request->numero == null){
            $gestion = date('Y'); 
            if(Formulario::where('unit_id',$tramite->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->count()==0)
                $numero=1;
            else
            {
            $form = Formulario::where('unit_id',$tramite->unit_id)->where('gestion',$gestion)->where('tramite_id',$request->tramite_id)->max('numero');
            $numero = $form + 1; }  
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
        $formulario->codtram=str_pad($request->numero, 4, '0', STR_PAD_LEFT).'/'.substr($gestion,2,2);
        $formulario->distrito=$request->distrito;
        $formulario->detalle=$request->detalle;
        $formulario->estado='EN PROCESO';

        $formulario->fecha=date('Y-m-d');
        $formulario->hora=date('H:i:s');
        $formulario->propietario_id=$propietario->id;
        $formulario->tramite_id=$request->tramite_id;
        $formulario->delegado_id=$delegado_id;
        $formulario->unit_id=$unit->id;
        $formulario->user_id=$request->user()->id;
        $formulario->save();

        return $formulario;
    }

    /**
     * Display the specified resource.
     */
    public function micorreo (Request $request)
    {

            $user=$request->user()->id;
            $resultado='';
            switch($request->estado){
                case 'proceso':
                    $resultado=Formulario::with(['tramite','propietario','delegado','latestLog'])
                    ->whereHas('latestLog', function($query) use ($user) {
                        $query->where('user_id2', $user);
                    })->where('estado','EN PROCESO')
                    ->get();
                    break;
                case 'finalizado':
                    $resultado=Formulario::with(['tramite','propietario','delegado','latestLog'])
                    ->whereHas('latestLog', function($query) use ($user) {
                        $query->where('user_id2', $user);
                        $query->whereDate('fecha','<=',date('Y-m-d'));
                        $query->whereDate('fecha','>=',date('Y-m-d', strtotime('-180 days')));
                    })->where('estado','FINALIZADO')
                    ->get();
                    break;
                case 'cancelado':
                    $resultado=Formulario::with(['tramite','propietario','delegado','latestLog'])
                    ->whereHas('latestLog', function($query) use ($user) {
                        $query->where('user_id2', $user);
                        $query->whereDate('fecha','<=',date('Y-m-d'));
                        $query->whereDate('fecha','>=',date('Y-m-d', strtotime('-180 days')));
                    })->where('estado','CANCELADO')
                    ->get();
                    break;
                case 'rectificar':
                    $resultado=Formulario::with(['tramite','propietario','delegado','latestLog'])
                    ->whereHas('latestLog', function($query) use ($user) {
                        $query->where('user_id2', $user);
                    })->where('estado','RECTIFICAR')
                    ->get();
                    break;
                case 'todo':
                default:
                    $resultado=Formulario::with(['tramite','propietario','delegado','latestLog'])
                    ->whereHas('latestLog', function($query) use ($user) {
                        $query->where('user_id2', $user);
                    })->whereIn('estado',['EN PROCESO','RECTIFICAR'])
                    ->get();
                break;
            }
            return $resultado;
    }

    public function cambioAsignado(Request $request){
        $form1 = Formulario:: find($request->id);
        $logult= Log::where('formulario_id',$form1->id)->max('id');
        $logult->user_id2=$request->user_id;
        $logult->save();
    }

    public function listGestor(){
        return Formulario::select('gestorci', 'gestornom','gestorcel')->groupBy('gestorci', 'gestornom','gestorcel')->get();
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
        <div><b>CODIGO : </b> ".$formulario->codtram."</div>
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
    public function show($id)
    {
        //
        return json_encode(Formulario::with('rectificados')->with('tramite')->with('propietario')->with('delegado')->with('latestLog')->where('id',$id)->first());
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






     public function listForm(Request $request){
        $searchtext=$request->searchtext;
        $resul=DB::SELECT("SELECT f.id 
        from formularios f inner join tramites t on f.tramite_id=t.id inner join propietarios p on f.propietario_id=p.id
        where f.codigo like '%$searchtext%' or p.cedula like '%$searchtext%' or p.nombre like '%$searchtext%' or p.apellido like '%$searchtext%' limit 15; ");

        $list=[];
        foreach ($resul as $value) {
            # code...
            array_push($list,$value->id);
        }
        //return $resul;
        return Formulario::with('tramite')->with('propietario')->whereIn('id',$list)->get();
    
        


    } 
    
    public function listForm2(Request $request){

        return Formulario::where('gestion',$request->gestion)
        ->where('numero',$request->numero)
        ->where('tramite_id',$request->tramite_id)
        ->whereNull('deleted_at')
        ->with('propietario')->with('tramite')->get();
    }

    public function consprop(Request $request){
        //return $request;
        return Formulario::where('id',$request->id)
        ->whereNull('deleted_at')
        ->with('tramite')
        ->with('propietario')
        ->with(['logs'=> function($query2){
            $query2->orderBy('id','desc');
        }] )->first();
     }



    public function printRuta($id){
        $cadena='';
        $formulario  = Formulario::find($id);
        $propietario=Propietario::find($formulario->propietario_id);
        $tramite=Tramite::where('id',$formulario->tramite_id)->first();
        $unit = Unit::find($formulario->unit_id);
        $detalle='';
        for ($i=0; $i < 7; $i++) {
            # code...
            $detalle.=" <tr class='cajetin'><td style='border:1px solid; border-radius: 12px; vertical-align: text-top; '><div class='casilla'></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINATARIO: <div style='font-size:12px; text-align:right; left: -100px; position:relative'>FECHA RECIBIDO</div>
            <div style='font-size:10px; text-align:right; left: -220px; top:50px; position:relative'>FIRMA Y SELLO</div></td></tr>";
        }
        $cadena="<html><style>
        .cuerpo{
            padding: 0px 0px 0px 100px;
            margin: 0px 0px 0px 100px;
            border: 0px;

        }
        .table1{
                width:100%;
                border-collapse: collapse;
              }

              .table2{
                width:100%;
                border-collapse: inherit;
                border-spacing: 0 10px;
              }

              .titulo{
              text-align:center;
              font-weight:bold;
              }
        .table2 ,tr ,td{
            boder: 1px solid;
        }
            .casilla{ border: 1px solid; border-radius: 50%; width:30px;height:30px;position: absolute;
            top:-5px; left: -5px; background-color: white;}
            .cajetin{
                  height:100px; position: relative;padding-bottom:30px;}

        </style>
        <body class='cuerpo'> <div style='margin: 0 0 0 15px;'>
        <div class='titulo'>GOBIERNO AUTONOMO MUNICIPAL DE ORURO</div>
        <div class='titulo'>".$unit->nombre."</div>
        <br>
        <table class='table1'><tr><td style='width:50%;' class='titulo'>HOJA DE RUTA<br><span style='text-size:8px;'>Uso interno</span></td><td ><b>CODIGO:</b></td><td style='border: 1px solid; text-align:center; font-size: 24px;'>".$formulario->codigo."</td></tr></table>
        <br>
        <table class='table1'>
        <tr><td><b>NOMBRE: </b></td><td>".$propietario->nombre." ".$propietario->apellido."</td><td rowspan='2' style='text-align:center;border: 1px solid'><b>FECHA INGRESO:</b><br>".$formulario->fecha."</td></tr>
        <tr><td><b>TRAMITE</b></td><td>".$tramite->nombre."</td></tr></table>
        <br><table class='table2' >
                ".$detalle."
        </table>

        </div>
        </body>
        </html>";
        return $cadena;
    }
}
