<?php

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

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

Route::post('/subscribe/{topic}', [SubscriberController::class, 'createSubscription']);
Route::post('/publish/{topic}', [PublisherController::class, 'publishMessage']);