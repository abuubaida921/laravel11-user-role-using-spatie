<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('permissions',PermissionController::class);
Route::get('permissions/{permissionId}/delete',[PermissionController::class,'destroy']);

Route::resource('roles',RoleController::class);
Route::get('roles/{roleId}/delete',[RoleController::class,'destroy']);
Route::get('roles/{roleId}/give-permissions',[RoleController::class,'givePermissionsToRole']);
Route::put('roles/{roleId}/give-permissions',[RoleController::class,'savePermissionsToRole']);

Route::resource('users',UserController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
