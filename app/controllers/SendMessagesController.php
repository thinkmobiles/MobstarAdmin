<?php
class SendMessagesController extends BaseController {

	public function send()
	{
		
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(empty($_POST['message']))
		{
			$this->data['errors']['message'] = "Message can't be left blank.";
		}
		$recipArray = [ ];
		$particArray = [ ];
		$newThread = '';
		$message_group = 0;
		if($message_group == 0)
		{
			$recipient = DB::table('users')->where('user_deleted', '=', 0)->take(10);
		}
		print_r($recipient);
	}
}
