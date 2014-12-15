<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::post('login', array('uses' => 'HomeController@doLogin'));
Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::group(array('before' => 'auth'), function()
{
	Route::get('/', array('uses' => 'HomeController@showWelcome'));

	Route::get('categories', array('uses' => 'CategoriesController@showCategories'));
	Route::post('category/delete', array('uses' => 'CategoriesController@deleteCategory'));
	Route::get('category/{category_id}', array('uses' => 'CategoriesController@showCategory'));
	Route::post('category/{category_id}', array('uses' => 'CategoriesController@saveCategory'));

	Route::get('mentors', array('uses' => 'MentorsController@showMentors'));
	Route::post('mentor/delete', array('uses' => 'MentorsController@deleteMentor'));
	Route::get('mentor/{mentor_id}', array('uses' => 'MentorsController@showMentor'));
	Route::post('mentor/{mentor_id}', array('uses' => 'MentorsController@saveMentor'));

	Route::get('users', array('uses' => 'UsersController@showUsers'));
	Route::get('user/{user_id}', array('uses' => 'UsersController@showUser'));
	Route::post('user/{users_id}', array('uses' => 'UsersController@saveUser'));

	Route::get('messages', array('uses' => 'MessagesController@showMessages'));
	Route::get('my_messages', array('uses' => 'MessagesController@showMyMessages'));
	Route::get('message/{user_id}', array('uses' => 'MessagesController@showMessage'));
	Route::post('message/{users_id}', array('uses' => 'MessagesController@saveMessage'));

	Route::get('entries', array('uses' => 'EntriesController@showEntries'));
	Route::get('entry/{entry_id}', array('uses' => 'EntriesController@showEntry'));
	Route::post('entry/{entry_id}', array('uses' => 'EntriesController@saveEntry'));

	Route::get('tags', array('uses' => 'TagsController@showTags'));
	Route::post('tag/delete', array('uses' => 'TagsController@deleteTag'));
	Route::post('tag/combine', array('uses' => 'TagsController@combineTag'));
	Route::get('tag/{tag_id}', array('uses' => 'TagsController@showTag'));
	Route::post('tag/{tag_id}', array('uses' => 'TagsController@saveTag'));

	Route::get('reports', array('uses' => 'ReportsController@showReports'));
	Route::get('report/{report_id}', array('uses' => 'ReportsController@showReport'));
	Route::post('report/{report_id}', array('uses' => 'ReportsController@saveReport'));

	Route::get('{page}', array('uses' => 'PageController@showPage'))->where('page', '[A-Za-z]+');
	Route::get('{page}/{subpage}', array('uses' => 'PageController@showPage'))->where(array('page' => '[A-Za-z]+', 'subpage' => '[a-z]+'));
});