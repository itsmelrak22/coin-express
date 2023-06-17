<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TradeOrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MarketTradeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentClientController;
use App\Http\Controllers\ExchangeHistoryController;

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
    
    Route::get('/master/admin/agents', [AdminController::class, 'GetAgents']);
    Route::get('/master/admin/admin_agents', [AdminController::class, 'getAdminAgents']);
    Route::post('/master/admin/user/store', [AdminController::class, 'store']);
    Route::post('/master/admin/user/update/{admin}', [AdminController::class, 'update']); //> {admin} == id yan ng admin, need nyo ipadala pag nag axios kayo
    Route::post('/master/admin/user/delete/{admin}', [AdminController::class, 'delete']); //> {admin} == id yan ng admin, need nyo ipadala pag nag axios kayo


    Route::get('/AccountInfo', [UserController::class, 'index']);
    Route::post('/user/update/{user}', [UserController::class, 'update']);
    Route::post('/user/update2/{user}', [UserController::class, 'update2']);
    Route::post('/user/update3/{user}', [UserController::class, 'update3']);
    Route::post('/adminprocess', [UserController::class, 'adminprocess']);

    Route::post('/Dashboard/store', [TradeOrderController::class, 'store']);
    Route::get('/TradeOrders', [TradeOrderController::class, 'index']);
    Route::put('/Dashboard/update', [TradeOrderController::class, 'update']);
    Route::get('/GetTID', [TradeOrderController::class, 'GetTID']);


    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/account/store', [AccountController::class, 'store']);
    Route::post('/account/update/{account}', [AccountController::class, 'update']);


    Route::get('/history', [ExchangeHistoryController::class, 'index']);
    Route::post('/history/store', [ExchangeHistoryController::class, 'store']);
    Route::put('/history/update', [ExchangeHistoryController::class, 'update']);

    Route::get('/market', [MarketTradeController::class, 'index']);
    Route::post('/market/store', [MarketTradeController::class, 'store']);
    Route::put('/market/update', [MarketTradeController::class, 'update']);

    Route::post('/calculateCount', [TradeOrderController::class, 'calculateCount']);
    // Route::get('/companies/show', [CompanyController::class, 'show']);
    // Route::get('/companies', [CompanyController::class, 'index']);
    // Route::post('/companies/store', [CompanyController::class, 'store']);
    // Route::post('/companies/update', [CompanyController::class, 'update']);
    // Route::get('/companies/deleted', [CompanyController::class, 'deleted']);
    // Route::post('/companies/restore', [CompanyController::class, 'restore']);
    // Route::post('/companies/destroy', [CompanyController::class, 'destroy']);

    Route::get('/RechargeDetails', [DepositController::class, 'index']);
    Route::post('/RechargeDetails/store', [DepositController::class, 'store']);
    Route::post('/RechargeDetails/update', [DepositController::class, 'update']);
    Route::post('/CancelOrder/update', [DepositController::class, 'CancelOrderClient']);
    //adminside
    Route::post('/RechargeDetails/update2', [DepositController::class, 'update2']);
    Route::get('/RechargeDetailsAdmin', [DepositController::class, 'RechargeDetailsAdmin']);
    Route::post('/CancelOrderAdmin/update', [DepositController::class, 'CancelOrderAdmin']);

    Route::get('/admin/{admin}/clients', [AgentClientController::class, 'index']);

});