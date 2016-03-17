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
];
