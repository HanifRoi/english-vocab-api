<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VocabularyController;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//route untuk yang publik
Route::controller(AuthController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

//route untuk yang private atau wajib login
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(VocabularyController::class)->group(function(){
        Route::get('/vocabularies', 'index');
        Route::post('/vocabularies', 'store');
        Route::get('/vocabularies/{vocab}', 'show');
        Route::put('/vocabularies/{vocab}', 'update');
        Route::delete('/vocabularies/{vocab}', 'destroy');
    });
});

