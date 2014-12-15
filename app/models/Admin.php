<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Admin extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable = array('admin_email','admin_password');
	protected $hidden = array('admin_password');

	protected $primaryKey = 'admin_id';

	public static $rules = array(
		'admin_password' => 'required',
		'admin_email' => 'required'
	);

	public function getAuthIdentifier(){
		return $this->getKey();
	}

	public function getAuthPassword(){
		return $this->admin_password;
	}

	public function getReminderEmail(){
		return $this->email;
	}

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}

	public function getRememberToken(){
	}

	public function setRememberToken($value){
	}

	public function getRememberTokenName(){
	}

	public function entries()
    {
        return $this->hasMany('Entry', 'entry_admin_id');
    }

}