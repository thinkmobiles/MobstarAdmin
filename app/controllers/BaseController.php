<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function __construct()
    {
    	$adminUser = Auth::User();   	
		$type = DB::table('admins')->where('admin_email',(isset($adminUser->admin_email)?$adminUser->admin_email:''))->pluck('admin_type');
    	if($type == 'fashion_user')
    	{
    		$this->data['sidenav'] = array(
				'dashboard' => array(
					'page_title' => 'Dashboard',
					'page_url' => 'fashionEntries',
					'page_icon' => 'tachometer',
					'page_selected' => false,
				),
				'fashionEntries' => array(
					'page_title' => 'Fashion Entries',
					'page_url' => 'fashionEntries',
					'page_icon' => 'sitemap',
					'page_selected' => false,
				),
			);
    	}
    	elseif ($type == 'admin') 
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
				'blogs' => array(
					'page_title' => 'Blogs',
					'page_url' => 'blogs',
					'page_icon' => 'rss',
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
				'send' => array(
					'page_title' => 'Send Notification',
					'page_url' => 'users/sendpushmessage',
					'page_icon' => 'send',
					'page_selected' => false,
				),
				'tags' => array(
					'page_title' => 'Tags',
					'page_url' => 'tags',
					'page_icon' => 'tags',
					'page_selected' => false,
				),
				'modelingVideo' => array(
					'page_title' => 'Modeling Video',
					'page_url' => 'modelingVideo',
					'page_icon' => 'file-video-o',
					'page_selected' => false,
				),
				'defaultNotification' => array(
						'page_title' => 'Default Notification',
						'page_url' => 'defaultNotification',
						'page_icon' => 'bell',
						'page_selected' => false,
				),
				'showmessage' => array(
					'page_title' => 'Send Message',
					'page_url' => 'users/showmessage',
					'page_icon' => 'envelope-o',
					'page_selected' => false,
				),
				'settings' => array(
					'page_title' => 'Settings',
					'page_url' => 'settings',
					'page_icon' => 'cog',
					'page_selected' => false,
				),
				'reports' => array(
					'page_title' => 'Reports',
					'page_url' => 'reports',
					'page_icon' => 'exclamation-triangle',
					'page_selected' => false,
					'page_counter' => Report::all()->count(),
				),
				'support' => array(
					'page_title' => 'Support Admin Area',
					'page_url' => 'https://mobstar.freshdesk.com/support/login',
					'page_icon' => '',
					'page_selected' => false,
				),
			);
		}
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
