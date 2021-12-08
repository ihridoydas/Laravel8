<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CrudController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API Practice 
Route::get('/user_api',[ApiController::class,'studentAPI']);

    //api crud table for practise

    //GET method
    //--> /crud_api is path name,  -->[CrudController is Conroller Class Name, --> GetCrudApi is Method name
Route::get('/getcrud_api',[CrudController::class,'GetCrudApi']);

    //POST Method 
Route::post('/postcrud_api',[CrudController::class,'PostCrudApi']);

    //PUT Method
Route::put('putcrud_api/{id}',[CrudController::class,'PutCrudApi']);
