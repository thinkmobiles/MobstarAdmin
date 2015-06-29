<?php

class ModelingVideoController extends BaseController {

	public function showVideos()
	{
		$this->data['sidenav']['modelingVideo']['page_selected'] = true;

		$this->data['modelingVideo'] = ModelingVideo::all();

    	return View::make('modelingVideo/main')->with('data', $this->data);
	}

	public function showVideo($iModelingVideoId='')
	{	
		$this->data['sidenav']['modelingVideo']['page_selected'] = true;

		$this->data['modelingVideo'] = ModelingVideo::find($iModelingVideoId);

		if(empty($this->data['modelingVideo']))
		{
			return Redirect::to('modelingVideo/');
		}
		
		return View::make('modelingVideo/edit')->with('data', $this->data);
	}

	public function saveVideo()
	{
		$this->data['sidenav']['modelingVideo']['page_selected'] = true;

		$this->data['errors'] = array();
		
		/*if(empty($_POST['txDescription']))
		{
			$this->data['errors']['txDescription'] = "Guideline Description can't be left blank.";
		}*/
		$rules = array(
			'txDescription'    => 'required',
		);

		$validator = Validator::make( Input::get(), $rules );

		if( $validator->fails() )
		{
			$this->data['errors'] = $validator->messages();
		}	
		if(isset($_POST['iModelingVideoId']))
		{
			$this->data['modelingVideo'] = ModelingVideo::find($_POST['iModelingVideoId']);
		}
	
		$this->data['modelingVideo']->txDescription 	= $_POST['txDescription'];
		
		if(empty($this->data['errors']))
		{
			$this->data['modelingVideo']->save();

			$video = Input::file( 'vModelingVideoURL' );

			if( !empty( $video ) )
			{
				$destinationPath = 'uploads/modelingVideo/';

				$filename = $video->getClientOriginalName();
				if(!empty($this->data['modelingVideo']->vModelingVideoURL))
				{
					$oldFilePath = 'uploads/modelingVideo/'.$this->data['modelingVideo']->iModelingVideoId.'/'.$this->data['modelingVideo']->vModelingVideoURL;
					unlink($oldFilePath);
				}				

				$result = File::makeDirectory($destinationPath.$this->data['modelingVideo']->iModelingVideoId, 0777, true, true);			
				$video->move($destinationPath.$this->data['modelingVideo']->iModelingVideoId, $filename);
				$this->data['modelingVideo']->vModelingVideoURL =  $filename;	
				$this->data['modelingVideo']->save();
			}

			return Redirect::to('modelingVideo');
		}
		else
		{
			return View::make('modelingVideo/edit')->with('data', $this->data);
		}
	}

}
