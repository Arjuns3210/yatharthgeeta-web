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
Route::get('forgot-password', 'LoginController@forgotPassword')->name('password.request');
Route::post('forgot-password', 'LoginController@forgotPasswordStore')->name('password.email');
Route::get('/reset-password/{token}/{email}', 'LoginController@passwordReset')->name('password.reset')->middleware('signed');
Route::post('/reset-password', 'LoginController@passwordUpdate')->name('password.update');

Route::get('/password_expired', 'AdminController@passwordExpired');
Route::post('/force_reset_password', 'AdminController@resetExpiredPassword');

Route::group(['middleware' => ['customAuth']], function () {
	// Dashboard
	Route::get('dashboard', 'DashboardController@index');
	Route::get('dashboard/test', 'DashboardController@index_phpinfo');
	Route::post('admin_dashboard_chart', 'DashboardController@userDashboardChart');

	//profile
	Route::get('/profile', 'AdminController@profile');
	Route::post('/updateProfile', 'AdminController@updateProfile');

	//change password
	Route::get('/updatePassword', 'AdminController@updatePassword');
	Route::post('/resetPassword', 'AdminController@resetPassword');


	//Location
	Route::get('location', 'LocationController@index');
	Route::get('location/add', 'LocationController@create');
	Route::get('location/edit/{id}', 'LocationController@edit');
	Route::post('location/update', 'LocationController@update');
	Route::post('location/fetch', 'LocationController@fetch');
	Route::get('location/view/{id}', 'LocationController@show');
	Route::post('location/save', 'LocationController@store');
	Route::post('location/delete_img', 'LocationController@deleteImage');
	Route::post('location/publish', 'LocationController@updateStatus');


	//Guru's
	Route::get('guru', 'ArtistController@index');
	Route::get('guru/add', 'ArtistController@create');
	Route::get('guru/edit/{id}', 'ArtistController@edit');
	Route::post('guru/update', 'ArtistController@update');
	Route::post('guru/fetch', 'ArtistController@fetch');
	Route::get('guru/view/{id}', 'ArtistController@show');
	Route::post('guru/save', 'ArtistController@store');
	Route::post('guru/delete_img', 'ArtistController@deleteImage');
	Route::post('guru/publish', 'ArtistController@updateStatus');

	// Category
	Route::get('books_category', 'BookCategoryController@index');
	Route::get('books_category/add', 'BookCategoryController@create');
	Route::post('books_category/fetch', 'BookCategoryController@fetch');
	Route::post('books_category/save', 'BookCategoryController@store');
	Route::get('books_category/edit/{id}', 'BookCategoryController@edit');
	Route::post('books_category/update', 'BookCategoryController@update');
	Route::get('books_category/view/{id}', 'BookCategoryController@show');

    //audio
    Route::get('audios', 'AudioController@index');
    Route::get('audio/add', 'AudioController@create');
    Route::get('prepare_episode_item/{number}', 'AudioController@prepareEpisodeItem');
    Route::post('audio/fetch', 'AudioController@fetch');
    Route::post('audio/save', 'AudioController@store');
    Route::get('audio/edit/{id}', 'AudioController@edit');
    Route::post('audio/update', 'AudioController@update');
    Route::get('audio/view/{id}', 'AudioController@show');
    Route::post('publish_audio', 'AudioController@updateStatus');
    Route::get('audio_delete/{id}', 'AudioController@destroy');
    Route::post('delete_documents', 'AudioController@deleteMedia')->name('delete_documents');

    // audio episodes
    Route::get('audio_episodes/{audioId?}', 'AudioEpisodeController@index');
    Route::post('audio_episode/fetch', 'AudioEpisodeController@fetch');
    Route::post('audio_episode/save', 'AudioEpisodeController@store');
    Route::get('audio_episode/add/{id}', 'AudioEpisodeController@create');
    Route::get('audio_episode/edit/{id}', 'AudioEpisodeController@edit');
    Route::post('audio_episode/update', 'AudioEpisodeController@update');
    Route::get('audio_episode/view/{id}', 'AudioEpisodeController@show');
    Route::post('publish_audio_episode', 'AudioEpisodeController@updateStatus');
    Route::get('audio_episode_delete/{id}', 'AudioEpisodeController@destroy');

    //pravachan
    Route::get('pravachans', 'PravachanController@index');
    Route::get('pravachan/add', 'PravachanController@create');
    Route::post('pravachan/fetch', 'PravachanController@fetch');
    Route::post('pravachan/save', 'PravachanController@store');
    Route::get('pravachan/edit/{id}', 'PravachanController@edit');
    Route::post('pravachan/update', 'PravachanController@update');
    Route::get('pravachan/view/{id}', 'PravachanController@show');
    Route::post('publish_pravachan', 'PravachanController@updateStatus');
    Route::get('pravachan_delete/{id}', 'PravachanController@destroy');
    
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

    //Mantra
    Route::get('mantras', 'MantraController@index');
    Route::post('mantras/fetch', 'MantraController@fetch');
    Route::get('mantras/add', 'MantraController@create');
    Route::post('mantras/save', 'MantraController@store');
    Route::get('mantras/view/{id}', 'MantraController@view');
	Route::get('mantras/edit/{id}', 'MantraController@edit');
	Route::post('mantras/update', 'MantraController@update');
    Route::post('mantras/publish', 'MantraController@updateStatus');
    Route::get('mantras/delete/{id}', 'MantraController@destroy');

    //manage Event Images
    Route::get('event_images/add/{eventId}', 'EventImageController@create');
    Route::post('event_images/save', 'EventImageController@store');

    //Event
    Route::get('events', 'EventController@index');
    Route::post('events/fetch', 'EventController@fetch');
    Route::get('events/add', 'EventController@create');
    Route::post('events/save', 'EventController@store');
    Route::get('events/view/{id}', 'EventController@view');
	Route::get('events/edit/{id}', 'EventController@edit');
    Route::post('events/update', 'EventController@update');
    Route::post('events/publish', 'EventController@updateStatus');
    Route::get('events/delete/{id}', 'EventController@destroy');

	//staff
	Route::get('staff', 'StaffController@index');
	Route::post('staff/fetch', 'StaffController@fetch')->name('staff_fetch');
	Route::get('staff/add', 'StaffController@add');
	Route::post('staff/save', 'StaffController@store');
	Route::get('staff/edit/{id}', 'StaffController@edit');
	Route::post('staff/update', 'StaffController@update');
	Route::post('publish/staff', 'StaffController@updateStatus');
	Route::get('staff/view/{id}', 'StaffController@view');
	Route::get('staff/change_password/{id}', 'StaffController@changePassword');
    Route::post('staff/changePassword', 'StaffController@changeStaffPassword');

	//Home Collection
	Route::get('home_collection', 'HomeCollectionController@index');
	Route::post('home_collection/fetch', 'HomeCollectionController@fetch');
	Route::get('home_collection/add', 'HomeCollectionController@create');
	Route::post('home_collection/save', 'HomeCollectionController@store');
	Route::get('home_collection/edit/{id}', 'HomeCollectionController@edit');
	Route::post('home_collection/update', 'HomeCollectionController@update');
	Route::post('home_collection/publish', 'HomeCollectionController@updateStatus');
	Route::get('home_collection/view/{id}', 'HomeCollectionController@show');
    Route::post('home_collection/publish', 'HomeCollectionController@updateStatus');
    Route::get('home_collection/delete/{id}', 'HomeCollectionController@destroy');
    Route::get('get_mapped_listing/{type}', 'HomeCollectionController@getMappedListing');
    Route::get('prepare_multiple_collection_item/{count}','HomeCollectionController@prepareMultipleCollectionItem');

    //Home Collection
    Route::get('explore_collection', 'ExploreCollectionController@index');
    Route::post('explore_collection/fetch', 'ExploreCollectionController@fetch');
    Route::get('explore_collection/add', 'ExploreCollectionController@create');
    Route::post('explore_collection/save', 'ExploreCollectionController@store');
    Route::get('explore_collection/edit/{id}', 'ExploreCollectionController@edit');
    Route::post('explore_collection/update', 'ExploreCollectionController@update');
    Route::post('explore_collection/publish', 'ExploreCollectionController@updateStatus');
    Route::get('explore_collection/view/{id}', 'ExploreCollectionController@show');
    Route::get('explore_collection/delete/{id}', 'ExploreCollectionController@destroy');

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
    Route::post('quotes/delete_img', 'AshramController@deleteImage');

    //quote category
    Route::get('quote_category', 'QuoteCategoryController@index');
    Route::post('quote_category/fetch', 'QuoteCategoryController@fetch');

	//customer
	Route::get('customer', 'CustomerController@index');
	Route::post('customer/fetch', 'CustomerController@fetch');
	Route::get('customer/view/{id}', 'CustomerController@show');
	Route::get('customer/verify/{id}', 'CustomerController@isVerify');
	Route::get('customer/change_password/{id}', 'CustomerController@changePassword');
	Route::post('customer/changePassword', 'CustomerController@changeCustomerPassword');
    Route::post('customer/publish', 'CustomerController@updateStatus');

    //general settings
    Route::get('general_settings', 'GeneralSettingController@index');
    Route::post('updateSettingInfo', 'GeneralSettingController@updateSetting');

    //about us
    Route::get('about_us', 'AboutUsController@index');
    Route::post('about_us/update', 'AboutUsController@update');    

    //terms and condition
    Route::get('terms', 'TermsAndConditionController@index');
    Route::post('terms/update', 'TermsAndConditionController@update');    

    //privacy policy
    Route::get('privacy_policy', 'PrivacyPolicyController@index');
    Route::post('privacy_policy/update', 'PrivacyPolicyController@update');
    
    //Shlok
    Route::get('shloks', 'ShlokController@index')->name('shloks.index');
    Route::post('shloks/fetch', 'ShlokController@fetch');
    Route::get('shloks/add', 'ShlokController@create');
	Route::post('shloks/save', 'ShlokController@store');
    Route::get('shloks/view/{id}', 'ShlokController@view');
	Route::get('shloks/edit/{id}', 'ShlokController@edit');
	Route::post('shloks/update/{id}', 'ShlokController@update');
    Route::post('shloks/publish', 'ShlokController@updateStatus');
    Route::get('shloks/delete/{id}', 'ShlokController@destroy');

	// Logout
	Route::get('/logout', function () {
		session()->forget('data');
		return redirect('/webadmin');
	});
});
