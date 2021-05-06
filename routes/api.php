<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\LabelController;
use App\Http\Middleware\AuthId;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Exception\ConfigurationException;


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



//public api
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/verify/{token}', [AuthController::class,'verifyUser']);




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
///////////// Authentication////////////


//////// AI Algorithim Apis ///////////
    Route::post('/object_map_generation/{id}', "App\Http\Controllers\ModelTblController@csvs" );
    Route::get( '/object_map_generation/{id}', "App\Http\Controllers\ModelTblController@get_csvs" );
    Route::post('/train/{id}', "App\Http\Controllers\ModelTblController@train" );
    Route::post('/re_train/{id}', "App\Http\Controllers\ModelTblController@re_train" );
    Route::post('/predict/{id}', "App\Http\Controllers\ModelTblController@predict" );
    Route::post('/dataset/{id}', "App\Http\Controllers\ModelTblController@store_dataset" );
    Route::get( '/dataset/{id}', "App\Http\Controllers\ModelTblController@get_dataset" );
    Route::delete('/dataset/{id}', "App\Http\Controllers\ModelTblController@delete_all_dataset");
    Route::post('/datasetdel/{id}', "App\Http\Controllers\ModelTblController@delete_from_dataset" );

    Route::post('images/predict/{id}', "App\Http\Controllers\ModelTblController@store_predict" );
    Route::get('images/predict/{id}', "App\Http\Controllers\ModelTblController@get_predict" );
    Route::delete('images/predict/{id}', "App\Http\Controllers\ModelTblController@delete_all_predict");
    Route::post('images/predictdel/{id}', "App\Http\Controllers\ModelTblController@delete_from_predict" );

    Route::post('/object_map_labeling/{id}', "App\Http\Controllers\ModelTblController@object_map_labeling" );
    Route::post('/text_form_box', "App\Http\Controllers\ModelTblController@text_form_box" );
    Route::get('/model/image/{id}', "App\Http\Controllers\ModelTblController@image" );





    Route::resource('/model',"App\Http\Controllers\ModelTblController");

    Route::resource('/user_has_model',"App\Http\Controllers\UserHasModelController");
    Route::resource('/file',"App\Http\Controllers\FilesController");
    Route::resource('/model_state',"App\Http\Controllers\ModelStateController");
    Route::resource('/file_state',"App\Http\Controllers\FileStateController");
    Route::resource('/verify_state',"App\Http\Controllers\VerifyStateController");
    Route::resource('/train_file',"App\Http\Controllers\TrainingFileController");
    Route::resource('/train_state',"App\Http\Controllers\TrainingStateController");
    Route::resource('/label',"App\Http\Controllers\LabelController");
    Route::resource('/user' , UserController::class);
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


//this relation to show the model which the user owns
    Route::get('/show_model_user_owns/{id}', "App\Http\Controllers\Relation\RelationsController@ShowModelOfowner");
//this relation to show the model which the user use
    Route::get('/show_model_user_use/{id}', "App\Http\Controllers\Relation\RelationsController@ShowModelUsed");
//all models which the user own it or not
    Route::get('/All_Model/{id}', "App\Http\Controllers\Relation\RelationsController@getallmodel");

   

});
Route::post('/set_labels/{id}' , "App\Http\Controllers\FilesController@set_labels");
Route::get('/modelfile/labels/{id}' , "App\Http\Controllers\TrainingFileController@labels");
Route::post('/set_labels_model/{id}' , "App\Http\Controllers\TrainingFileController@set_labels");
Route::get('/vs/{id}' , "App\Http\Controllers\FilesController@vs");
Route::put('/vs/{id}' , "App\Http\Controllers\FilesController@update_vs");
Route::put('/update_state' , "App\Http\Controllers\FilesController@update_state");
Route::get('/progress/{id}', "App\Http\Controllers\ModelTblController@getProgress" );
Route::put('/progress/{id}', "App\Http\Controllers\ModelTblController@setProgress" );
Route::get('/progress_re/{id}', "App\Http\Controllers\ModelTblController@getProgress_re" );
Route::put('/progress_re/{id}', "App\Http\Controllers\ModelTblController@setProgress_re" );
Route::resource('/history_of_train',"App\Http\Controllers\HistoryOfTrainController");
//Route::group(['middleware' => ['AuthId']],function (){
//
//});

