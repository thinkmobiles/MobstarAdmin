<?php
class SendMessagesController extends BaseController {

	public function send()
	{
		$recipient = User::where('user_deleted', '=', 0)->get();
	}
}
