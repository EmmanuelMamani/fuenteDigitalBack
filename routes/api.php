<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\TransmitionController;
use App\Http\Controllers\SectionController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}/related', [PostController::class, 'relatedPosts']);

Route::get('/commercials', [CommercialController::class, 'index']);

Route::get('/transmitions', [TransmitionController::class, 'online']);

Route::get('/section/{id}/posts', [SectionController::class, 'Posts']);
Route::get('/sections', [SectionController::class, 'index']);
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
