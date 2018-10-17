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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/task-lists', 'TaskListController', [
    'except' => ['edit', 'show', 'store']
]);
Route::post('/task-lists/get-lists', 'TaskListController@getLists');


Route::resource('/task', 'TaskController', [
    'except' => ['create', 'edit', 'show', 'store']
]);
Route::post('/task/create', 'TaskController@create');
Route::post('/task/get-tasks', 'TaskController@getTasks');


Route::post('/share/create', 'ShareController@create');
Route::post('/share/delete', 'ShareController@delete');


Route::post('/user/upload-logo', 'UserController@upload');
Route::get('/user/get-logo', 'UserController@getLogo');