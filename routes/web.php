<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//For Crud Applicaion

Route::get('/crud',[CrudController::class,'showData']);
Route::get('/crud/add_data',[CrudController::class,'addData']);
Route::post('/crud/store_data',[CrudController::class,'storeData']);

//Edit Action
Route::get('/crud/edit_data/{id}',[CrudController::class,'editData']);
Route::post('/crud/update_data/{id}',[CrudController::class,'updateData']);
Route::get('/crud/delete_data/{id}',[CrudController::class,'deleteData']);


//End Crud Application

//Social Login System

//Route::get('/social',[SocialControler::class,'FacebookData']);