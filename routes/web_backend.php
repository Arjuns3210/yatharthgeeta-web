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

	//Ashram
	Route::get('ashram', 'AshramController@index');
	Route::get('ashram/add', 'AshramController@create');
	Route::get('ashram/edit/{id}', 'AshramController@edit');
	Route::post('ashram/update', 'AshramController@update');
	Route::post('ashram/fetch', 'AshramController@fetch');
	Route::get('ashram/view/{id}', 'AshramController@show');
	Route::post('ashram/save', 'AshramController@store');

	//Guru's
	Route::get('guru', 'GuruController@index');
	Route::get('guru/add', 'GuruController@create');
	Route::get('guru/edit/{id}', 'GuruController@edit');
	Route::post('guru/update', 'GuruController@update');
	Route::post('guru/fetch', 'GuruController@fetch');
	Route::get('guru/view/{id}', 'GuruController@show');
	Route::post('guru/save', 'GuruController@store');

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
	Route::get('banners/edit/{id}', 'BannerController@edit');
	Route::post('banners/update', 'BannerController@update');
    Route::get('banners/delete/{id}', 'BannerController@destroy');

    //Video
    Route::get('videos', 'VideoController@index');
    Route::post('videos/fetch', 'VideoController@fetch');
    Route::get('videos/add', 'VideoController@create');
	Route::post('videos/save', 'VideoController@store');

	//staff
	Route::get('staff', 'StaffController@index');
	Route::post('staff/fetch', 'StaffController@fetch')->name('staff_fetch');
	Route::get('staff/add', 'StaffController@add');
	Route::post('staff/save', 'StaffController@store');
	Route::get('staff/edit/{id}', 'StaffController@edit');
	Route::post('staff/update', 'StaffController@update');
	Route::post('publish/staff', 'StaffController@updateStatus');
	Route::get('staff/view/{id}', 'StaffController@view');

	//manage role
	Route::get('roles', 'RoleController@roles');
	Route::post('role/fetch', 'RoleController@roleData')->name('role/fetch');
	Route::get('role_permission/{id}', 'RoleController@assignRolePermission');
	Route::post('publish/permission', 'RoleController@publishPermission');

    //language
    Route::get('language', 'LanguageController@index');
    Route::post('language/fetch', 'LanguageController@fetch');
    Route::get('language/view/{id}', 'LanguageController@view');
    Route::post('language/publish', 'LanguageController@updateStatus');
    Route::get('language/delete/{id}', 'LanguageController@destroy');

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
