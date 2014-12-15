<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function __construct()
    {
		$this->data['sidenav'] = array(
			'dashboard' => array(
				'page_title' => 'Dashboard',
				'page_url' => '',
				'page_icon' => 'tachometer',
				'page_selected' => false,
			),
			'categories' => array(
				'page_title' => 'Categories',
				'page_url' => 'categories',
				'page_icon' => 'sitemap',
				'page_selected' => false,
			),
			'mentors' => array(
				'page_title' => 'Mentors',
				'page_url' => 'mentors',
				'page_icon' => 'hand-o-right',
				'page_selected' => false,
			),
			'users' => array(
				'page_title' => 'Users',
				'page_url' => 'users',
				'page_icon' => 'group',
				'page_selected' => false,
			),
			'entries' => array(
				'page_title' => 'Entries',
				'page_url' => 'entries',
				'page_icon' => 'upload',
				'page_selected' => false,
			),
			'messages' => array(
				'page_title' => 'Messages',
				'page_url' => 'messages',
				'page_icon' => 'envelope-o',
				'page_selected' => false,
			),
			'tags' => array(
				'page_title' => 'Tags',
				'page_url' => 'tags',
				'page_icon' => 'tags',
				'page_selected' => false,
			),
			'reports' => array(
				'page_title' => 'Reports',
				'page_url' => 'reports',
				'page_icon' => 'exclamation-triangle',
				'page_selected' => false,
				'page_counter' => Report::all()->count(),
			),
		);
	
		$this->data['this_user'] = Auth::user();

		$this->data['my_messages'] = Message::where('message_creator_id','=',Auth::id())->get();

    }

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
