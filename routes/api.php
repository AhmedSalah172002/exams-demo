<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [\App\Http\Controllers\UserController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::get('/exams/all', [\App\Http\Controllers\ExamController::class,'index']);

    Route::middleware(\App\Http\Middleware\CheckIsUser::class)->group(function () {
        Route::post('/enroll/exams', [\App\Http\Controllers\ExamController::class,'enroll'])->name('enroll');
        Route::post('/withdraw/exams', [\App\Http\Controllers\ExamController::class,'withdraw'])->name('withdraw');

        Route::get('/user/exams', [\App\Http\Controllers\ExamController::class,'userExams']);
    });

    Route::middleware(\App\Http\Middleware\CheckIsAdmin::class)->group(function () {
        Route::get('/admin', [\App\Http\Controllers\UserController::class, 'getUser']);
        Route::apiResource('exams', \App\Http\Controllers\ExamController::class);
    });

});
