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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::post('/message/post', array('as' => 'postMessage' ,'uses' => 'MessageController@postMessage') );
Route::delete('/message/delete', array('as' => 'deleteMessage', 'uses' => 'MessageController@deleteMessage'));
Route::get('/login', array('as' => 'login', function() {

	return View::make("templates.login")->with('title', 'Status Page');

}));
Route::post('/login', function(){

	$userdata = array(
		'username' => Input::get( 'username' ),
		'password' => Input::get( 'password' ) 
	);

	if ( Auth::attempt( $userdata ) ) {
		return Redirect::route('home');
	} else {
		return Redirect::to('login')
			->with('login_errors', true)
			->with('title', 'Status Page');
	}

});

Route::get('/logout', array('as' => 'logout', function() {
	Auth::logout();
	return Redirect::route('home');
}));

Route::get('/api/fastly', array('as' => 'fastly', 'uses' => 'ApiController@getFastly'));
Route::get('/api/nagios', array('as' => 'nagios', 'uses' => 'ApiController@getNagios'));
Route::get('/api/pingdom', array('as' => 'pingdom', 'uses' => 'ApiController@getPingdom'));
Route::get('/api/destroy', array('uses' => 'ApiController@destroyCache'));

Route::get('/api/nagiostest', array('as' => 'nagiostest', 'uses' => 'ApiController@getNagiosTest'));