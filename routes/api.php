<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Api Register
 */

Route::post('/register', [RegisterController::class, 'register']);
/**
 * Api Login
 */
Route::post('/login', [LoginController::class, 'login']);
/**
 * APi Category
 */
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/categoryHome', [CategoryController::class, 'categoryHome']);
/**
 * Api Campaign
 */
Route::get('/campaign', [CampaignController::class, 'index']);
Route::get('/campaign/{slug}', [CampaignController::class, 'show']);
/**
 * Api Slider
 */
Route::get('/slider', [SliderController::class, 'index']);
/**
 * Api Profile
 */
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:api');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth:api');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('auth:api');
/**
 * Api Donation
 */
Route::get('/donation', [DonationController::class, 'index'])->middleware('auth:api');
Route::post('/donation', [DonationController::class, 'store'])->middleware('auth:api');
Route::post('/donation/notification', [DonationController::class, 'notificationHandler']);