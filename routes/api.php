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
Route::resource('/model_state',"App\Http\Controllers\ModelStateController");
Route::resource('/file_state',"App\Http\Controllers\FileStateController");
Route::resource('/verify_state',"App\Http\Controllers\VerifyStateController");
Route::resource('/train_file',"App\Http\Controllers\TrainingFileController");
Route::resource('/train_state',"App\Http\Controllers\TrainingStateController");
Route::resource('/label',"App\Http\Controllers\LabelController");
///// state of model
Route::get('/state_of_model/{id}', "App\Http\Controllers\Relation\RelationsController@getStateOfModel" );
///// state of file
Route::get('/state_of_file/{id}', "App\Http\Controllers\Relation\RelationsController@getStateOfFile" );




//////// AI Algorithim Api  ///////////
Route::post('/object_map_generation/{id}', "App\Http\Controllers\ModelTblController@csvs" );
Route::post('/train/{id}', "App\Http\Controllers\ModelTblController@train" );
Route::post('/predict/{id}', "App\Http\Controllers\ModelTblController@predict" );
Route::post('/store_labeld_op/{id}', "App\Http\Controllers\ModelTblController@store_op" );
Route::get('/progress/{id}', "App\Http\Controllers\ModelTblController@getProgress" );
Route::post('/progress/{id}', "App\Http\Controllers\ModelTblController@setProgress" );
//////// one to one relation  ///////////
Route::get('/has-one', "App\Http\Controllers\Relation\RelationsController@HasOneRelation" );
Route::get('/has-one-reverse', "App\Http\Controllers\Relation\RelationsController@HasOneRelationReverse" );
Route::get('/a',function (){
    return "ahmad";
});


//////// one to many relation  ///////////
Route::get('/userhasmodel', "App\Http\Controllers\Relation\RelationsController@getFilesOfMdel" );

//////// many to many relation  ///////////
Route::get('/user_to_model/{id}', "App\Http\Controllers\Relation\RelationsController@getModelsOFUser" );
Route::get('/model_to_user/{id}', "App\Http\Controllers\Relation\RelationsController@getuserslOFmodel" );


//public api
Route::post('/Register', [AuthController::class, 'register']);
Route::post('/Login', [AuthController::class, 'login']);


// protected api
Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::get('/Muhannad', [Muhannad::class, 'index']);
    Route::post('/Logout', [AuthController::class, 'logout']);
    Route::get('/who', [AuthController::class, 'who']);
});



