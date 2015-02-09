<?php 
	use Aws\S3\S3Client;
	use Aws\Sns\SnsClient;

	function getSNSClient()
	{
		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET,
			'region' => 'eu-west-1'
		);

		return SnsClient::factory( $config );
	}

	function getS3Client()
	{

		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET
		);

		return S3Client::factory( $config );
	}
	function getusernamebyid($userid)
	{
		$userdata = User::find($userid);

		if(!empty($userdata->user_display_name ))
		{
			return $userdata->user_display_name;
		}
		elseif(!empty($userdata->user_facebook_id))
		{
			$facebookuserdata = FacebookUser::find($userdata->user_facebook_id);
			return $facebookuserdata->facebook_user_display_name;
		}
		elseif(!empty($userdata->user_twitter_id))
		{
			$twitterkuserdata = TwitterUser::find($userdata->user_twitter_id);
			return $twitterkuserdata->twitter_user_display_name;
		}
		elseif(!empty($userdata->user_google_id))
		{
			$googleuserdata = GoogleUser::find($userdata->user_google_id);
			return $googleuserdata->google_user_display_name;
		}
		else
		{
			return 'Guest';
		}
	}	
?>