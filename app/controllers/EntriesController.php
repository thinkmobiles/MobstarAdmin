<?php

use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials as Creds;

class EntriesController extends BaseController
{

	public function showFashionEntries()
	{

		$this->data[ 'sidenav' ][ 'fashionEntries' ][ 'page_selected' ] = true;
		$order_by = ( Input::get( 'orderBy', 'latest' ) );
		$this->data['errors'] = array();
		
		
		if(Input::has('pageList'))
		{
			$pageList = (Input::get('pageList',20));
			setcookie('cookie_pageList', $pageList, time() + (86400 * 30), "/");
		}
		else
		{
			if(isset($_COOKIE['cookie_pageList']))
			{
				$pageList = $_COOKIE['cookie_pageList']; 
			}
			else
			{
				setcookie('cookie_pageList','20', time() + (86400 * 30), "/"); 
				$pageList = 20;
			}   
		}
		
		switch( $order_by )
		{
			case "popular":
				$order = 'entry_rank';
				$dir = 'asc';
				break;
			case "latest":
				$order = 'entry_created_date';
				$dir = 'desc';
				break;
			default:
				$order = 0;
				$dir = 0;
		}

		//Get tags
		$tag = ( Input::get( 'tagId', '0' ) );
		$tag = ( !is_numeric( $tag ) ) ? 0 : $tag;

		$deleted = ( Input::get( 'deleted', 0 ) );



		//Get Category
		$category = ( Input::get( 'subCategory', 'All' ) );
		//$category = ( !is_numeric( $category ) ) ? 0 : $category;

		$query = Entry::with( 'category', 'vote', 'user', 'file', 'entryTag.tag' )
		 			  ->where( 'entry_id', '>', '0' )
		 			  ->where('entry_category_id','=','3');

		//////////////Get Vote
		$entryRange = Input::get('entryRange','0 - 500');
		$first = 0;
		$last = 500;
		if(Input::has('entryRange') && $entryRange != '0 - 500')
		{
			$removedSpace = str_replace(' ', '', $entryRange);
			$values = explode('-', $removedSpace);
			$first = intval($values[0]);
			$last = intval($values[1]);

			$ids = [];
			$result = DB::table('votes')
			->select(DB::raw('sum(votes.vote_up) as vote_up, entries.entry_id'))
			->join('entries','votes.vote_entry_id','=','entries.entry_id')
			->where('votes.vote_deleted','=',0)
			->where('entries.entry_deleted','=',0)
			->where('entries.entry_category_id','=',3)
			->groupBy('votes.vote_entry_id')
			->having('vote_up','>=',$first)
			->having('vote_up','<=',$last)
			->get();
			//dd(DB::getQueryLog());
			foreach ($result as $rs) {
				$ids[]=$rs->entry_id;
			}
			if(!empty($ids))
			{
				$query = $query->whereIn('entry_id',$ids);				
			}
			else
			{
				$this->data[ 'errors' ][ ] = 'Entries not found.';
			}
		}
		
		
		///////////////////

		//////////////Get Age
		$age = Input::get('age','all');
				 
		if(Input::has('age') && $age != 'all')
		{		
			$values = explode('-',Input::get('age'));
			$start = intval($values[0]);
			$end = intval($values[1]);

			$query = $query->where('entry_age','>=',$start)->where('entry_age','<=',$end);
		 
		}
		///////////////////
		//////////////Get Height
		$height = Input::get('height','all');
				 
		if(Input::has('height') && $height != 'all')
		{		
			$values = explode('-',Input::get('height'));
			$start = floatval($values[0]);
			$end = floatval($values[1]);

			$query = $query->where('entry_height','>=',$start)->where('entry_height','<=',$end);
		 
		}
		///////////////////
		//////////////Get Name
		$name = Input::get('name','');
				 
		if(Input::has('name') && $name != '')
		{		
			$values = Input::get('name');
			$query = $query->where('entry_name', 'LIKE', '%'.$values.'%');

		}
		///////////////////
		//////////////Get Date
		$datepicker = Input::get('datepicker','');
				 
		if(Input::has('datepicker') && $datepicker != '')
		{		
			$values = Input::get('datepicker');
			$dt = date("Y-m-d", strtotime($values));
			
			$query = $query->where('entry_created_date', 'LIKE', '%'.$dt.'%');

		}
		///////////////////
		


		if( $order_by == 'popular' )
		{
			$query = $query->where( 'entry_rank', '>', 0 );
		}

		if( $category )
		{
			if( Input::get( 'subCategory', 'All' ) == 'All')
			{
				$query = $query->where( 'entry_category_id', array('3'));
			}			
			elseif (Input::get('subCategory') == 'Male') 
			{
				$query = $query->where( 'entry_subcategory', '=', 'Male');
			}
			elseif (Input::get('subCategory') == 'Female') 
			{
				$query = $query->where( 'entry_subcategory', '=', 'Female');
			}
			elseif (Input::get('subCategory') == 'Curve') 
			{
				$query = $query->where( 'entry_subcategory', '=', 'Curve');
			}
			// else
			// 	$query = $query->where( 'entry_subcategory', '=', $category );
		}
		if( $deleted == 1 )
		{
			$query = $query->where( 'entry_deleted', '=', 0 );
		}
		elseif( $deleted == 2 )
		{
			$query = $query->where( 'entry_deleted', '=', 1 );
		}

		if( $tag )
		{
			$query = $query->whereHas( 'entryTag', function ( $q ) use ( $tag )
			{
				$q->where( 'entry_tag_tag_id', '=', $tag );
			} );
		}

		
		$entries = $query->orderBy( $order, $dir )->paginate( $pageList );
		
		//dd(DB::getQueryLog());
		$this->data[ 'pages' ] = $entries->appends( Input::all() )->links();

		$this->data[ 'entries' ] = [ ];



		foreach( $entries as $entry )
		{
			$up_votes = 0;
			$down_votes = 0;
			foreach( $entry->vote as $vote )
			{
				if( $vote->vote_up == 1 && $vote->vote_deleted == 0 )
				{
					$up_votes++;
				}
				elseif( $vote->vote_down == 1 && $vote->vote_deleted == 0 )
				{
					$down_votes++;
				}
			}
			

			if( count( $entry->file ) == 0 )
			{
				continue;
			}
			$new[ 'entry_file' ] = $new[ 'entry_image' ] = "";

			foreach( $entry->file as $file )
			{
				if( $entry->entry_type == 'video' )
				{
					if( $file->entry_file_type == 'mp4' )
					{
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );
						$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );

					}
				}
				elseif( $entry->entry_type == 'audio' )
				{
					if( $file->entry_file_type == 'mp3' )
					{
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );
					}

					else
					{
						if( strtolower( trim( $file->entry_file_type, '.' ) ) == 'jpg' || strtolower( trim( $file->entry_file_type, '.' ) ) == 'png' )
						{
							$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );
						}
					}
				}
				elseif( $entry->entry_type == 'image' )
				{
					if( strtolower( trim( $file->entry_file_type, '.' ) ) == 'jpg' || strtolower( trim( $file->entry_file_type, '.' ) ) == 'png' )
					{
						$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );

					}
				}
			}

			$new[ 'entry_name' ] = $entry->user->user_display_name;
			$new[ 'entry_date' ] = $entry->entry_created_date;
			$new[ 'entry_down_votes' ] = $down_votes;
			$new[ 'entry_up_votes' ] = $up_votes;
			$new[ 'entry_description' ] = $entry->entry_description;
			$new[ 'entry_type' ] = $entry->entry_type;
			$new[ 'entry_id' ] = $entry->entry_id;
			$new[ 'entry_deleted' ] = $entry->entry_deleted;
			$new[ 'entry_subcategory' ] = $entry->entry_subcategory;
			$this->data[ 'entries' ][ ] = $new;

		}
		$this->data[ 'subCategories' ] = Entry::all();
		return View::make( 'fashionCategory/main' )->with( 'data', $this->data )->with('first',$first)->with('last',$last);
	}
	public function ellipsis($text, $max=25, $append='&hellip;')
	{
	  	if (strlen($text) <= $max) return $text;
	  	$out = substr($text,0,$max);
	  	if (strpos($text,' ') === FALSE) return $out.$append;
	  	return preg_replace('/\w+$/','',$out).$append;
	}
	public function showEntryNote( $entry_id = '' )
	{
		$adminUser = Auth::User();   	
    	$type = DB::table('admins')->where('admin_email',(isset($adminUser->admin_email)?$adminUser->admin_email:''))->pluck('admin_type');
    	if($type == 'fashion_user')
    	{
    		$this->data[ 'sidenav' ][ 'fashionEntries' ][ 'page_selected' ] = true;	
    	}
    	else
    	{
    		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;	
    	}
		
		$this->data[ 'entry' ] = !empty( $entry_id ) ? Entry::find( $entry_id ) : new Entries;

		if($this->data['entry']['entry_category_id'] == 3)
		{
			return View::make( 'fashionCategory/showNote' )->with( 'data', $this->data );
		}
		// else
		// {
		// 	return View::make( 'entries/edit' )->with( 'data', $this->data );	
		// }
		
	}

	public function saveEntryNote()
	{
		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;

		if( isset( $_POST[ 'entry_id' ] ) )
		{
			$this->data[ 'entry' ] = Entry::find( $_POST[ 'entry_id' ] );
		}
		else
		{
			$this->data[ 'entry' ] = new Entry;
		}

		$this->data[ 'entry' ]->entry_note = $_POST[ 'entryNote' ];
		$this->data[ 'entry' ]->entry_modified_date = date( 'Y-m-d H:i:s' );

		$this->data[ 'entry' ]->save();
		return Redirect::to('fashionEntries');

	}
	
	public function showEntries()
	{
		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;

		$order_by = ( Input::get( 'orderBy', 'latest' ) );

		switch( $order_by )
		{
			case "popular":
				$order = 'entry_rank';
				$dir = 'asc';
				break;
			case "latest":
				$order = 'entry_created_date';
				$dir = 'desc';
				break;
			default:
				$order = 0;
				$dir = 0;
		}

		//Get tags
		$tag = ( Input::get( 'tagId', '0' ) );
		$tag = ( !is_numeric( $tag ) ) ? 0 : $tag;

		$deleted = ( Input::get( 'deleted', 0 ) );

		//Get Category
		$category = ( Input::get( 'category', 'All' ) );
		//$category = ( Input::get( 'category', '0' ) );
		//$category = ( !is_numeric( $category ) ) ? 0 : $category;

		$query = Entry::with( 'category', 'vote', 'user', 'file', 'entryTag.tag' )
					  ->where( 'entry_id', '>', '0' );

		if( $order_by == 'popular' )
		{
			$query = $query->where( 'entry_rank', '>', 0 );
		}

		/*if( $category )
		{
			$query = $query->where( 'entry_category_id', '=', $category );
		}*/
		if( $category )
		{
			if( Input::get( 'category', 'All' ) == 'All')
				$query = $query->whereNotIn( 'entry_category_id', array('7','8'));
			else
				$query = $query->where( 'entry_category_id', '=', $category );
		}	

		if( $deleted == 1 )
		{
			$query = $query->where( 'entry_deleted', '=', 0 );
		}
		elseif( $deleted == 2 )
		{
			$query = $query->where( 'entry_deleted', '=', 1 );
		}

		if( $tag )
		{
			$query = $query->whereHas( 'entryTag', function ( $q ) use ( $tag )
			{
				$q->where( 'entry_tag_tag_id', '=', $tag );
			} );
		}

		$entries = $query->orderBy( $order, $dir )->paginate( 15 );

		$this->data[ 'pages' ] = $entries->appends( Input::all() )->links();

		$this->data[ 'entries' ] = [ ];

		foreach( $entries as $entry )
		{
			$up_votes = 0;
			$down_votes = 0;
			foreach( $entry->vote as $vote )
			{
				if( $vote->vote_up == 1 && $vote->vote_deleted == 0 )
				{
					$up_votes++;
				}
				elseif( $vote->vote_down == 1 && $vote->vote_deleted == 0 )
				{
					$down_votes++;
				}

			}

			if( count( $entry->file ) == 0 )
			{
				continue;
			}
			$new[ 'entry_file' ] = $new[ 'entry_image' ] = "";

			foreach( $entry->file as $file )
			{
				if( $entry->entry_type == 'video' )
				{
					if( $file->entry_file_type == 'mp4' )
					{
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );
						$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );

					}
				}
				elseif( $entry->entry_type == 'audio' )
				{
					if( $file->entry_file_type == 'mp3' )
					{
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );
					}

					else
					{
						if( strtolower( trim( $file->entry_file_type, '.' ) ) == 'jpg' || strtolower( trim( $file->entry_file_type, '.' ) ) == 'png' )
						{
							$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );
						}
					}
				}
				elseif( $entry->entry_type == 'image' )
				{
					if( strtolower( trim( $file->entry_file_type, '.' ) ) == 'jpg' || strtolower( trim( $file->entry_file_type, '.' ) ) == 'png' )
					{
						$new[ 'entry_image' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type, true );
						$new[ 'entry_file' ] = EntryFile::s3Name( $file->entry_file_name, $file->entry_file_type );

					}
				}
			}

			$new[ 'entry_name' ] = $entry->user->user_display_name;
			$new[ 'entry_date' ] = $entry->entry_created_date;
			$new[ 'entry_down_votes' ] = $down_votes;
			$new[ 'entry_up_votes' ] = $up_votes;
			$new[ 'entry_description' ] = $entry->entry_description;
			$new[ 'entry_type' ] = $entry->entry_type;
			$new[ 'entry_id' ] = $entry->entry_id;
			$new[ 'entry_deleted' ] = $entry->entry_deleted;

			$this->data[ 'entries' ][ ] = $new;

