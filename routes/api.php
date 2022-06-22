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



Route::namespace('Api\V1')->middleware('api.replaceNull')->group(function () {

    // 认证
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
        Route::post('register', 'AuthController@register');

        // 公众号授权回调
        Route::get('wechat/oauth', 'AuthController@wechatOauth');

        // 小程序登录，绑定手机号
        Route::post('mplogin', 'AuthController@mplogin');
        Route::post('bind_mobile_mp', 'AuthController@bindMobileMp');

        Route::get('jssdk', 'AuthController@jssdk')->name('jssdk');
        // 测试Token
    });
    Route::get('test', 'AuthController@test');

    // 发送验证码
    Route::post('sendsms', 'AuthController@sendSmsCode')->middleware(['sms_access_token']); // 发送短信验证码
    // 微信验证手机号
    Route::post('verify_code_wechat', 'AuthController@verifyCodeWechat')->middleware(['sms_access_token'])->name('verify_code_wechat');
    // 小程序验证短信验证码
    Route::post('verify_xcx', 'AuthController@verifyXcx')->middleware(['sms_access_token'])->name('verify_xcx');


    // 新闻
    Route::get('news', 'NewsController@index')->name('news');
    Route::get('news2', 'NewsController@index2')->name('news2');
    Route::get('news/category', 'NewsController@category')->name('news.category');
    Route::get('news/{id}/detail', 'NewsController@detail')->name('news.detail');

    Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');
    Route::get('/portfolio/{id}/detail', 'PortfolioController@detail')->name('portfolio.detail');

    Route::post('/contact', 'ContactController@create')->name('contact.submit');

    Route::get('slider', 'SliderController@index');

    // 静态页面
    Route::get('/page/{slug}', 'PageController@index')->name('page');
    Route::post('images', 'ImagesController@index')->name('images');
    Route::post('upload', 'FileController@index')->name('upload');
    Route::post('demo/form', 'DemoController@formData');

    // 前端请求头：x-requested-with:XMLHttpRequest
    Route::middleware('auth:api')->group(function () {
        Route::post('user/edit', 'UserController@edit');
        Route::get('user', 'UserController@index');
        //图片上传

    });
});

Route::namespace('Api\V2')->prefix('v2')->middleware('api.replaceNull')->group(function () {
    Route::get('news', 'NewsController@index')->name('news');
    Route::get('news2', 'NewsController@index2')->name('news2');
    Route::get('news/category', 'NewsController@category')->name('news.category');
    Route::get('news/show/{news}', 'NewsController@show')->name('news.show');
});
