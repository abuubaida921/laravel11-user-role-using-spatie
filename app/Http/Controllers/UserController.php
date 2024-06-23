<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('role-permission.user.index',[
            'users'=> $users
        ]);
    }
    public function create(){
        $roles=Role::pluck('name','name')->all();
        return view('role-permission.user.create',[
            'roles'=>$roles
        ]);
    }
    public function store(Request $request){
        $request -> validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|string|min:8|max:50',
            'roles'=>'required'
        ]);
        $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status','User Created Successfully with roles');
    }
}
