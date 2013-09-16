<?php

class Message extends Eloquent {

	protected $fillable = array( 'message', 'flag' );

	public static function indexMessage() {
		return Message::orderBy( 'created_at', 'desc' )->take(4)->get();
	}
}