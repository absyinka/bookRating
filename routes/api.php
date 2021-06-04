<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;

Route::group(['prefix' => 'book-rating/v1.0'], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('all-books', [BookController::class, 'showAllBooks']);

    Route::middleware('auth:api')->group(function () {

        //Endpoints for Authentication
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('user-profile', [AuthController::class, 'userProfile']);

        //Endpoints for books
        Route::get('book/{id}', [BookController::class, 'detail']);
        Route::post('book', [BookController::class, 'create']);
        Route::put('book/{id}', [BookController::class, 'update']);
        Route::delete('book/{id}', [BookController::class, 'delete']);

        //Endpoints for ratings
        Route::post('rating/{book}', [RatingController::class, 'create']);
        Route::put('rating/{book_id}/{id}', [RatingController::class, 'update']);
        Route::delete('rating/{book_id}/{id}', [RatingController::class, 'delete']);
    });
});
