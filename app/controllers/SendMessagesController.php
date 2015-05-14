<?php

class SendMessagesController extends BaseController {

	public function sendMessage()
	{
		$this->data['sidenav']['messages']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(empty($_POST['message']))
		{
			$this->data['errors']['message'] = "Message can't be left blank.";
		}
		$recipArray = [ ];
		$particArray = [ ];
		$newThread = '';
		$message_group = 0;
		if($message_group == 0)
		{
			$recipient = DB::table('users')->where('user_deleted', '=', 0)->get();											
			if(!empty($recipient))
			{	
				for($i=0; $i<count($recipient);$i++)
				{
					$thread_id = DB::table('join_message_participants')
						->groupBy('join_message_participant_message_thread_id')
						->havingRaw("max(join_message_participant_user_id ='420' ) > 0 and max(join_message_participant_user_id =$recipient[$i] ) > 0 ")
						->pluck('join_message_participant_message_thread_id');
					if(empty($thread_id))
					{
						$messageThread = MessageThread::create( [ 'message_thread_created_date' => date( 'Y-m-d H:i:s' ),'message_thread_created_by' => '420' ] );
						$newThread = $messageThread->message_thread_thread_id;
					}
					else
					{
						$totalCount = DB::table('join_message_participants')
									->where('join_message_participant_message_thread_id','=',$thread_id,'and')
									->whereNotIn('join_message_participant_user_id',array('420', $recipient[$i]))
									->count('join_message_participant_id');
						
						if($totalCount == 0)
						{
							$newThread = $thread_id;
						}
						elseif($totalCount > 0)
						{
							$messageThread = MessageThread::create( [ 'message_thread_created_date' => date( 'Y-m-d H:i:s' ),'message_thread_created_by' => '420' ] );
							$newThread = $messageThread->message_thread_thread_id;
						}
					}
					$particArray [ ] = [
						//'join_message_participant_message_thread_id' => $messageThread->message_thread_thread_id,
						'join_message_participant_message_thread_id' => $newThread,
						'join_message_participant_user_id'           => $recipient[$i],
					];

					$recipArray [ ] = [
						//'join_message_recipient_thread_id'  => $messageThread->message_thread_thread_id,
						'join_message_recipient_thread_id'  => $newThread,
						'join_message_recipient_user_id'    => $recipient[$i],
						'join_message_recipient_message_id' => (int)$messageOb->message_id,
						'join_message_recipient_created'    => 0,
						'join_message_recipient_read'       => 0,
					];
					$prev_not = Notification::where( 'notification_user_id', '=', $recipient[$i], 'and' )
											->where( 'notification_entry_id', '=', $newThread, 'and' )
											->where( 'notification_details', '=', ' message you.', 'and' )
											->orderBy( 'notification_updated_date', 'desc' )
											->first();
					$icon = 'message.png';
					if( !count( $prev_not ) )
					{
						Notification::create( [ 'notification_user_id'      => $recipient[$i],
												'notification_subject_ids'  => json_encode( [ '420' ] ),
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

						if( !in_array( '420', $subjects ) )
						{
							array_push( $subjects, '420' );

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
					if(!empty($name))
					{
						$message = $msg;
						$icon = 'http://' . $_ENV[ 'URL' ] . '/images/message.png';
						$usersDeviceData = DB::select( DB::raw("SELECT t1.* FROM 
							(select device_registration_id,device_registration_device_type,device_registration_device_token,device_registration_date_created,device_registration_user_id 
							from device_registrations where device_registration_device_token  != '' 
							order by device_registration_date_created desc
							) t1 left join users u on t1.device_registration_user_id = u.user_id 
							where u.user_deleted = 0 
							AND u.user_id = $recipient
							order by t1.device_registration_date_created desc LIMIT 1"));

						if(!empty($usersDeviceData))
						{	
							$this->registerSNSEndpoint($usersDeviceData[0], $message, $message_group, $name, $icon, $threadid);
						}
					}
					
					
					$this->registerSNSEndpoint($usersData[$i],$message);
				}
			}
			
			
			
		}
		$messageOb = Message2::create(
			[
				'message_creator_id'   => '420',
				'message_thread_id'    => $newThread,
				'message_body'         => $message,
				'message_created_date' => date( 'Y-m-d H:i:s' ),
				'message_group'        => $message_group
			]
		);

		$this->data['message']->entry_message_message_reason = $_POST['message'];

		if(empty($this->data['errors']))
		{
			$this->data['message']->save();
		}
		
		return View::make('messages/edit')->with('data', $this->data);
	}

}
