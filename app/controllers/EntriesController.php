<?php

class EntriesController extends BaseController {

	public function showEntries()
	{
		$this->data['sidenav']['entries']['page_selected'] = true;

		$this->data['entries'] = Entry::paginate(20);

    	return View::make('entries/main')->with('data', $this->data);
	}

	public function showEntry($entry_id='')
	{	
		$this->data['sidenav']['entries']['page_selected'] = true;

		$this->data['entry'] = !empty($entry_id) ? Entry::find($entry_id) : new Entries;

		$this->data['users'] = User::all();

		$this->data['categories'] = Category::all();

		$this->data['reports'] = Report::where('entry_report_entry_id', '=', $entry_id)->get();

		$this->data['tags'] = Entrytag::leftJoin('tags', function($join) {
			$join->on('entry_tags.entry_tag_tag_id', '=', 'tags.tag_id');
		})->where('entry_tag_entry_id', '=', $entry_id)->get();

		return View::make('entries/edit')->with('data', $this->data);
	}

	public function saveEntry()
	{
		$this->data['sidenav']['entries']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['entry_name']))
		{
			$this->data['errors']['entry_name'] = "Name can't be left blank.";
		}
		
		if(isset($_POST['entry_id']))
		{
			$this->data['entry'] = Entry::find($_POST['entry_id']);
		}
		else
		{	
			$this->data['entry'] = new Entry;
		}

		$this->data['entry']->entry_name 			= $_POST['entry_name'];
		$this->data['entry']->entry_description 	= $_POST['entry_description'];
		$this->data['entry']->entry_active 			= $_POST['entry_active'];
		$this->data['entry']->entry_modified_date	= date('Y-m-d H:i:s');

		if(empty($this->data['errors']))
		{
			$this->data['entry']->save();
		}
		
		return View::make('entries/edit')->with('data', $this->data);
	}

}
