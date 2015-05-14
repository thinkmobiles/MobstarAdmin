<?php

class SendMessagesController extends BaseController {

	public function show()
	{
		$this->data['sidenav']['sendMessages']['page_selected'] = true;
		return View::make('sendMessages/sendpush')->with('data', $this->data);
	}	
}
