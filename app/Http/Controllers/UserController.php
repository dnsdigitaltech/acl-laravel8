<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index',[
            'usuarios' => $usuarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::where('id', $id)->first();
        return view('usuarios.editar', [
            'usuario' => $usuario
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $usuario = User::where('id', $id)->first();
       $usuario->name = $request->name;
       $usuario->email = $request->email;
       if(!empty($request->password)){
            $usuario->password = bcrypt($request->password);
       }
       $usuario->save();
       return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('user.index');
    }

    public function roles($user)
    {
       $usuario = User::where('id',$user)->first();
       $regras = Role::all();
       foreach($regras as $regra){
           //trazer as regras do usuario
            if($usuario->hasRole($regra->name)){
                $regra->can = true;
            }else{
                $regra->can = false;
            }
       }
       return view('usuarios.regras',[
           'usuario' => $usuario,
           'regras' => $regras
       ]);
    }

    public function rolesSync(Request $request, $user)
    {
        $rolesRequest  = $request->except(['_token', '_method']);
        foreach($rolesRequest as $key => $value){
            $regras[] = Role::where('id', $key)->first();
        }
        $usuario = User::where('id', $user)->first();
        if(!empty($regras)){
            $usuario->syncRoles($regras); //caso existir informa um vetor de opções
        }else{
            $usuario->syncRoles(null);//caso nao existir informa null
        }

        return redirect()->route('user.roles', ['user' => $usuario->id]);
    }
}
