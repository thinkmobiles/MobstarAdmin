<?php

class SettingsController extends BaseController
{
	public function showSettings()
	{
		$this->data['sidenav']['settings']['page_selected'] = true;

		$this->data['settings'] = Settings::all();

    	return View::make('settings/main')->with('data', $this->data);
	}

	public function showSetting($iSettingId='')
	{
		$this->data['sidenav']['settings']['page_selected'] = true;

		$this->data['settings'] = Settings::find($iSettingId);

		// if(!empty($this->data['settings']))
		// {
		// 	$this->data['entries_count'] = Entry::where('entry_category_id', '=', $category_id)->count();
		// }
		// else
		// {
		// 	return Redirect::to('categories/');
		// }
		
		
		return View::make('settings/edit')->with('data', $this->data);
	}

	public function saveSetting()
	{
		$this->data['sidenav']['settings']['page_selected'] = true;

		$this->data['errors'] = array();
		
		if(empty($_POST['vTitle']))
		{
			$this->data['errors']['vTitle'] = "Title can't be left blank.";
		}
		if(empty($_POST['vUniqueName']))
		{
			$this->data['errors']['vUniqueName'] = "Unique Name can't be left blank.";
		}
		
		if(isset($_POST['iSettingId']))
		{
			$this->data['settings'] = Settings::find($_POST['iSettingId']);
		}
		else
		{	
			$this->data['settings'] = new Settings;
		}

		$this->data['settings']->vTitle	= $_POST['vTitle'];
		$this->data['settings']->vUniqueName = $_POST['vUniqueName'];
		//$this->data['settings']->vSettingValue = $_POST['vSettingValue'];
		$this->data['settings']->eSettingType = $_POST['eSettingType'];
		

		if ($_POST['eStatus'] == 0) 
		{
			$this->data['settings']->eStatus = 'Inactive';
			$this->data['settings']->vSettingValue = 'FALSE';
		}
		else
		{
			$this->data['settings']->eStatus = 'Active';
			$this->data['settings']->vSettingValue = 'TRUE';
		}

		if(empty($this->data['errors']))
		{
			$this->data['settings']->save();

			return Redirect::to('settings');
		}
		else
		{
			return View::make('settings/edit')->with('data', $this->data);
		}
	}
}