<?php

class UsersController extends BaseController {

	public function showUsers()
	{
		$this->data['sidenav']['users']['page_selected'] = true;

		$this->data['users'] = User::where('user_deleted', '=', 0)->paginate(20);

    	return View::make('users/main')->with('data', $this->data);
	}

	public function showUser($user_id='')
	{	
		$this->data['sidenav']['users']['page_selected'] = true;

		if($user_id=='add')
		{
			$this->data['user'] = new User;
		}
		else
		{
			$this->data['user'] = User::find($user_id);

			if(!empty($this->data['user']))
			{
				$this->data['entries'] = User::find($user_id)->entries;
				$this->data['stars'] = Star::leftJoin('users', function($join) {
					$join->on('user_stars.user_star_star_id', '=', 'users.user_id');
				})->where('user_star_user_id', '=', $user_id)->get();
			}
			else
			{
				return Redirect::to('users/');
			}
		}

		$this->data['usergroups'] = Usergroup::all();

		return View::make('users/edit')->with('data', $this->data);
	}

	public function saveUser()
	{
		$this->data['sidenav']['users']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['user_display_name']))
		{
			$this->data['errors']['user_display_name'] = "Display name can't be left blank.";
		}

		$bits = explode('/',$_POST['user_dob']);
		if(count($bits)==3)
		{
			$_POST['user_dob'] = date('Y-m-d',strtotime($bits[1].'/'.$bits[0].'/'.$bits[2]));	
		}
		else
		{
			$this->data['errors']['user_dob'] = "Date of birth is invalid.";
		}

		if(isset($_POST['user_id']))
		{
			$this->data['user'] = User::find($_POST['user_id']);
		}
		else
		{	
			$this->data['user'] = new User;
			$this->data['user']->user_user_group = '3';
		}

		$this->data['user']->user_display_name 	= $_POST['user_display_name'];
		$this->data['user']->user_email 		= $_POST['user_email'];
		$this->data['user']->user_name 			= $_POST['user_name'];
		$this->data['user']->user_full_name 	= $_POST['user_full_name'];
		$this->data['user']->user_tagline 		= $_POST['user_tagline'];
	
		$this->data['user']->user_dob 			= $_POST['user_dob'];
		$this->data['user']->user_user_group 	= $_POST['user_user_group'];
		$this->data['user']->user_activated 	= $_POST['user_activated'];

		$this->data['user']->user_policy_seen 		= $_POST['user_policy_seen'];
		$this->data['user']->user_policy_accepted 	= $_POST['user_policy_accepted'];


		$this->data['user']->updated_at			= date('Y-m-d H:i:s');

		if(empty($this->data['errors']))
		{
			$this->data['user']->save();
			return Redirect::to('user/'.$this->data['user']->user_id);
		}
		else
		{
			$this->data['usergroups'] = Usergroup::all();

			return View::make('users/edit')->with('data', $this->data);
		}
		
		
	}

}
