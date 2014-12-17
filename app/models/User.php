<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable = array('user_name','user_email','user_password','user_full_name','user_display_name','user_surname','user_dob','user_user_group','user_activated','user_cover_image','user_profile_image');
	protected $hidden = array('user_password');

	protected $primaryKey = 'user_id';

	public static $rules = array(
		'user_password' => 'required',
		'user_email' => 'required'
	);

	public function getAuthIdentifier(){
		return $this->getKey();
	}

	public function getAuthPassword(){
		return $this->user_password;
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
        return $this->hasMany('Entry', 'entry_user_id');
    }

	public function TwitterUser()
	{
		return $this->hasOne( 'TwitterUser', 'twitter_user_id', 'user_twitter_id' );
	}

	public function GoogleUser()
	{
		return $this->hasOne( 'GoogleUser', 'google_user_id', 'user_google_id' );
	}

	public function FacebookUser()
	{
		return $this->hasOne( 'FacebookUser', 'facebook_user_id', 'user_facebook_id' );
	}

	public function getUserDisplayNameAttribute($value){
//		return var_dump($this->FacebookUser());
		if($value == "")
		{
			if($this->user_name != "")
				return $this->user_name;
			if($this->user_facebook_id != 0)
				return $this->FacebookUser->facebook_user_display_name;
			elseif($this->user_twitter_id != 0)
				return $this->TwitterUser->twitter_user_display_name;
			elseif($this->user_google_id != 0)
				return $this->GoogleUser->google_user_display_name;
		}
		else
			return $value;

	}

}