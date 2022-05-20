<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Responsable_filiere_controller;
use App\Http\Controllers\API\FiliereController;
use App\Http\Controllers\API\ModuleController;
use App\Http\Controllers\API\ElementModuleController;
use App\Http\Controllers\API\EleveController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\API\MoyenneController;

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
Route::post('login' , [AuthController::class , 'login' ]);

Route::middleware(['auth:sanctum'])->group(function (){
    //Eleve =================================
    Route::get('CheckEleveAuth' , function (){
        return response()->Json(["message" => "You are in" , "status" => 200] , 200);
    });
    Route::post('logout' , [AuthController::class , 'logout' ]);
    //responsable de filiere=========================
    Route::middleware('isApiRespo')->group(function (){
        Route::get('CheckRespoAuth' , function (){
            return response()->Json(["message" => "You are in" , "status" => 200] , 200);
        });
        Route::post('register' , [AuthController::class , 'register' ]);
        Route::get('index' , [AuthController::class , 'index' ]);
        Route::get('getLastId' , [AuthController::class , 'getLastId' ]);

        Route::delete('destroy/{id}' , [AuthController::class , 'destroy']);
        //Admin===========================================
        Route::middleware('isApiAdmin')->group(function (){
            Route::get('CheckAdminAuth' , function (){
                return response()->Json(["message" => "You are in" , "status" => 200] , 200);
            });

            //CRUD Responsable filiere
            Route::post('store_respo', [Responsable_filiere_controller::class , 'store']);
            Route::delete('destroy_respo/{id}', [Responsable_filiere_controller::class , 'destroy']);
            Route::get('edit_respo/{id}', [Responsable_filiere_controller::class , 'edit']);
            Route::put('update_respo/{id}', [Responsable_filiere_controller::class , 'update']);
            Route::get('index_respo', [Responsable_filiere_controller::class , 'index']);

            //CRUD Filiere 
            Route::post('store_filiere', [FiliereController::class , 'store']);
            Route::delete('destroy_filiere/{id}', [FiliereController::class , 'destroy']);
            Route::get('edit_filiere/{id}', [FiliereController::class , 'edit']);
            Route::put('update_filiere/{id}', [FiliereController::class , 'update']);
            Route::get('index_filiere', [FiliereController::class , 'index']);

            //CRUD Module
            Route::post('store_module', [ModuleController::class , 'store']);
            Route::delete('destroy_module/{id}', [ModuleController::class , 'destroy']);
            Route::get('edit_module/{id}', [ModuleController::class , 'edit']);
            Route::put('update_module/{id}', [ModuleController::class , 'update']);
            Route::get('index_module', [ModuleController::class , 'index']);

            //CRUD Element Module
            Route::post('store_element', [ElementModuleController::class , 'store']);
            Route::delete('destroy_element/{id}', [ElementModuleController::class , 'destroy']);
            Route::get('edit_element/{id}', [ElementModuleController::class , 'edit']);
            Route::put('update_element/{id}', [ElementModuleController::class , 'update']);
            Route::get('index_element', [ElementModuleController::class , 'index']);

            //CRUD Eleve 
            Route::post('store_eleve', [EleveController::class , 'store']);
            Route::delete('destroy_eleve/{id}', [EleveController::class , 'destroy']);
            Route::get('edit_eleve/{id}', [EleveController::class , 'edit']);
            Route::put('update_eleve/{id}', [EleveController::class , 'update']);
            Route::get('index_eleve', [EleveController::class , 'index']);

            //CRUD Note 
            Route::post('store_note', [NoteController::class , 'store']);
            Route::delete('destroy_note/{id}', [NoteController::class , 'destroy']);
            Route::get('edit_note/{id}', [NoteController::class , 'edit']);
            Route::put('update_note/{id}', [NoteController::class , 'update']);
            Route::get('index_note', [NoteController::class , 'index']);

            //CRUD Moyenne 
            Route::post('store_moyenne', [MoyenneController::class , 'store']);
            Route::delete('destroy_moyenne/{id}', [MoyenneController::class , 'destroy']);
            Route::get('edit_moyenne/{id}', [MoyenneController::class , 'edit']);
            Route::put('update_moyenne/{id}', [MoyenneController::class , 'update']);
            Route::get('index_moyenne', [MoyenneController::class , 'index']);
        });
    });
    

});



