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
Route::get('/', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login');
Route::get('/forgot-password', 'LoginController@forgotPassword')->name('password.request');
Route::post('/forgot-password', 'LoginController@forgotPasswordStore')->name('password.email');
Route::get('/reset-password/{token}/{email}', 'LoginController@passwordReset')->name('password.reset')->middleware('signed');
Route::post('/reset-password', 'LoginController@passwordUpdate')->name('password.update');

Route::get('/password_expired', 'AdminController@passwordExpired');
Route::post('/force_reset_password', 'AdminController@resetExpiredPassword');

Route::group(['middleware' => ['customAuth']], function () {
	// Dashboard
	Route::get('dashboard', 'DashboardController@index');
	Route::get('dashboard/test', 'DashboardController@index_phpinfo');

	//profile
	Route::get('/profile', 'AdminController@profile');
	Route::post('/updateProfile', 'AdminController@updateProfile');

	//change password
	Route::get('/updatePassword', 'AdminController@updatePassword');
	Route::post('/resetPassword', 'AdminController@resetPassword');


	//Ashram
	Route::get('ashram', 'AshramController@index');
	Route::get('ashram/add', 'AshramController@create');
	Route::get('ashram/edit/{id}', 'AshramController@edit');
	Route::post('ashram/update', 'AshramController@update');
	Route::post('ashram/fetch', 'AshramController@fetch');
	Route::get('ashram/view/{id}', 'AshramController@show');
	Route::post('ashram/save', 'AshramController@store');
	Route::post('ashram/delete_img', 'AshramController@deleteImage');

	//Guru's
	Route::get('guru', 'ArtistController@index');
	Route::get('guru/add', 'ArtistController@create');
	Route::get('guru/edit/{id}', 'ArtistController@edit');
	Route::post('guru/update', 'ArtistController@update');
	Route::post('guru/fetch', 'ArtistController@fetch');
	Route::get('guru/view/{id}', 'ArtistController@show');
	Route::post('guru/save', 'ArtistController@store');

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
	Route::get('videos/view/{id}', 'VideoController@view');
	Route::get('videos/edit/{id}', 'VideoController@edit');
	Route::post('videos/update', 'VideoController@update');
    Route::post('videos/publish', 'VideoController@updateStatus');
    Route::get('videos/delete/{id}', 'VideoController@destroy');

    //Book
    Route::get('books', 'BookController@index');
    Route::post('books/fetch', 'BookController@fetch');
    Route::get('books/add', 'BookController@create');
	Route::post('books/save', 'BookController@store');
    Route::get('books/view/{id}', 'BookController@view');
	Route::get('books/edit/{id}', 'BookController@edit');
	Route::post('books/update', 'BookController@update');
    Route::post('books/publish', 'BookController@updateStatus');
    Route::get('books/delete/{id}', 'BookController@destroy');

	//staff
	Route::get('staff', 'StaffController@index');
	Route::post('staff/fetch', 'StaffController@fetch')->name('staff_fetch');
	Route::get('staff/add', 'StaffController@add');
	Route::post('staff/save', 'StaffController@store');
	Route::get('staff/edit/{id}', 'StaffController@edit');
	Route::post('staff/update', 'StaffController@update');
	Route::post('publish/staff', 'StaffController@updateStatus');
	Route::get('staff/view/{id}', 'StaffController@view');

	//Home Collecton
	Route::get('home_collection', 'HomeCollectionController@index');


	Route::post('home_collection/fetch', 'HomeCollectionController@fetch');
	Route::get('home_collection/add', 'HomeCollectionController@add');
	Route::post('home_collection/save', 'HomeCollectionController@store');
	Route::get('home_collection/edit/{id}', 'HomeCollectionController@edit');
	Route::post('home_collection/update', 'HomeCollectionController@update');
	Route::post('publish_staff', 'HomeCollectionController@updateStatus');
	Route::get('home_collection/view/{id}', 'HomeCollectionController@view');

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
    Route::get('language/add', 'LanguageController@add');
    Route::post('language/save', 'LanguageController@store');
    Route::get('language/edit/{id}', 'LanguageController@edit');
    Route::post('language/update', 'LanguageController@update');
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

    //general settings
    Route::get('general_settings', 'GeneralSettingController@index');
    Route::post('updateSettingInfo', 'GeneralSettingController@updateSetting');


	// Logout
	Route::get('/logout', function () {
		session()->forget('data');
		return redirect('/webadmin');
	});
});
