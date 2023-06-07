<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/users', [UserController::class, 'index']);
Route::post('/getUser', function(Request $request){
    // return $request;
    return User::find($request->id);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/master/permissions', [PermissionController::class, 'index']);
    Route::post('/master/permission/store', [PermissionController::class, 'store']);
    Route::post('/master/permission/update/{permission}', [PermissionController::class, 'update']); //> {permission} == id yan ng permission, need nyo ipadala pag nag axios kayo
    Route::post('/master/permission/delete/{permission}', [PermissionController::class, 'delete']); //> {permission} == id yan ng permission, need nyo ipadala pag nag axios kayo
    
    Route::get('/master/roles', [RoleController::class, 'index']);
    Route::post('/master/role/store', [RoleController::class, 'store']);
    Route::post('/master/role/update/{role}', [RoleController::class, 'update']); //> {role} == id yan ng role, need nyo ipadala pag nag axios kayo
    Route::post('/master/role/delete/{role}', [RoleController::class, 'delete']); //> {role} == id yan ng role, need nyo ipadala pag nag axios kayo

});