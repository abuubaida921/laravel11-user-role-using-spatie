<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::all();
        return view('role-permission.permission.index',['permissions'=> $permissions]);
    }
    public function create(){
        return view('role-permission.permission.create');
    }
    public function store(Request $request){
        $request -> validate([
            'name'=> [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);
        Permission::create([
            'name'=> $request -> name,
        ]);
        return redirect('permissions')->with('status','Permission created successfully');
    }
    public function edit(Permission $permission){
        return view('role-permission.permission.edit',[
            'permission'=> $permission
        ]);
    }
    public function update(){
        return view('role-permission.permission.index');
    }
    public function destroy(){
        
    }
}
