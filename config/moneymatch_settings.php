<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Uploads Path For Admin, Borrower, Investor
	|--------------------------------------------------------------------------
	| Configure the uploads base path for Admin, Borrower,investor .
	|
	*/

	'upload_bor' => 'uploads/borrower',
	'upload_admin' => 'uploads/admin',
	'upload_inv' => 'uploads/investor',
	
	/*
	|--------------------------------------------------------------------------
	|Setting the Storage in local OR s3
	|--------------------------------------------------------------------------
	| Sets s3 enabled or disabled
	| if s3 set true means the file comes from s3 bucket
	| if false means file comes from local server
	|
	*/
	's3_bucket_enabled' => false,
	
	'auditSchema' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', 'localhost'),
			'database'  => env('DB_DATABASE', 'mm_audit'),
			'username'  => env('DB_USERNAME', 'moneyadmin'),
			'password'  => env('DB_PASSWORD', 'letmein1'),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
			'enableAudit' => true,
		],

];
