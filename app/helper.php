<?php 
	use Aws\S3\S3Client;
	use Aws\Sns\SnsClient;

	function getSNSClient()
	{
		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET,
			'region' => 'eu-west-1'
		);

		return SnsClient::factory( $config );
	}

	function getS3Client()
	{

		$config = array(
			'key'    => Creds::ENV_KEY,
			'secret' => Creds::ENV_SECRET
		);

		return S3Client::factory( $config );
	}
	
?>