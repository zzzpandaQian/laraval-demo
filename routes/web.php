<?php

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

// Route::get('/', function () {
//     return redirect('atadmin');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('single', 'HomeController@single')->name('single-page');

Route::get('/portfolio/{id}', 'HomeController@portfolio')->name('portfolio');
Route::post('/contact', 'ContactController@create')->name('contact.submit');
Route::get('/news', 'NewsController@index')->name('news');
Route::get('/news2', 'NewsController@index2')->name('news2');
Route::get('/news/{news_category_id}/list/', 'NewsController@list')->name('news.list');
Route::get('/news/{news_id}/detail/', 'NewsController@detail')->name('news.detail');
Route::get('/news/search', 'NewsController@search')->name('news.search');

Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');
Route::get('/portfolio/detail/{id}', 'PortfolioController@detail')->name('portfolio.detail');

Route::post('/contact', 'ContactController@create')->name('contact.submit');

Route::get('/page/{page}', 'PageController@index')->name('page');
Route::get('/message', 'PageController@message')->name('message');
Route::get('/faqs', 'FaqController@index')->name('faqs');

Route::get('login/password', 'LoginController@password')->name('login.password');
Route::any('login/verifycode_login', 'LoginController@verifycode_login')->name('login.verifycode_login');
Route::post('login/password', 'LoginController@password')->name('login.password');

Route::get('/about', function () {
    return view('web.about');
    // return redirect()->route('wechat');
})->name('about');

// 微信相关
Route::any('/weixin', 'WeChatController@serve');

// 测试环境跳过授权
if (config('app.env') == 'local') {
    Route::any('/wechat/{path?}', 'WeChatController@home')->where('path', '(.*)')->name('wechat');
} else {
    Route::group(['middleware' => ['wechat.oauth']], function () {
        Route::any('/wechat/{path?}', 'WeChatController@home')->where('path', '(.*)')->name('wechat');
        Route::get('/oauth_callback', 'WeChatController@oauthCallback')->name('wechat.oauth_callback');
    });
}

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('user', 'UserController@index')->name('user.index');
    Route::any('user/edit', 'UserController@edit')->name('user.edit');
    Route::any('user/password', 'UserController@password')->name('user.password');
});

Route::any('test', 'TestController@index');

Route::get('example', 'ExampleController@index')->name('example');
Route::get('example/email', 'ExampleController@email')->name('example.email');
Route::get('example/message', 'ExampleController@message')->name('example.message');
Route::get('example/modals', 'ExampleController@modals')->name('example.modals');
Route::get('example/sendsms', 'ExampleController@sendsms')->name('example.sendsms'); // 发送短信验证码
Route::get('example/guzzle', 'ExampleController@guzzle')->name('example.guzzle'); // 发送短信验证码
