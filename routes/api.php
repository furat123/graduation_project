<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
Route::resource('/model',"App\Http\Controllers\ModelTblController"); 
Route::resource('/user_has_model',"App\Http\Controllers\UserHasModelController"); 
Route::resource('/file',"App\Http\Controllers\FilesController"); 

////////relation///////////
Route::get('/has-one', "App\Http\Controllers\Relation\RelationsController@HasOneRelation" );
Route::get('/has-one-reverse', "App\Http\Controllers\Relation\RelationsController@HasOneRelationReverse" );


