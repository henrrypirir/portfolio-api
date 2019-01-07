<?php

use Illuminate\Http\Request;

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

Route::apiResource('developers', 'DeveloperController');
Route::put('developers/', 'DeveloperController@store');

Route::apiResource('projects', 'ProjectController');
Route::put('projects/', 'ProjectController@store');

Route::apiResource('skills', 'SkillController');
Route::put('skills', 'SkillController@store');

Route::get('/search', 'SearchController@filters');
Route::group(['prefix' => 'auth'], function()
{
  Route::post('login', 'AuthController@login');
  Route::post('signup', 'AuthController@signup');

  Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
  });
});