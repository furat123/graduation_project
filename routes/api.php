<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LabelController;
use App\Http\Middleware\AuthId;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//
//});
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
///// verify of file
Route::get('/verify_of_file/{id}', "App\Http\Controllers\Relation\RelationsController@getVerifyOfFile" );






//////// one to one relation  /////////// ----(has one to return the model which the user owner )
//===========has one reverse to return the owner of model
Route::get('/has-one/{id}', "App\Http\Controllers\Relation\RelationsController@HasOneRelation" );
Route::get('/has-one-reverse/{id}', "App\Http\Controllers\Relation\RelationsController@HasOneRelationReverse" );
Route::get('/a',function (){
    return "ahmad";
});


//////// one to many relation  ///////////
Route::get('/userhasmodel/{id}', "App\Http\Controllers\Relation\RelationsController@getFilesOfMdel" );
//Route::get('/label_of_model/{id}', "App\Http\Controllers\Relation\RelationsController@getLabelOfModel");


//////// many to many relation  ///////////
Route::get('/user_to_model/{id}', "App\Http\Controllers\Relation\RelationsController@getModelsOFUser" );
Route::get('/model_to_user/{id}', "App\Http\Controllers\Relation\RelationsController@getusersOFmodel" );

//public api
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);




//////////////// protected api
Route::group(['middleware' => ['auth:sanctum']],function (){

    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::get('/Muhannad', [LabelController::class, 'index'])
//    Route::get('/who', [AuthController::class, 'who']);
//    Route::post('/Muhannad', function () {
//        return "muhannad";
//    })->middleware(['AuthId']);
//    Route::post('/MuhannadAdmin', function () {
//        return "muhannadAdmin";
//    })->middleware(['AuthAdmin']);
    ///////////// Authentication///////////////


//////// AI Algorithim Apis  ///////////
    Route::post('/object_map_generation/{id}', "App\Http\Controllers\ModelTblController@csvs" );
    Route::get('/object_map_generation/{id}', "App\Http\Controllers\ModelTblController@get_csvs" );
    Route::post('/train/{id}', "App\Http\Controllers\ModelTblController@train" );
    Route::post('/predict/{id}', "App\Http\Controllers\ModelTblController@predict" );
    Route::get('/progress/{id}', "App\Http\Controllers\ModelTblController@getProgress" );
    Route::put('/progress/{id}', "App\Http\Controllers\ModelTblController@setProgress" );
    Route::get('/progress_op/{id}', "App\Http\Controllers\ModelTblController@getProgress_op" );
    Route::put('/progress_op/{id}', "App\Http\Controllers\ModelTblController@setProgress_op" );
    Route::post('/dataset/{id}', "App\Http\Controllers\ModelTblController@store_dataset" );
    Route::get('/dataset/{id}', "App\Http\Controllers\ModelTblController@get_dataset" )->middleware(['AuthId']);
    Route::delete('/dataset/{id}', "App\Http\Controllers\ModelTblController@delete_all_dataset");
    Route::post('/dataset/{id}', "App\Http\Controllers\ModelTblController@delete_from_dataset" );
    
    Route::post('/predict/{id}', "App\Http\Controllers\ModelTblController@store_predict" );
    Route::get('/predict/{id}', "App\Http\Controllers\ModelTblController@get_predict" );
    Route::delete('/predict/{id}', "App\Http\Controllers\ModelTblController@delete_all_predict");
    Route::post('/predict/{id}', "App\Http\Controllers\ModelTblController@delete_from_predict" );

    Route::post('/object_map_labeling/{id}', "App\Http\Controllers\ModelTblController@object_map_labeling" );
    Route::post('/text_form_box', "App\Http\Controllers\ModelTblController@text_form_box" );
    Route::get('/model/image/{id}', "App\Http\Controllers\ModelTblController@image" );

});

//Route::group(['middleware' => ['AuthId']],function (){
//
//});
//this relation to show the model which the user owns
Route::get('/furat/{id}', "App\Http\Controllers\Relation\RelationsController@ShowModelOfowner");
//this relation to show the model which the user use
Route::get('/fur/{id}', "App\Http\Controllers\Relation\RelationsController@ShowModelUsed");


