<?php

use App\Http\Middleware\InertiaToApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(InertiaToApiResponse::class)->group(function () {
   Route::apiResource('posts', \App\Http\Controllers\PostController::class);
});
