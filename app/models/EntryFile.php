<?php
use Aws\S3\S3Client;

class EntryFile extends \Eloquent {


	protected $table = "entry_files";
	protected $primaryKey = "entry_file_id";
	public $timestamps = false;

	protected $fillable = ['entry_file_name', 'entry_file_updated_date', 'entry_file_size'];


	public function entry()
	{
		return $this->belongsTo('Entry', 'entry_file_entry_id');
	}

	public static function s3Name($value, $type, $thumb = false)
	{
		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET
			);

		$s3 = S3Client::factory( $config );

		$thumbnail = ($thumb) ? "thumbs/" : "";
		$thumbnail_suffix = ($thumb) ? "-thumb.jpg" : "." . trim($type, '.');


		return $s3->getObjectUrl( Config::get('app.bucket'), $thumbnail . $value . "" . $thumbnail_suffix, '+10 minutes' );
	}


	private function getS3Client()
	{

		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET
		);

		return S3Client::factory( $config );
	}
}