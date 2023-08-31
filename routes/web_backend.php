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

	//quotes
	Route::get('quotes', 'QuoteController@index');
	Route::post('quotes/fetch', 'QuoteController@fetch');
	Route::get('quotes/add', 'QuoteController@create');
	Route::post('quotes/save', 'QuoteController@store');
	Route::get('quotes/view/{id}', 'QuoteController@show');
	Route::get('quotes/edit/{id}', 'QuoteController@edit');
	Route::post('quotes/update', 'QuoteController@update');
    Route::post('quotes/publish', 'QuoteController@updateStatus');

	// Logout
	Route::get('/logout', function () {
		session()->forget('data');
		return redirect('/webadmin');
	});
});
