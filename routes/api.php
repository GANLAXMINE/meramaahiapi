<?php

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

Route::post('forget-password', '\App\Http\Controllers\API\AuthController@forgetPassword');
Route::post('reset-password', '\App\Http\Controllers\API\AuthController@resetPassword');
Route::post('resend-otp', '\App\Http\Controllers\API\AuthController@resentOtp');

Route::group(['prefix' => 'user', 'namespace' => 'API'], function () {
    Route::post('register', 'AuthController@userRegister');
    Route::post('register/google', 'AuthController@userRegisterORLoginUsingGoogle');
    Route::post('register/apple', 'AuthController@userRegisterORLoginUsingApple');
    Route::post('register/fb', 'AuthController@userRegisterORLoginUsingFb');
    Route::post('login', 'AuthController@CustomerLogin');
    Route::post('send-otp', 'AuthController@sentOtp');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password-verify', 'AuthController@forgotPasswordVerify');
});


Route::group(['prefix' => 'user', 'middleware' => ['auth:api'], 'namespace' => 'API'], function () {
    Route::post('updateProfile', 'AuthController@customerUpdate');
    Route::get('getProfile', 'AuthController@getcustomerProfile');
    Route::post('users-list', 'CustomerController@listUsers');
    Route::post('user-detail', 'CustomerController@userDetail');
    Route::post('get-profile', 'CustomerController@userProfile');
    Route::post('edit-profile', 'CustomerController@editProfile');
    Route::post('delete-profile-image', 'CustomerController@deleteProfileImage');
    Route::post('user-detail', 'CustomerController@userDetails');
    Route::post('image-upload', 'CustomerController@imageUpload');
    Route::post('user-location', 'CustomerController@editLatLong');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api'], 'namespace' => 'API'], function () {
    Route::post('change-password', 'AuthController@changePassword');
});

Route::group(['middleware' => ['auth:api'], 'namespace' => 'API'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('deleteAccount', 'AuthController@deleteAccount');
});
