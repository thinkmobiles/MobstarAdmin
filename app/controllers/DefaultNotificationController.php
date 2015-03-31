<?php
use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials as Creds;

class DefaultNotificationController extends BaseController {

	public function showDefaultNotifications()
	{
		$this->data['sidenav']['defaultNotification']['page_selected'] = true;

		$this->data['defaultNotification'] = DefaultNotification::all();

    	return View::make('defaultNotification/main')->with('data', $this->data);
	}
	
	public function showDefaultNotification($iDefaultNotificationId='')
	{	
		$this->data['sidenav']['defaultNotification']['page_selected'] = true;

		$this->data['defaultNotification'] = DefaultNotification::find($iDefaultNotificationId);

		if(!empty($this->data['defaultNotification']))
		{
			$this->data['entries_count'] = DefaultNotification::where('iDefaultNotificationId', '=', $iDefaultNotificationId)->count();
			return View::make('defaultNotification/edit')->with('data', $this->data);
		}
		else
		{
			return Redirect::to('defaultNotification/');
		}	
		
	}

	
	public function saveDefaultNotification()
	{
		$this->data['sidenav']['defaultNotification']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['vDefaultNotificationTitle']))
		{
			$this->data['errors']['vDefaultNotificationTitle'] = "Title can't be left blank.";
		}
		
		if(isset($_POST['iDefaultNotificationId']))
		{
			$this->data['defaultNotification'] = DefaultNotification::find($_POST['iDefaultNotificationId']);
		}
		else
		{	
			$this->data['defaultNotification'] = new DefaultNotification;
		}

		$this->data['defaultNotification']->vDefaultNotificationTitle 			= $_POST['vDefaultNotificationTitle'];
		$this->data['defaultNotification']->txDescription 	= $_POST['txDescription'];
		
		if(empty($this->data['errors']))
		{
			$this->data['defaultNotification']->save();

			$profile = Input::file( 'vDefaultNotificationImage' );

			if( !empty( $profile ) )
			{
				$destinationPath = 'defaultNotificationImage/';

				$file_in = $profile->getRealPath();

				$file_out = $destinationPath.$this->data['defaultNotification']->iDefaultNotificationId . "-" . str_random( 12 ). ".jpg";

				$img = Image::make( $file_in );

				//$img->resize( 200, 200 );

				$img->save( $file_out, 80 );

				if(isset($_POST['iDefaultNotificationId']) && $_POST['iDefaultNotificationId'] != '0')
				{
					if(File::exists($destinationPath.$this->data['defaultNotification']->vDefaultNotificationImage))
						File::delete($destinationPath.$this->data['defaultNotification']->vDefaultNotificationImage);
				}

				$this->data['defaultNotification']->vDefaultNotificationImage =  $file_out;	

				$handle = fopen( $file_out , "r" );

				Flysystem::connection( 'awss3' )->put( $file_out , fread( $handle,filesize( $file_out ) ) );		

				$this->data['defaultNotification']->save();
			}

			return Redirect::to('defaultNotification');
		}
		else
		{
			return View::make('defaultNotification/edit')->with('data', $this->data);
		}
		
	}
}
