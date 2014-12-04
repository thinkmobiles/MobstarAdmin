<?php

class AdminsController extends BaseController {

	public function showAdmins()
	{
		$this->data['sidenav']['admins']['page_selected'] = true;

		$this->data['admins'] = Admin::paginate(20);

    	return View::make('admins/main')->with('data', $this->data);
	}

	public function showAdmin($admin_id='')
	{	
		$this->data['sidenav']['admins']['page_selected'] = true;

		if($admin_id=='add')
		{
			$this->data['admin'] = new Admin;
		}
		else
		{
			$this->data['admin'] = Admin::find($admin_id);

			if(!empty($this->data['admin']))
			{
				$this->data['entries'] = Admin::find($admin_id)->entries;
				$this->data['stars'] = Star::leftJoin('admins', function($join) {
					$join->on('admin_stars.admin_star_star_id', '=', 'admins.admin_id');
				})->where('admin_star_admin_id', '=', $admin_id)->get();
			}
			else
			{
				return Redirect::to('admins/');
			}
		}

		$this->data['admingroups'] = Admingroup::all();

		return View::make('admins/edit')->with('data', $this->data);
	}

	public function saveAdmin()
	{
		$this->data['sidenav']['admins']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['admin_display_name']))
		{
			$this->data['errors']['admin_display_name'] = "Display name can't be left blank.";
		}

		$bits = explode('/',$_POST['admin_dob']);
		if(count($bits)==3)
		{
			$_POST['admin_dob'] = date('Y-m-d',strtotime($bits[1].'/'.$bits[0].'/'.$bits[2]));	
		}
		else
		{
			$this->data['errors']['admin_dob'] = "Date of birth is invalid.";
		}

		if(isset($_POST['admin_id']))
		{
			$this->data['admin'] = Admin::find($_POST['admin_id']);
		}
		else
		{	
			$this->data['admin'] = new Admin;
			$this->data['admin']->admin_admin_group = '3';
		}

		$this->data['admin']->admin_display_name 	= $_POST['admin_display_name'];
		$this->data['admin']->admin_email 		= $_POST['admin_email'];
		$this->data['admin']->admin_name 			= $_POST['admin_name'];
		$this->data['admin']->admin_full_name 	= $_POST['admin_full_name'];
		$this->data['admin']->admin_tagline 		= $_POST['admin_tagline'];
	
		$this->data['admin']->admin_dob 			= $_POST['admin_dob'];
		$this->data['admin']->admin_admin_group 	= $_POST['admin_admin_group'];
		$this->data['admin']->admin_activated 	= $_POST['admin_activated'];

		$this->data['admin']->admin_policy_seen 		= $_POST['admin_policy_seen'];
		$this->data['admin']->admin_policy_accepted 	= $_POST['admin_policy_accepted'];


		$this->data['admin']->updated_at			= date('Y-m-d H:i:s');

		if(empty($this->data['errors']))
		{
			$this->data['admin']->save();
			return Redirect::to('admin/'.$this->data['admin']->admin_id);
		}
		else
		{
			$this->data['admingroups'] = Admingroup::all();

			return View::make('admins/edit')->with('data', $this->data);
		}
		
		
	}

}
