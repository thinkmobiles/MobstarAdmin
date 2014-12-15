<?php

class EntriesController extends BaseController
{

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
		$category = ( Input::get( 'category', '0' ) );
		$category = ( !is_numeric( $category ) ) ? 0 : $category;

		$query = Entry::with( 'category', 'vote', 'user', 'file', 'entryTag.tag' )
					  ->where( 'entry_id', '>', '0' );

		if( $order_by == 'popular' )
		{
			$query = $query->where( 'entry_rank', '>', 0 );
		}

		if( $category )
		{
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
		$this->data[ 'sidenav' ][ 'entries' ][ 'page_selected' ] = true;

		$this->data[ 'entry' ] = !empty( $entry_id ) ? Entry::find( $entry_id ) : new Entries;

		$this->data[ 'users' ] = User::all();

		$this->data[ 'categories' ] = Category::all();

		$this->data[ 'reports' ] = Report::where( 'entry_report_entry_id', '=', $entry_id )->get();

		$this->data[ 'tags' ] = EntryTag::leftJoin( 'tags', function ( $join )
		{
			$join->on( 'entry_tags.entry_tag_tag_id', '=', 'tags.tag_id' );
		} )->where( 'entry_tag_entry_id', '=', $entry_id )->get();

		return View::make( 'entries/edit' )->with( 'data', $this->data );
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
		$this->data[ 'entry' ]->entry_description = $_POST[ 'entry_description' ];
		$this->data[ 'entry' ]->entry_active = $_POST[ 'entry_active' ];
		$this->data[ 'entry' ]->entry_modified_date = date( 'Y-m-d H:i:s' );

		if( empty( $this->data[ 'errors' ] ) )
		{
			$this->data[ 'entry' ]->save();
		}

		return View::make( 'entries/edit' )->with( 'data', $this->data );
	}

	public function delete( $id )
	{
		$entry = Entry::find( $id );

		$entry->entry_deleted = 1;

		$entry->save();

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
