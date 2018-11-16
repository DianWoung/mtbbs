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
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;

Route::get('/',function (){
  return redirect()->route('topics.index');
});

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('topics','TopicsController');
Route::resource('users','UsersController', ['only' => ['show', 'update', 'edit']]);
Route::resource('categories','CategoriesController', ['only' => ['show']]);
Route::resource('replies','RepliesController', ['only'=>['store','destroy']]);
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
Route::post('upload_image', 'TopicsController@uploadImage');

Route::get('search','TopicsController@searching')->name('search');
//关注模块
Route::get('follow/user', 'UsersController@follow');
Route::get('unfollow/user', 'UsersController@unfollow');

Route::get('users/{id}/followers', function ($id){
    $users = new UsersController();
   return $users->followers($id, 'followers');
})->name('users.followers');

Route::get('users/{id}/following', function ($id){
    $users = new UsersController();
    return $users->followers($id, 'following');
})->name('users.following');
//点赞模块
Route::get('users/{uid}/topics/{tid}/favor', function ($uid, $tid){
    $topic = new TopicsController();
    return $topic->favor($tid, $uid);
});

Route::get('users/{uid}/topics/{tid}/unfavor', function ($uid, $tid){
    $topic = new TopicsController();
    return $topic->unfavor($tid, $uid);
});

Route::get('/topics/{id}/favors', function ($id){
    $topic = new TopicsController();
    return $topic->getFavors($id);
});
Route::group(['as' => 'admin::','prefix' => 'admin', 'middleware' => ['auth', 'check-admin']],function ($router){
    $router->get('home', 'Admin\DashBoardController@home')->name('home');
    $router->resource('users', 'Admin\UsersController');
    $router->post('users/{id}/setadmin', 'Admin\UsersController@setAdmin')->name('users.set-admin');
    $router->post('users/{id}/unsetadmin', 'Admin\UsersController@unsetAdmin')->name('users.unset-admin');

    $router->resource('topics', 'Admin\TopicsController');
    $router->post('topics/{id}/setsticky', 'Admin\TopicsController@setSticky')->name('topics.set-sticky');
    $router->post('topics/{id}/unsetsticky', 'Admin\TopicsController@unsetSticky')->name('topics.unset-sticky');
});

