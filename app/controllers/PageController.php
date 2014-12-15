<?php

class PageController extends BaseController {

	public function showPage($page='', $subpage='')
	{
		if(isset($this->data['sidenav'][$page]))
		{
			$this->data['sidenav'][$page]['page_selected'] = true;
		}
		
		return View::make('pages/main')->with('data', $this->data);
	}

}
