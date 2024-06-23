<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('role-permission.user.index',[
            'users'=> $users
        ]);
    }
    public function create(){
        return view('role-permission.user.create');
    }
}
