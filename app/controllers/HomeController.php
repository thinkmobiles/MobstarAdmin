<?php

class HomeController extends BaseController {

	public function showWelcome()
	{
		$this->data['sidenav']['dashboard']['page_selected'] = true;

		return View::make('home')->with('data', $this->data);
	}
	public function showWelcomes()
	{
		$this->data['sidenav']['dashboard']['page_selected'] = true;

		return View::make('home')->with('data', $this->data);
	}
	public function showLogin()
	{
		$this->data['sidenav']['dashboard']['page_selected'] = true;

		if(isset($errors)){
			echo $errors->first('email');	
		}
		

		return View::make('login')->with('data', $this->data);
	}

	public function doLogin()
	{
		$rules = array(
			'admin_email'    => 'required|email', 
			'admin_password' => 'required|min:3'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator)
				->withInput(Input::except('password')); 
		} else {
			$userdata = array(
				'admin_email' 	=> Input::get('admin_email'),
				'password' 	=> Input::get('admin_password')
			);

			if (Auth::attempt($userdata)) {
				
				return Redirect::to('')->with('success', 'You have logged in successfully');

			} else {	 	
				
				return Redirect::to('login')
					->withInput(Input::except('admin_password'))
					->withErrors(array('admin_password' => 'Password invalid'));
			}

		}
	}

	public function doLogout()
    {
        Auth::logout();

        return Redirect::to('')->with('success', 'You are logged out');
    }

}