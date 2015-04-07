<?php

class Blog extends Eloquent {

	protected $primaryKey = 'iBlogId';
	public $timestamps = false;
	protected $table = 'blogs';

}