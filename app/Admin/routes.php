<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', UsersController::class);
    $router->resource('topics', TopicsController::class);
    $router->resource('links', LinksController::class);
    $router->resource('replies', RepliesController::class);
    $router->resource('categories', CategoriesController::class);
});