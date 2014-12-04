<?php

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
		$this->data['category']->category_active 		= $_POST['category_active'];

		if(empty($this->data['errors']))
		{
			$this->data['category']->save();
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
