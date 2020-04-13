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

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::post('answer/give', 'Api\AnswersController@give');
Route::post('category/get', 'Api\CategoriesController@get');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::post('category/create', 'Api\CategoriesController@create');
    Route::post('category/delete', 'Api\CategoriesController@delete');
    Route::post('category/member', 'Api\CategoriesController@member');

    Route::post('category/allmember', 'Api\CategoriesController@allmember');
    Route::post('category/userrep', 'Api\CategoriesController@userrep');

    Route::post('user/get', 'Api\UsersController@get');
    Route::post('user/category', 'Api\UsersController@cat');
    Route::post('user/reputation', 'Api\UsersController@rep');
    Route::post('user/delete', 'Api\UsersController@delete');
    Route::post('user/informations', 'Api\UsersController@informations');
    Route::get('user/get_quest', 'Api\UsersController@quest');

    Route::post('question/get', 'Api\QuestionsController@get');
    Route::post('question/ask', 'Api\QuestionsController@ask');
    Route::post('question/delete', 'Api\QuestionsController@delete');

    Route::post('answer/delete', 'Api\AnswersController@delete');
    Route::post('answer/rate', 'Api\AnswersController@rate');
    Route::post('answer/get', 'Api\AnswersController@get');
});
