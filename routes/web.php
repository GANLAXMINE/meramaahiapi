<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect('admin/login');
});
Route::get('/login', '\App\Http\Controllers\Auth\LoginController@showAdminLoginForm')->name('admin.login')->middleware('guest:admin');
Route::get('admin/login', '\App\Http\Controllers\Auth\LoginController@showAdminLoginForm')->name('admin.login')->middleware('guest:admin');
Route::post('admin/login', '\App\Http\Controllers\Auth\LoginController@adminLogin')->name('admin.login')->middleware('guest:admin');
Route::post('admin/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('admin.logout');
// ['auth:admin']

Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('successResetPassword', [ForgotPasswordController::class, 'successResetPassword'])->name('reset.successResetPassword.get');

Route::resource('admin/configuration', '\App\Http\Controllers\Admin\ConfigController');
Route::get('admin/configuration', '\App\Http\Controllers\Admin\ConfigController@customEdit')->name('admin.configuration');
Route::resource('admin/faq', '\App\Http\Controllers\Admin\FaqController');

Route::group(['prefix' => 'admin', 'middleware' => 'admin_auth', 'namespace' => '', 'roles' => 'admin'], function () {
    Route::get('/', '\App\Http\Controllers\Admin\AdminController@index');
    Route::get('/dashboard', '\App\Http\Controllers\Admin\AdminController@index');
    Route::get('/home', '\App\Http\Controllers\Admin\AdminController@index');
    Route::resource('users', '\App\Http\Controllers\Admin\UsersController');
    Route::get('user/list', '\App\Http\Controllers\Admin\UsersController@index')->name('admin.user.list');
    Route::get('user/question_answer/{id}', '\App\Http\Controllers\Admin\UsersController@question_answer');
    Route::get('user/date_question_answer/{id}', '\App\Http\Controllers\Admin\UsersController@date_question_answer');
    Route::get('user/create', '\App\Http\Controllers\Admin\UsersController@create');
    Route::post('users/change', '\App\Http\Controllers\Admin\UsersController@changeStatus')->name('user.changeStatus');
    Route::post('send-notification', '\App\Http\Controllers\Admin\UsersController@SendNotification')->name('user.notification');
    Route::post('block-status', '\App\Http\Controllers\Admin\UsersController@updateStatus')->name('block.Status');

    Route::resource('match', '\App\Http\Controllers\Admin\UserMatchController');
    Route::resource('survey_questions', '\App\Http\Controllers\Admin\UserSurveyQuestionController');
    Route::resource('personalities', '\App\Http\Controllers\Admin\PersonalityController');
    Route::resource('coupons', '\App\Http\Controllers\Admin\CouponController');
    Route::resource('reports', '\App\Http\Controllers\Admin\ReportController');
    Route::resource('date-expectations', '\App\Http\Controllers\Admin\DateSurveyExpectionsController');
    Route::post('change-status', '\App\Http\Controllers\Admin\CouponController@updateStatus')->name('coupon.Status');
    // routes/web.php
    Route::get('user-chats', '\App\Http\Controllers\Admin\UserChatController@index')->name('admin.user_chats.index');
    Route::get('user-chats/{receiverId}/{senderId}', '\App\Http\Controllers\Admin\UserChatController@inBetweenChats');
    Route::resource('ghost/thermometer', '\App\Http\Controllers\Admin\GhostThermometerController');
    Route::get('ghost/thermometer/{receiverId}/{userId}', '\App\Http\Controllers\Admin\GhostThermometerController@showUserGhostMeter');

    Route::get('notification/form', '\App\Http\Controllers\Admin\UsersController@create');
    Route::post('send/notifications', '\App\Http\Controllers\Admin\UsersController@store')->name('notifications.send');
});
