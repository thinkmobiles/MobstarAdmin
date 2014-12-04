<?php

class MentorsController extends BaseController {

	public function showMentors()
	{
		$this->data['sidenav']['mentors']['page_selected'] = true;

		$this->data['mentors'] = Mentor::all();

    	return View::make('mentors/main')->with('data', $this->data);
	}

	public function showMentor($mentor_id='')
	{	
		$this->data['sidenav']['mentors']['page_selected'] = true;

		if($mentor_id=='add')
		{
			$this->data['mentor'] = new User;
		}
		else
		{
			$this->data['mentor'] = Mentor::find($mentor_id);

			if(empty($this->data['mentor']))
			{
				return Redirect::to('mentors/');
			}
		}
		
		return View::make('mentors/edit')->with('data', $this->data);
	}

	public function saveMentor()
	{
		$this->data['sidenav']['mentors']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['mentor_display_name']))
		{
			$this->data['errors']['mentor_name'] = "Display name can't be left blank.";
		}
		
		if(isset($_POST['mentor_id']))
		{
			$this->data['mentor'] = Mentor::find($_POST['mentor_id']);
		}
		else
		{	
			$this->data['mentor'] = new Mentor;
		}

		$this->data['mentor']->mentor_display_name 	= $_POST['mentor_display_name'];
		$this->data['mentor']->mentor_first_name 	= $_POST['mentor_first_name'];
		$this->data['mentor']->mentor_surname 		= $_POST['mentor_surname'];
		$this->data['mentor']->mentor_bio 			= $_POST['mentor_bio'];

		if(empty($this->data['errors']))
		{
			$this->data['mentor']->save();
			return Redirect::to('mentor/'.$this->data['mentor']->mentor_id);
		}
		else
		{
			return View::make('mentors/edit')->with('data', $this->data);
		}
		
		



		if(empty($this->data['errors']))
		{
			$this->data['category']->save();
			return Redirect::to('category/'.$this->data['category']->category_id);
		}
		else
		{
			return View::make('categories/edit')->with('data', $this->data);
		}
	}

	public function deleteMentor()
	{
		if(isset($_POST['id']))
		{
			Mentor::destroy($_POST['id']);
			die('true');
		}
		else
		{
			die('false');	
		}
		
	}

}
