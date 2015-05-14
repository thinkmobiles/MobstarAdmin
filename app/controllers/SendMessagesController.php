<?php

class SendMessagesController extends BaseController {

	public function sendMessage()
	{
		$recipient = DB::table('users')->where('user_deleted', '=', 0)->get();	
		
		print_r($recipient);
		die('here');
		
	}

}