//			echo "Main: <a href='" . $new['entry_file'] . "'>" . $new['entry_file'] . "</a><br>";
//
//			echo "Image: <a href='" . $new['entry_image'] . "'>" . $new['entry_image'] . "</a><br>";
//
//			var_dump($new);

		}

		$this->data[ 'categories' ] = Category::all();

//		return "";

		return View::make( 'entries/main' )->with( 'data', $this->data );
	}

	public function showEntry( $entry_id = '' )
	{
		/*if(isset($this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ]))
			$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ]= true;
		if(isset($this->data[ 'sidenav' ][ 'fashionEntries' ][ 'page_selected' ]))
			$this->data[ 'sidenav' ][ 'fashionEntries' ][ 'page_selected' ]= true;
		*/
		$adminUser = Auth::User();   	
    	$type = DB::table('admins')->where('admin_email',(isset($adminUser->admin_email)?$adminUser->admin_email:''))->pluck('admin_type');
    	if($type == 'fashion_user')
    	{
    		$this->data[ 'sidenav' ][ 'fashionEntries' ][ 'page_selected' ] = true;	
    	}
    	else
    	{
    		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;	
    	}
		$this->data[ 'entry' ] = !empty( $entry_id ) ? Entry::find( $entry_id ) : new Entries;

		$this->data[ 'users' ] = User::all();

		$this->data[ 'categories' ] = Category::all();

		$this->data[ 'reports' ] = Report::where( 'entry_report_entry_id', '=', $entry_id )->get();

		$this->data[ 'tags' ] = EntryTag::leftJoin( 'tags', function ( $join )
		{
			$join->on( 'entry_tags.entry_tag_tag_id', '=', 'tags.tag_id' );
		} )->where( 'entry_tag_entry_id', '=', $entry_id )->get();

		if($this->data['entry']['entry_category_id'] == 3)
		{
			return View::make( 'fashionCategory/edit' )->with( 'data', $this->data );
		}
		else
		{
			return View::make( 'entries/edit' )->with( 'data', $this->data );	
		}
	}

	public function saveEntry()
	{
		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;

		$this->data[ 'errors' ] = array();

		if( empty( $_POST[ 'entry_name' ] ) )
		{
			$this->data[ 'errors' ][ 'entry_name' ] = "Name can't be left blank.";
		}

		if( isset( $_POST[ 'entry_id' ] ) )
		{
			$this->data[ 'entry' ] = Entry::find( $_POST[ 'entry_id' ] );
		}
		else
		{
			$this->data[ 'entry' ] = new Entry;
		}

		$this->data[ 'entry' ]->entry_name = $_POST[ 'entry_name' ];
		$this->data[ 'entry' ]->entry_category_id = $_POST[ 'entry_category_id' ];
		$this->data[ 'entry' ]->entry_description = $_POST[ 'entry_description' ];
		$this->data[ 'entry' ]->entry_deleted = $_POST[ 'entry_deleted' ];
		$this->data[ 'entry' ]->entry_modified_date = date( 'Y-m-d H:i:s' );

		if( empty( $this->data[ 'errors' ] ) )
		{
			$this->data[ 'entry' ]->save();
		}

		return Redirect::to('entry/' . $_POST['entry_id']);

		}

	public function delete( $id )
	{
		$entry = Entry::find( $id );

		$entry->entry_deleted = 1;

		$entry->save();

		return Response::make( [ 'status' => 'entry deleted' ], 200 );
	}

	public function harddelete( $id )
	{

		$client = getS3Client();
		$files = EntryFile::where('entry_file_entry_id', '=', $id )->get();
		$data = array();

		foreach($files as $file)
		{
			$ch = curl_init();
			$filename = $file->entry_file_name;
			$filetype = $file->entry_file_type;
			$data = array("filename" => "$filename", "filetype" => "$filetype");
			
			$url = 'http://api.mobstar.com/entry/deleteentryfiles';
			//$url = 'http://192.168.1.32/project/mobstarapi/public/index.php/entry/deleteentryfiles';
			
			//set URL and other appropriate options
			$options = array(CURLOPT_URL => $url,
							 CURLOPT_POST => true,
			                 CURLOPT_POSTFIELDS => $data,
			                 CURLOPT_RETURNTRANSFER => true
			                );
			//print_r($options);
			curl_setopt_array($ch, $options);

			// grab URL and pass it to the browser
			$response = curl_exec($ch);
			
			// close cURL resource, and free up system resources
			curl_close($ch);

			//print_r($response);
			
			$thumbimage = 'thumbs/'.$filename.'-thumb.jpg';
			$video = $filename.'.'.$filetype;
			$bucket = 'mobstar-1';
			
			//$removethumb = $client->deleteObject('mobstar-1', $thumbimage);
			$removethumb = $client->deleteObject(array(
			    'Bucket' => $bucket,
			    'Key'    => $thumbimage
			));

			//$removevideo = $client->deleteObject('mobstar-1', $video);
			$removevideo = $client->deleteObject(array(
			    'Bucket' => $bucket,
			    'Key'    => $video
			));

		}

		EntryFile::where('entry_file_entry_id', '=', $id)->delete();

		EntryReport::where('entry_report_entry_id', '=', $id)->delete();

		EntryTag::where('entry_tag_entry_id', '=', $id)->delete();

		EntryView::where('entry_view_entry_id', '=', $id)->delete();

		Vote::where('vote_entry_id', '=', $id)->delete();

		Comment::where('comment_entry_id', '=', $id)->delete();
		
		Notification::where('notification_entry_id','=',$id)->delete();

		$entry = Entry::find( $id );

		$entry->delete();

		return Response::make( [ 'status' => 'entry deleted' ], 200 );
	}

	public function restoreEntry( $id )
	{
		$entry = Entry::find( $id );

		$entry->entry_deleted = 0;

		$entry->save();

		return Response::make( [ 'status' => 'entry enabled' ], 200 );
	}

}
