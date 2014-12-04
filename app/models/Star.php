<?php

class Star extends Eloquent {

	protected $table = 'user_stars';
	protected $primaryKey = 'user_star_id';
	public $timestamps = false;

}