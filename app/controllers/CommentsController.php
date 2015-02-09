<?php

class CommentsController extends BaseController {

	public function showEntryComment($comment_entry_id='')
	{
		$this->data['comment'] = Comment::leftJoin('users', function($join) {
			$join->on('comments.comment_user_id', '=', 'users.user_id');
		})->where('comment_entry_id','=',$comment_entry_id)->get();

		//echo '<pre>';dd(DB::getQueryLog());
    	return View::make('comments/main')->with('data', $this->data);
	}

	public function setstatus()
	{
		if(isset($_POST['id']) && !empty($_POST['id']))
		{
			$commentdata = Comment::find($_POST['id']);
			//print_r($commentdata);
			if($commentdata->comment_deleted == "0")
			{
				$commentdata->comment_deleted = "1" ; 
			}
			else
			{
				$commentdata->comment_deleted = "0" ; 
			}
			//echo $commentdata->comment_deleted;
			$commentdata->save();
			return Response::make( [ 'status' => 'comment status updated.','code'=> $commentdata->comment_deleted ], 200 ); 
		}
		else
		{
			return Response::make( [ 'status' => 'Pass the id for change the comment status','code'=>'2' ], 200 );
		}
		
	}

	public function commetDelete()
	{
		$id = trim($_POST['id']);
		$commentdata = Comment::find($id);
		if($commentdata->delete())
		{
			return Response::make( [ 'status' => 'Comment deleted successfully.','code'=> "1" ], 200 ); 
		}
		else
		{
			return Response::make( [ 'status' => 'Comment can not delete successfully.','code'=> "0" ], 200 ); 
		}
	}

	public function saveComment()
	{
		$id = trim($_POST['id']);
		$commentcontent = trim($_POST['comment']);
		if(!empty($commentcontent))
		{
			$this->data['comment'] = Comment::find($id);
			$this->data['comment']->comment_content = $commentcontent;
			$this->data['comment']->save();
			return Response::make( [ 'status' => 'Comment updated successfully.','code'=> "1" ], 200 );
		}
		else
		{
			return Response::make( [ 'status' => 'Comment can not update successfully.','code'=> "0" ], 200 );
		}
	}

}
