<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regras = Role::all();
        return view('regras.index', ['regras' => $regras]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('regras.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        return redirect(route('role.index'));
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
        $regra = Role::where('id', $id)->first();
        return view('regras.editar', [
            'regra' => $regra
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
     
        $role = Role::where('id', $id)->first();
        $role->name = $request->name;
        $role->save();
        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::where('id', $id)->first();
        $role->delete();
        return redirect(route('role.index'));
    }

    public function permissions($role)
    {
       $regra = Role::where('id',$role)->first();
       $permissoes = Permission::all();
       foreach($permissoes as $permissao){
           //trazer as permissões do perfil
            if($regra->hasPermissionTo($permissao->name)){
                $permissao->can = true;
            }else{
                $permissao->can = false;
            }
       }
       return view('regras.permissoes',[
           'regra' => $regra,
           'permissoes' => $permissoes
       ]);
    }

    public function permissionsSync(Request $request, $role)
    {
        $permissionsRequest  = $request->except(['_token', '_method']);
        foreach($permissionsRequest as $key => $value){
            $permissoes[] = Permission::where('id', $key)->first();
        }
        
        $regra = Role::where('id', $role)->first();
        if(!empty($permissoes)){
            $regra->syncPermissions($permissoes); //caso existir informa um vetor de opções
        }else{
            $regra->syncPermissions($permissoes);//caso nao existir informa null
        }

        return redirect()->route('role.permissions', ['role' => $regra->id]);
    }
}
