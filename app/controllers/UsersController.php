<?php

class UsersController extends BaseController {

	public function showUsers()
	{
		$this->data['sidenav']['users']['page_selected'] = true;

		$this->data['users'] = User::where('user_deleted', '=', 0)->paginate(20);
		if(isset($_GET['showAll']))
			$this->data['users'] = User::where('user_deleted', '=', 0)->get();

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
	public function sendpushmessage()
	{
		return View::make('users/sendpush')->with('data', $this->data);
	}

	public function pushmessage()
	{
		if(isset($_POST['message']) && !empty($_POST['message']))
		{
			$message = trim($_POST['message']);
			$users = DB::select( DB::raw("SELECT t1.* FROM 
				(select device_registration_id,device_registration_device_type,device_registration_device_token,device_registration_date_created,device_registration_user_id 
					from device_registrations where device_registration_device_token  != '' 
					order by device_registration_date_created desc
				) t1 left join users u on t1.device_registration_user_id = u.user_id 
				where u.user_deleted = 0 
				group by u.user_id 
				order by t1.device_registration_date_created desc"));
			foreach($users as $key=>$val)
			{
				$this->registerSNSEndpoint($val,$message);
			}

		}
		Session::flash('message', 'Push Message sent Successfully.');
		Session::flash('alert-class', 'alert-success'); 
		return View::make('users/sendpush')->with('data', $this->data);
	}

	public function registerSNSEndpoint( $device , $message)
	{
		if( $device->device_registration_device_type == "apple" )
		{
			$arn = "arn:aws:sns:eu-west-1:830026328040:app/APNS/adminpushdemo";
		}
		else
		{
			$arn = "arn:aws:sns:eu-west-1:830026328040:app/GCM/admin-android-notification";
		}

		$sns = getSNSClient();

		$Model1 = $sns->listPlatformApplications();  
		
		$result1 = $sns->listEndpointsByPlatformApplication(array(
			// PlatformApplicationArn is required
			'PlatformApplicationArn' => $arn,
		));
		foreach($result1['Endpoints'] as $Endpoint){
			$EndpointArn = $Endpoint['EndpointArn']; 
			$EndpointToken = $Endpoint['Attributes'];
			foreach($EndpointToken as $key=>$newVals){
				if($key=="Token"){
					if($device->device_registration_device_token==$newVals){
					//Delete ARN
						$result = $sns->deleteEndpoint(array(
							// EndpointArn is required
							'EndpointArn' => $EndpointArn,
						));
					}
				}
			}
		}

		 $result = $sns->createPlatformEndpoint(array(
			 // PlatformApplicationArn is required
			 'PlatformApplicationArn' => $arn,
			 // Token is required
			 'Token' => $device->device_registration_device_token,

		 ));

		 $endpointDetails = $result->toArray();		 
		 if($device->device_registration_device_type == "apple")
		 {	
			 $publisharray = array(
			 	'TargetArn' => $endpointDetails['EndpointArn'],
			 	'MessageStructure' => 'json',
			 	 'Message' => json_encode(array(
					'default' => $message,
					//'APNS_SANDBOX' => json_encode(array(
					'APNS' => json_encode(array(
						'aps' => array(
							"sound" => "default",
							"alert" => $message,
							"badge"=> intval(0),
						)
					)),
				))
			 );
		 }
		 else
		 {
			 $publisharray = array(
			 	'TargetArn' => $endpointDetails['EndpointArn'],
			 	'MessageStructure' => 'json',
			 	'Message' => json_encode(array(
					'default' => $message,
					'GCM'=>json_encode(array(
						'data'=>array(
							'message'=> $message
						)
					))
				))
			 );
		 }
		try
		{
			$sns->publish($publisharray);

			$myfile = 'sns-log.txt';
			file_put_contents($myfile, date('d-m-Y H:i:s') . ' debug log:', FILE_APPEND);
			file_put_contents($myfile, print_r($endpointDetails, true), FILE_APPEND);
		}   
		catch (Exception $e)
		{
			print($endpointDetails['EndpointArn'] . " - Failed: " . $e->getMessage() . "!\n");
		}
	}
}
