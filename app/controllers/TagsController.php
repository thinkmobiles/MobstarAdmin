<?php

class TagsController extends BaseController {

	public function showTags()
	{
		$this->data['sidenav']['tags']['page_selected'] = true;

		$this->data['tags'] = Tag::paginate(20);
		if(isset($_GET['showAll']))
		{
			$this->data['tags'] = Tag::all();
		}

    	return View::make('tags/main')->with('data', $this->data);
	}

	public function showTag($tag_id='')
	{	
		$this->data['sidenav']['tags']['page_selected'] = true;

		$this->data['tag'] = !empty($tag_id) ? Tag::find($tag_id) : new Tags;

		$this->data['tags'] = Tag::all();

		return View::make('tags/edit')->with('data', $this->data);
	}

	public function saveTag()
	{
		$this->data['sidenav']['tags']['page_selected'] = true;

		$this->data['errors'] = array();
		
		/*if(empty($_POST['tag_name']))
		{
			$this->data['errors']['tag_name'] = "Display name can't be left blank.";
		}*/
		$rules = array(
			'tag_name'    => 'required',
		);

		$validator = Validator::make( Input::get(), $rules );

		if( $validator->fails() )
		{
			$this->data['errors'] = $validator->messages();
		}
		
		if(isset($_POST['tag_id']))
		{
			$this->data['tag'] = Tag::find($_POST['tag_id']);
		}
		else
		{	
			$this->data['tag'] = new Tag;
		}

		$this->data['tag']->tag_name 	= $_POST['tag_name'];

		if(empty($this->data['errors']))
		{
			$this->data['tag']->save();
			return Redirect::to('tags');
		}
		else
		{
			return View::make('tags/edit')->with('data', $this->data);
		}
	}

	public function deleteTag()
	{
		if(isset($_POST['id']))
		{
			EntryTag::where('entry_tag_tag_id', '=', $_POST['id'])->delete();
			Tag::destroy($_POST['id']);
			die('true');
		}
		else
		{
			die('false');	
		}
		
	}

	public function combineTag()
	{
		if(isset($_POST['id']) && isset($_POST['new_id']))
		{
			$entrytags = EntryTag::where('entry_tag_tag_id', '=', $_POST['id'])->get();

			foreach ($entrytags as $entrytag) {
				
				$entrytags = EntryTag::where('entry_tag_tag_id', '=', $_POST['id'])->get();
				
			}

			$entrytags->update(array('entry_tag_tag_id' => $_POST['new_id']));


			Tag::destroy($_POST['id']);
			die('true');
		}
		else
		{
			die('false');
		}
	}


}
