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

		if(isset($_POST['user_dob']) && $_POST['user_dob'] != '')
		{
			$bits = explode('/',$_POST['user_dob']);
			if(count($bits)==3)
			{
				$_POST['user_dob'] = date('Y-m-d',strtotime($bits[1].'/'.$bits[0].'/'.$bits[2]));	
			}
			else
			{
				$this->data['errors']['user_dob'] = "Date of birth is invalid.";
			}
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
		$community_login = false;	
		if(isset($_POST['user_facebook_id']) && $_POST['user_facebook_id'] > 0)
		{
			$community_login = true;
		}
		if(isset($_POST['user_twitter_id']) && $_POST['user_twitter_id'] > 0)
		{
			$community_login = true;
		}
		if(isset($_POST['user_google_id']) && $_POST['user_google_id'] > 0)
		{
			$community_login = true;
		}
		if(!$community_login)
		{
			$this->data['user']->user_display_name 	= @$_POST['user_display_name'];
			$this->data['user']->user_email 		= @$_POST['user_email'];
			$this->data['user']->user_name 			= @$_POST['user_name'];
			$this->data['user']->user_full_name 	= @$_POST['user_full_name'];
		}
		$this->data['user']->user_tagline 		= @$_POST['user_tagline'];
	
		$this->data['user']->user_dob 			= @$_POST['user_dob'];
		$this->data['user']->user_user_group 	= @$_POST['user_user_group'];
		$this->data['user']->user_activated 	= @$_POST['user_activated'];

		$this->data['user']->user_policy_seen 		= @$_POST['user_policy_seen'];
		$this->data['user']->user_policy_accepted 	= @$_POST['user_policy_accepted'];


		$this->data['user']->updated_at			= date('Y-m-d H:i:s');

		if(empty($this->data['errors']))
		{
			die('if');
			$this->data['user']->save();
			return Redirect::to('user/'.$this->data['user']->user_id);
		}
		else
		{
			die('else');
			$this->data['usergroups'] = Usergroup::all();

			return View::make('users/edit')->with('data', $this->data);
		}
		
		
	}
	public function sendpushmessage()
	{
		$this->data['sidenav']['send']['page_selected'] = true;
		//$this->data['users'] = User::where('user_deleted', '=', 0)->paginate(20);
		//if(isset($_GET['showAll']))
			$this->data['users'] = User::where('user_deleted', '=', 0)->get();

		return View::make('users/sendpush')->with('data', $this->data);
	}
	public function pushmessage()
	{
		/*if(isset($_POST['message']) && !empty($_POST['message']))
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

		}*/
		if(isset($_POST['message']) && !empty($_POST['message']))
		{
			$message = trim($_POST['message']);
			$selectall = Input::get('selectall');
			$friends_checked = Input::get('checkbox');
			if(isset($selectall) && $selectall == 'on')
			{
				$usersData = DB::select( DB::raw("SELECT t1.* FROM 
								(select device_registration_id,device_registration_device_type,device_registration_device_token,device_registration_date_created,device_registration_user_id 
								from device_registrations where device_registration_device_token  != ''  AND device_registration_device_token != 'mobstar' AND device_registration_device_type = 'apple'
								order by device_registration_date_created desc
								) t1 left join users u on t1.device_registration_user_id = u.user_id 
								where u.user_deleted = 0 
								group by u.user_id 
								order by t1.device_registration_date_created desc"));								
				if(!empty($usersData))
				{	
					for($i=0; $i<count($usersData);$i++)
					{
						$this->registerSNSEndpoint($usersData[$i],$message);
					}
				}
			}
			else
			{
				if(!empty($friends_checked))
				{	
					for($i=0; $i<count($friends_checked);$i++)
					{	
						$u = $friends_checked[$i];
			
						$usersData = DB::select( DB::raw("SELECT t1.* FROM 
									(select device_registration_id,device_registration_device_type,device_registration_device_token,device_registration_date_created,device_registration_user_id 
									from device_registrations where device_registration_device_token  != '' AND device_registration_device_token != 'mobstar' AND device_registration_device_type = 'apple'
									order by device_registration_date_created desc
									) t1 left join users u on t1.device_registration_user_id = u.user_id 
									where u.user_deleted = 0 
									AND u.user_id = $u
									group by u.user_id 
									order by t1.device_registration_date_created desc"));

						if(!empty($usersData))
						{	
								$this->registerSNSEndpoint($usersData[0],$message);
						}
					} 		
				}
			}
		}
		/* Added for check box */
		$this->data['sidenav']['send']['page_selected'] = true;
		$this->data['users'] = User::where('user_deleted', '=', 0)->paginate(20);
		if(isset($_GET['showAll']))
			$this->data['users'] = User::where('user_deleted', '=', 0)->get();
		
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
			return true;
			//print($endpointDetails['EndpointArn'] . " - Failed: " . $e->getMessage() . "!\n");
		}
	}
	public function showmessage()
	{
		$this->data['sidenav']['showmessage']['page_selected'] = true;
		return View::make('users/sendmessage')->with('data', $this->data);
	}
	public function sendmessage()
	{
		$this->data['sidenav']['showmessage']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(empty($_POST['message']))
		{
			$this->data['errors']['message'] = "Message can't be left blank.";
		}
		if(empty($this->data['errors']))
		{
			$message = Input::get( 'message' );
			$recipArray = [ ];
			$particArray = [ ];
			$newThread = '';
			$message_group = 0;
			if($message_group == 0)
			{
				$recipient = DB::select( DB::raw("SELECT u.user_id FROM users u where u.user_deleted = 0 group by u.user_id"));								
				if(!empty($recipient))
				{	
					for($i=0; $i<count($recipient);$i++)
					{
						
						$thread_id = DB::table('join_message_participants')
							->groupBy('join_message_participant_message_thread_id')
							->havingRaw("max(join_message_participant_user_id ='3101' ) > 0 and max(join_message_participant_user_id =".$recipient[$i]->user_id." ) > 0 ")
							->pluck('join_message_participant_message_thread_id');
						if(empty($thread_id))
						{
							$messageThread = MessageThread::create( [ 'message_thread_created_date' => date( 'Y-m-d H:i:s' ),'message_thread_created_by' => '3101' ] );
							$newThread = $messageThread->message_thread_thread_id;
						}
						else
						{
							$totalCount = DB::table('join_message_participants')
										->where('join_message_participant_message_thread_id','=',$thread_id,'and')
										->whereNotIn('join_message_participant_user_id',array('3101', $recipient[$i]->user_id))
										->count('join_message_participant_id');
							
							if($totalCount == 0)
							{
								$newThread = $thread_id;
							}
							elseif($totalCount > 0)
							{
								$messageThread = MessageThread::create( [ 'message_thread_created_date' => date( 'Y-m-d H:i:s' ),'message_thread_created_by' => '3101' ] );
								$newThread = $messageThread->message_thread_thread_id;
							}
						}
						$messageOb = Message2::create(
							[
								'message_creator_id'   => '3101',
								'message_thread_id'    => $newThread,
								'message_body'         => $message,
								'message_created_date' => date( 'Y-m-d H:i:s' ),
								'message_group'        => $message_group
							]
						);
						$particArray [ ] = [
							'join_message_participant_message_thread_id' => $newThread,
							'join_message_participant_user_id'           => $recipient[$i]->user_id,
						];

						$recipArray [ ] = [
							'join_message_recipient_thread_id'  => $newThread,
							'join_message_recipient_user_id'    => $recipient[$i]->user_id,
							'join_message_recipient_message_id' => (int)$messageOb->message_id,
							'join_message_recipient_created'    => 0,
							'join_message_recipient_read'       => 0,
						];
						$prev_not = Notification::where( 'notification_user_id', '=', $recipient[$i]->user_id, 'and' )
												->where( 'notification_entry_id', '=', $newThread, 'and' )
												->where( 'notification_details', '=', ' message you.', 'and' )
												->orderBy( 'notification_updated_date', 'desc' )
												->first();
						$icon = 'message.png';
						if( !count( $prev_not ) )
						{
							Notification::create( [ 'notification_user_id'      => $recipient[$i]->user_id,
													'notification_subject_ids'  => json_encode( [ '3101' ] ),
													'notification_details'      => ' has messaged you.',
													'notification_icon'			=> $icon,
													'notification_read'         => 0,
													'notification_entry_id'     => $newThread,
													'notification_type'         => 'Message',
													'notification_created_date' => date( 'Y-m-d H:i:s' ),
													'notification_updated_date' => date( 'Y-m-d H:i:s' ) ] );
						}
						else
						{
							$subjects = json_decode( $prev_not->notification_subject_ids );

							if( !in_array( '3101', $subjects ) )
							{
								array_push( $subjects, '3101' );

								$prev_not->notification_subject_ids = json_encode( $subjects );
								$prev_not->notification_read = 0;
								$prev_not->notification_updated_date = date( 'Y-m-d H:i:s' );

								$prev_not->save();
							}
							else
							{
								$prev_not->notification_read = 0;
								$prev_not->notification_updated_date = date( 'Y-m-d H:i:s' );
								
								$prev_not->save();
							}
						}					
					}
				}	
			}
			array_push( $particArray, [
				//'join_message_participant_message_thread_id' => $messageThread->message_thread_thread_id,
				'join_message_participant_message_thread_id' => $newThread,
				'join_message_participant_user_id'           => '3101',
			] );

			array_push( $recipArray, [
				//'join_message_recipient_thread_id'  => $messageThread->message_thread_thread_id,
				'join_message_recipient_thread_id'  => $newThread,
				'join_message_recipient_user_id'    => '3101',
				'join_message_recipient_message_id' => $messageOb->message_id,
				'join_message_recipient_created'    => 1,
				'join_message_recipient_read'       => 1
			] );
			MessageParticipants::insert( $particArray );
			MessageRecipients::insert( $recipArray );
			Session::flash('message', 'Message sent Successfully.');
			Session::flash('alert-class', 'alert-success');
		}
		else
		{
			Session::flash('message', 'Message can not be blank');
			Session::flash('alert-class', 'alert-success');
		}
		return View::make('users/sendmessage')->with('data', $this->data);
	}	
}
