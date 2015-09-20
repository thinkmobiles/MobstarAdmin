<?php

class Entry extends Eloquent {

	protected $primaryKey = 'entry_id';
	public $timestamps = false;


	public function file()
	{
		return $this->hasMany( 'EntryFile', 'entry_file_entry_id' );
	}


	public function user()
	{
		return $this->belongsTo( 'User', 'entry_user_id' );
	}

	public function category()
	{
		return $this->belongsTo( 'Category', 'entry_category_id' );
	}

	public function subcategory()
	{
		return $this->belongsTo( 'SubCategory', 'entry_sub_category_id' );
	}

	public function vote()
	{
		return $this->hasMany( 'Vote', 'vote_entry_id' );
	}

	public function reports()
	{
		return $this->hasMany( 'EntryReport', 'entry_file_entry_id' );
	}

	public function entryTag()
	{
		return $this->hasMany( 'EntryTag', 'entry_tag_entry_id' );
	}

	public function comments()
	{
		return $this->hasMany( 'Comment', 'comment_entry_id' )->where( 'comment_deleted', '=', '0' );
	}


	public function viewsTotal()
	{
	    return $this->entry_views + $this->entry_views_added;
	}


	public function setViewsAdded( $newViewsAdded )
	{
	    if( $newViewsAdded < 0 ) return;

	    $userId = 1;

	    $viewsToAdd = $newViewsAdded - $this->entry_views_added;

	    if( $viewsToAdd == 0 ) return;

	    if ( $viewsToAdd > 0 ) {
	        $sql = 'insert into entry_views( entry_view_entry_id, entry_view_user_id, entry_view_date )
                values
            ';
	        $rows = array();
	        for( $i = 0; $i < $viewsToAdd; $i++ )
	        {
	            $rows[] = '('.$this->entry_id.', '.$userId.', now() )';
	        }
	        $sql .= implode( $rows, ",\n" );
	        $sql .= ";";
	        \DB::statement( $sql );

	        \DB::table('entries')
	            ->where( 'entry_id', '=', $this->entry_id )
	            ->increment( 'entry_views_added', $viewsToAdd );
	    }
	    else
	    {
	        $viewsToDelete = -1 * $viewsToAdd;

	        $deletedViews = \DB::delete('
	            delete from entry_views
	            where entry_view_entry_id='.(int)$this->entry_id.'
	            and entry_view_user_id='.(int)$userId.'
	            limit '.$viewsToDelete.'
	        ');

	        \DB::table('entries')
	            ->where( 'entry_id', '=', $this->entry_id )
	            ->decrement( 'entry_views_added', $deletedViews );
	    }
	}
}