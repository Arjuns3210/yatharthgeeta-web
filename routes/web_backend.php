<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login
Route::get('/', 'LoginController@index');
Route::post('login', 'LoginController@login');

Route::group(['middleware' => ['customAuth']], function () {
	// Dashboard
	Route::get('dashboard', 'DashboardController@index');

	// Category
	Route::get('books_category', 'BookCategoryController@index');
	Route::get('books_category/add', 'BookCategoryController@create');
	Route::post('books_category/fetch', 'BookCategoryController@fetch');
	Route::post('books_category/save', 'BookCategoryController@store');
	Route::get('books_category/edit/{id}', 'BookCategoryController@edit');
	Route::post('books_category/update', 'BookCategoryController@update');
	Route::get('books_category/view/{id}', 'BookCategoryController@show');

    //Banner
    Route::get('banners', 'BannerController@index');
    Route::post('banners/fetch', 'BannerController@fetch');
    Route::get('banners/add', 'BannerController@create');
    Route::post('banners/save', 'BannerController@store');
    Route::post('banners/publish', 'BannerController@updateStatus');
    Route::get('banners/view/{id}', 'BannerController@view');

	//staff
	Route::get('staff', 'StaffController@index');
	Route::post('staff/fetch', 'StaffController@fetch')->name('staff_fetch');
	Route::get('staff/add', 'StaffController@add');
	Route::post('staff/save', 'StaffController@store');
	Route::get('staff/edit/{id}', 'StaffController@edit');
	Route::post('staff/update', 'StaffController@update');
	Route::post('publish_staff', 'StaffController@updateStatus');
	Route::get('staff/view/{id}', 'StaffController@view');

	//manage role
	Route::get('roles', 'RoleController@roles');
	Route::post('role_data', 'RoleController@roleData')->name('role_data');
	Route::get('role_permission/{id}', 'RoleController@assignRolePermission');
	Route::post('publish_permission', 'RoleController@publishPermission');

	// Logout
	Route::get('/logout', function () {
		session()->forget('data');
		return redirect('/webadmin');
	});
});
