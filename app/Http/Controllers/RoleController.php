<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            // 'role_or_permission:manager|edit articles',
            // new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
            // new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only: ['destroy']),
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:create role', only: ['create', 'store']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }
    public function index()
    {
        $roles = Role::all();
        return view('role-permission.role.index', ['roles' => $roles]);
    }
    public function create()
    {
        return view('role-permission.role.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);
        Role::create([
            'name' => $request->name,
        ]);
        return redirect('roles')->with('status', 'Role created successfully');
    }
    public function edit(Role $role)
    {
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);
        $role->update([
            'name' => $request->name,
        ]);
        return redirect('roles')->with('status', 'Role updated successfully');
    }
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status', 'Role deleted successfully');
    }
    public function givePermissionsToRole($roleId)
    {
        $permissions = Permission::all();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.role.give-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }
    public function savePermissionsToRole(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => [
                'required'
            ]
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('status', 'Permission updated successfully');
    }
}
