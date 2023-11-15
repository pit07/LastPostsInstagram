<?php

use App\Http\Controllers\InstagramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Pour tests Postman
Route::group([
    'prefix' => 'instagram'
], function ($router) {
    Route::get('getLastPosts', [InstagramController::class, 'getLastInstagramPosts']);
});

