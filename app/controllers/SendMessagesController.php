<?php

class SendMessagesController extends BaseController {

	public function sendMessage()
	{
		$this->data['sidenav']['sendMessages']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(empty($_POST['message']))
		{
			$this->data['errors']['message'] = "Message can't be left blank.";
		}
		if(empty($this->data['errors']))
		{
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
							->havingRaw("max(join_message_participant_user_id ='3101' ) > 0 and max(join_message_participant_user_id =$recipient[$i]->user_id ) > 0 ")
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
							//'join_message_participant_message_thread_id' => $messageThread->message_thread_thread_id,
							'join_message_participant_message_thread_id' => $newThread,
							'join_message_participant_user_id'           => $recipient[$i]->user_id,
						];

						$recipArray [ ] = [
							//'join_message_recipient_thread_id'  => $messageThread->message_thread_thread_id,
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
		}
		return View::make('sendMessagess/edit')->with('data', $this->data);
	}
}
