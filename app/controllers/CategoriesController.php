<?php
use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials as Creds;
class CategoriesController extends BaseController {

	public function showCategories()
	{
		$this->data['sidenav']['categories']['page_selected'] = true;

		$this->data['categories'] = Category::all();

    	return View::make('categories/main')->with('data', $this->data);
	}

	public function showCategory($category_id='')
	{	
		$this->data['sidenav']['categories']['page_selected'] = true;

		if($category_id=='add')
		{
			$this->data['user'] = new User;
		}
		else
		{
			$this->data['category'] = Category::find($category_id);

			if(!empty($this->data['category']))
			{
				$this->data['entries_count'] = Entry::where('entry_category_id', '=', $category_id)->count();
			}
			else
			{
				return Redirect::to('categories/');
			}
		}
		
		return View::make('categories/edit')->with('data', $this->data);
	}

	public function saveCategory()
	{
		$this->data['sidenav']['categories']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['category_name']))
		{
			$this->data['errors']['category_name'] = "Name can't be left blank.";
		}
		
		if(isset($_POST['category_id']))
		{
			$this->data['category'] = Category::find($_POST['category_id']);
		}
		else
		{	
			$this->data['category'] = new Category;
		}

		$this->data['category']->category_name 			= $_POST['category_name'];
		$this->data['category']->category_description 	= $_POST['category_description'];
		$this->data['category']->category_active 		= (isset($_POST['category_active']) && $_POST['category_active'] != '') ? $_POST['category_active'] : '0';

		if(empty($this->data['errors']))
		{
			$this->data['category']->save();
			$icon = Input::file( 'category_icon' );

			if( !empty( $icon ) )
			{
				$destinationPath = 'categoryIcon/';

				$file_in = $icon->getRealPath();

				$file_out = $destinationPath.$this->data['category']->category_id . "-" . str_random( 12 ). ".".$icon->getClientOriginalExtension();

				$img = Image::make( $file_in );

				$img->resize( 160, 160 );

				$img->save( $file_out, 80 );
				
				/*if(!is_dir($destinationPath))
					$result = File::makeDirectory($destinationPath, 0777, true);
				*/
				//$profile->move($destinationPath, $filename);

				if(isset($_POST['category_id']) && $_POST['category_id'] != '0')
				{
					if(File::exists($destinationPath.$this->data['category']->category_icon))
						File::delete($destinationPath.$this->data['category']->category_icon);
				}

				$this->data['category']->category_icon = $file_out;	

				$handle = fopen( $file_out , "r" );

				Flysystem::connection( 'awss3' )->put( $file_out , fread( $handle,filesize( $file_out ) ) );		

				$this->data['category']->save();
			}
			return Redirect::to('category/'.$this->data['category']->category_id);
		}
		else
		{
			return View::make('categories/edit')->with('data', $this->data);
		}
		
	}

	public function deleteCategory()
	{
		if(isset($_POST['id']))
		{
			Category::destroy($_POST['id']);
			die('true');
		}
		else
		{
			die('false');	
		}
		
	}

}
