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

Route::get('registered', function(){ return view('registered'); });

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){

	// User Routes
	Route::resource('user', 'Auth\UserController');
	Route::PATCH('useri/{user_id}', 'Auth\UserController@inactive')->name('user.inactive');
	Route::PATCH('usera/{user_id}', 'Auth\UserController@active')->name('user.active');

	Route::get('roles', 'Auth\UserController@rolepermission')->name('role.index');

	Route::get('role/{role_id}/edit', 'Auth\UserController@editrolepermission')->name('role.edit');

	Route::PATCH('role/{role_id}', 'Auth\UserController@updaterolepermission')->name('role.update');

	// Brand Routes
	Route::resource('brand', 'BrandController');
	
	// Location Routes
	Route::resource('location', 'LocationController');

	
	// Campaign Routes
	Route::resource('campaign', 'CampaignController');
	Route::PATCH('campaignu/{campaign_id}', 'CampaignController@publish')->name('campaign.publish');
	Route::PATCH('campaignp/{campaign_id}', 'CampaignController@unpublish')->name('campaign.unpublish');




	
});


