<?php

class MessagesController extends BaseController {

	public function showMessages()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;
		
		$this->data['messages'] = Message::leftJoin('users', function($join) {
			$join->on('messages.message_creator_id', '=', 'users.user_id');
		})->where('message_deleted', '=', 0)->paginate(20);
		
		/*$this->data['messages'] = Message::leftJoin('users', function($join) {
			$join->on('messages.message_creator_id', '=', 'users.user_id');
		})->where('message_deleted', '=', 0)->get();*/
		
		if(isset($_GET['showAll']))
		{
			$this->data['messages'] = Message::leftJoin('users', function($join) {
				$join->on('messages.message_creator_id', '=', 'users.user_id');
			})->where('message_deleted', '=', 0)->get();
		}
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

	public function showMessage($message_id='')
	{	
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['message'] = !empty($message_id) ? Message::find($message_id) : new Messages;

		return View::make('messages/edit')->with('data', $this->data);
	}

	public function saveMessage()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(isset($_POST['message_id']))
		{
			$this->data['message'] = Message::find($_POST['message_id']);
		}
		else
		{	
			$this->data['message'] = new Message;
		}

		$this->data['message']->message_body = $_POST['message_body'];

		if(empty($this->data['errors']))
		{
			$this->data['message']->save();
			return Redirect::to('messages');
		}
		else
		{
			return View::make('messages/edit')->with('data', $this->data);
		}
	}

}
