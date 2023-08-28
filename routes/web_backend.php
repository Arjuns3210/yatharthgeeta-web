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

	//staff
	Route::get('staff', 'StaffController@index');
	Route::post('staff_data', 'StaffController@fetch')->name('staff_data');
	Route::get('staff_add', 'StaffController@add');
	Route::post('save_staff', 'StaffController@store');
	Route::get('staff_edit/{id}', 'StaffController@edit');
	Route::post('staff_update', 'StaffController@update');
	Route::post('publish_staff', 'StaffController@updateStatus');
	Route::get('staff_view/{id}', 'StaffController@view');

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
