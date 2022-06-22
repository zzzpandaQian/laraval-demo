<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');

    $router->any('users/import', 'UsersController@import')->name('users.import');
    $router->resource('users', 'UsersController');

    $router->any('news/import', 'NewsController@import')->name('news.import');
    $router->get('news/export', 'NewsController@export')->name('news.export');
    $router->resource('news', 'NewsController');
    $router->resource('news-categories', 'NewsCategoryController');
    $router->any('newstags/restore', 'NewsTagController@restore')->name('newstags.restore');
    $router->resource('newstags', 'NewsTagController');

    $router->get('contacts/export', 'ContactController@export')->name('contacts.export');
    $router->resource('contacts', 'ContactController');
    $router->resource('sliders', 'SliderController');
    $router->resource('pages', 'PageController');
    $router->resource('templates', 'TemplateController');
    $router->resource('portfolios', 'PortfolioController');
    $router->get('project/introduction', 'ProjectController@portfolioIntroduction')->name('project.introduction');
    $router->resource('project', 'ProjectController');
    $router->resource('sms', 'LaravelSmsController');
    $router->resource('seo-items', 'SeoItemController');
    $router->resource('partners', 'PartnerController');
    $router->resource('faqs', 'FaqController');
    $router->resource('area', 'AreaController');
    $router->resource('dealers', 'DealersController');
    $router->resource('demos', DemoController::class);
    $router->get('city', 'DemoController@city')->name('city');
});

