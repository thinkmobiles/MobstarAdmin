<?php

class MessagesController extends BaseController {

	public function showMessages()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['messages'] = Message::leftJoin('users', function($join) {
			$join->on('messages.message_creator_id', '=', 'users.user_id');
		})->where('message_deleted', '=', 0)->get();

    	return View::make('messages/main')->with('data', $this->data);
	}

	public function showMyMessages()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['messages'] = Message::leftJoin('users', function($join) {
			$join->on('messages.message_creator_id', '=', 'users.user_id');
		})->where('message_creator_id','=',Auth::id())->get();

    	return View::make('messages/main')->with('data', $this->data);
	}

	public function showMessage($entry_message_id='')
	{	
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['message'] = !empty($entry_message_id) ? Message::find($entry_message_id) : new Messages;

		return View::make('messages/edit')->with('data', $this->data);
	}

	public function saveMessage()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(isset($_POST['entry_message_id']))
		{
			$this->data['message'] = Message::find($_POST['entry_message_id']);
		}
		else
		{	
			$this->data['message'] = new Message;
		}

		$this->data['message']->entry_message_message_reason 			= $_POST['entry_message_message_reason'];

		if(empty($this->data['errors']))
		{
			$this->data['message']->save();
		}
		
		return View::make('messages/edit')->with('data', $this->data);
	}

}
