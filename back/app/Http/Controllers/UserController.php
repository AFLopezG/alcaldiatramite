<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {
        //return $request;
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->whereDate('fechalimite','>=',date('Y-m-d'))->where('state','ACTIVO')->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user = User::with('permisos')->with('cargo')->with('units')->where('email', $request->email)->first();
                $token = $user->createToken('authToken')->plainTextToken;
                return response(['user' => $user, 'token' => $token]);
            } else {
                return response(['message' => 'Contraseña incorrecta'],500);
            }
        } else {
            return response(['message' => 'Usuario no encontrado'],500);
        }
    }

    public function me(Request $request)
    {
        $user=User::with('permisos')->with('cargo')->with('units')
                    ->where('id',$request->user()->id)
                    ->where('state','ACTIVO')
                    ->whereDate('fechalimite','>=',date('Y-m-d'))
                    ->firstOrFail();
                return $user;
        //return  $request->user();
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(['message' => 'Sesión cerrada']);
    }

    public function index(){
        return User::with('permisos')->with('cargo')->with('units')->where('id','<>',1)->get();
    }

    public function listuser(Request $request){

        if($request->user()->unit_id == 24)
            return User::with('permisos')->with('cargo')->with('units')->where('id','<>',1)->get();
        else
            return User::with('permisos')->with('cargo')->with('units')->where('id','<>',1)->get();
    }

    public function listUserUnit(Request $request){
        $listu=DB::SELECT("SELECT unit_id from unit_user where user_id=".$request->user()->id);

        //return User::with('cargo')->with('unit')->where('state','ACTIVO')->where('id','<>',1)->get();
        return User::with('cargo')->where('state','ACTIVO')->with('units')
        ->with(['units' => function ($query) use ($listu) {
            $query->whereIn('id', $listu);
        }])
        ->where('id','<>',1)->get();
    }

    public function cambioEstado($id){
        $user=User::find($id);
        if($user->state=='ACTIVO')
            $user->state='INACTIVO';
        else
            $user->state='ACTIVO';
        $user->save();
    }

    public function show(User $user){return $user;}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'fechalimite' => 'required',
            'cargo_id' => 'required',
        ]);
        
        $validated['password']=Hash::make($validated['password']);
        $user = User::create($validated);
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->attach($permiso);
        return($user);
        //return response(['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'cedula' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'fechalimite' => 'required',
            'cargo_id' => 'required'
            
        ]);
        $user->update($validated);
        return response(['user' => $user]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $request['password']=Hash::make($request['password']);
        $user->update($request->all());
    }

    public function updatepermisos(Request $request,User $user){
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->detach();
        $user->permisos()->attach($permiso);
    }

    public function updateunits(Request $request,User $user){
        $units= array();
        foreach ($request->units as $unit){
            if ($unit['estado']==true)
                $units[]=$unit['id'];
        }
        $unit = Unit::find($units);
        $user->units()->detach();
        $user->units()->attach($unit);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response(['message' => 'Usuario eliminado']);
    }
}
