<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/***  Controller   *****/
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DefaultController;
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

Route::group(['namespace' => 'Api'], function () {
    
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login',[AuthController::class ,'login']);
        Route::post('login-otp',[AuthController::class ,'loginOtp']);
        Route::post('signup',[AuthController::class ,'signup']);
		Route::any('send-notification',[AuthController::class ,'sendNotification']);
        Route::post('user-signup',[AuthController::class ,'userSignup']);
       
	   Route::post('resend_activation_link',[AuthController::class,'resend_activation_link']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('social-login', 'AuthController@socialLoginSignup');
        Route::post('verifyemail/{token}', 'AuthController@verifyemail');
        Route::post('verifyMobileNumber', 'AuthController@verifyMobileNumber');
        Route::post('verifyMobileOtp', 'AuthController@verifyMobileOtp');
    });
    Route::middleware('auth:api')->group(function(){
        // log a test
		Route::post('log-test', [UserController::class,'logTest']);
		Route::post('log-test2', [UserController::class,'logTest2']);
		Route::post('log-test-result', [UserController::class,'logTestResult']);
		Route::post('get-test-by-id', [UserController::class,'getTestById']);
		Route::post('get-test-list', [UserController::class,'getTestList']);
		Route::post('save-device-token', [UserController::class,'saveDeviceToken']);
		// excel download
		Route::any('/sendTestResultMail',[UserController::class,'sendTestResultMail']);
		// excel download
		Route::any('/shareTestResultMail',[UserController::class,'shareTestResultMail']);
		Route::any('/testMultipleDelete',[UserController::class,'testMultipleDelete']);
		//profile
        Route::post('my-profile', [UserController::class,'myProfile']);
		Route::post('change-profile-setting', [UserController::class,'changeProfileSetting']);
        Route::post('edit-profile', [UserController::class,'editProfile']);
        Route::post('change-password', [UserController::class, 'changePassword']);
        Route::post('change-password-login', [UserController::class, 'changePasswordLogin']);
		//logout
        Route::post('logout', [UserController::class, 'logout']);
    });
    
});