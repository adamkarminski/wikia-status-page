<?php

class MessageController extends BaseController {

	public function postMessage() {
		$message = new Message;
		$message -> message = Input::get('message');
		$message -> flag = Input::get('flag');
		$message -> save();

		return Redirect::route('home');
	}
	
	public function deleteMessage() {
		$id = Input::get( 'id' );
		Message::find( $id )->delete();
		return Response::json( array('id' => $id) );
	}
}