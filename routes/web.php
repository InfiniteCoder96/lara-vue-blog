<?php

use Illuminate\Support\Facades\Route;

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

Route::post('app/create_tag', 'AdminController@addTag');
Route::get('app/get_tags', 'AdminController@getTags');
Route::put('app/edit_tag', 'AdminController@editTag');
Route::delete('app/delete_tag', 'AdminController@deleteTag');

Route::post('app/create_category', 'AdminController@addCategory');
Route::get('app/get_categories', 'AdminController@getCategories');
Route::put('app/edit_category', 'AdminController@editCategory');
Route::delete('app/delete_category', 'AdminController@deleteCategory');
Route::post('/app/upload_category_icon', 'AdminController@uploadCategoryImage');
Route::post('/app/delete_category_image', 'AdminController@deleteCategoryImage');

Route::get('/', function () {
    return view('welcome');
});

Route::any('{slug}', function(){
    return view('welcome');
});
