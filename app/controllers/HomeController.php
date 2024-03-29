<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.master';
 
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		// $this->layout->content = View::make('templates.status');
		return View::make('templates.status')
			->with('title', 'Status Page');
	}

}