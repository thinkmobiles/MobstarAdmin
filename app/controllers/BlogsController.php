<?php

class BlogsController extends BaseController
{
	public function showBlogs()
	{
		$this->data['sidenav']['blogs']['page_selected'] = true;
		$this->data['blogs'] = Blog::all();

    	return View::make('blogs/main')->with('data', $this->data);
	}
	public function showBlog($iBlogId='')
	{
		$this->data['sidenav']['blogs']['page_selected'] = true;
		if($iBlogId=='add')
		{
			$this->data['blogs'] = new Blog;
		}
		else
		{
			$this->data['blogs'] = Blog::find($iBlogId);

			if(!empty($this->data['blogs']))
			{
				$this->data['blogs'] = Blog::where('iBlogId','=',$iBlogId)->first();
			}
			else
			{
				return Redirect::to('blogs/');
			}
		}
		return View::make('blogs/edit')->with('data', $this->data);
	}
	public function saveBlog()
	{
		$this->data['sidenav']['blogs']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['vBlogTitle']))
		{
			$this->data['errors']['vBlogTitle'] = "Blog title can't be left blank.";
		}
		
		if(isset($_POST['iBlogId']))
		{
			$this->data['blogs'] = Blog::find($_POST['iBlogId']);
		}
		else
		{	
			$this->data['blogs'] = new Blog;
		}
		//$date = date('DD/MM/YYYY');
		
		$this->data['blogs']->vBlogTitle 	= $_POST['vBlogTitle'];
		$this->data['blogs']->vBlogHeader 	= $_POST['vBlogHeader'];
		//$this->data['blogs']->tsCreatedAt = $date;
		$this->data['blogs']->txDescription = $_POST['txDescription'];

		
		if(empty($this->data['errors']))
		{
			$this->data['blogs']->save();

			$picture = Input::file( 'vBlogImage' );

			if( !empty( $picture ) )
			{
				$destinationPath = 'uploads/blog_images/';

				// if(!empty($this->data['blogs']->vBlogImage))
				// {
				// 	$oldFilePath = 'uploads/blog_images/'.$this->data['blogs']->vBlogImage;
				// 	unlink($oldFilePath);
				// }	

				$file_in = $picture->getRealPath();

				$file_out = $destinationPath.$this->data['blogs']->iBlogId . "-" . str_random( 12 ). ".jpg";

				$img = Image::make( $file_in );

				//$img->resize( 200, 200 );

				$img->save( $file_out, 80 );

				if(isset($_POST['iBlogId']) && $_POST['iBlogId'] != '0')
				{
					if(File::exists($destinationPath.$this->data['blogs']->vBlogImage))
						File::delete($destinationPath.$this->data['blogs']->vBlogImage);
				}

				$this->data['blogs']->vBlogImage =  $file_out;	

				$handle = fopen( $file_out , "r" );

				Flysystem::connection( 'awss3' )->put( $file_out , fread( $handle,filesize( $file_out ) ) );		

				$this->data['blogs']->save();
			}

			return Redirect::to('blogs');
		}
		else
		{
			return View::make('blogs/edit')->with('data', $this->data);
		}
	}
}

?>