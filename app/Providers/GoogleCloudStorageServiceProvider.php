<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;

class GoogleCloudStorageServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		
		Storage::extend('s3', function( $app, $config )
		 {
			$client = S3Client::factory([
						'credentials' => [
							'key'    =>  $config['key'],
							'secret' =>  $config['secret'],
						],
						'region' =>  $config['region'],
						'version' => 'latest',
					]);

			return new Filesystem(new AwsS3Adapter($client, $config['bucket']),'');
		});
    }

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
