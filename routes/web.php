<?php

use Illuminate\Support\Facades\Route,
    App\Http\Controllers\GameController,
    App\Http\Controllers\LogController,
    App\Http\Controllers\WebhookController,
    App\Models\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//test
Route::get('/', [LogController::class, 'index']);
Route::get('/mapInfo', [GameController::class, 'map']);

Route::post('/webhook', [WebhookController::class, 'index']);

