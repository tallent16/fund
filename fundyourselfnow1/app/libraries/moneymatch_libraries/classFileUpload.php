<?php namespace fileupload;
use File;
use Config;
use Storage;

class FileUpload {
	
	public function storeFile ($destinationPath,$file,$prefix='') {
		
		$s3BucketEnabled	=	Config::get("moneymatch_settings.s3_bucket_enabled");
		if ($s3BucketEnabled) {
			$filename 				= 	$file->getClientOriginalName();
			$newfilename 			= 	 preg_replace('/\s+/', '_', $filename);
			$newfilename 			= 	$prefix.$newfilename;
			$fullDestinationPath	=	$destinationPath."/".$newfilename;
			$disk					=	Storage::disk('s3');
			$cmd = "s3cmd put ./img/404.jpg s3://devfyn/".$fullDestinationPath." 2>&1";
			$result = shell_exec($cmd);
			$disk->put($fullDestinationPath,file_get_contents($file));
			$disk->setVisibility($fullDestinationPath, 'public');
		} else {
			$filename 				= 	$file->getClientOriginalName();
			$newfilename 			= 	 preg_replace('/\s+/', '_', $filename);
			$newfilename 			= 	$prefix.$newfilename;
			$fullDestinationPath	=	$destinationPath."/".$newfilename;
			$file->move($destinationPath, $newfilename);
		}
		return $fullDestinationPath;
	}

	public function getFile ($destinationPath) {
		
		$s3BucketEnabled	=	Config::get("moneymatch_settings.s3_bucket_enabled");
		if ($s3BucketEnabled) {
			$disk	=	Storage::disk('s3');
			$url = $disk->getDriver()->getAdapter()->getClient()->getObjectUrl(Config::get("filesystems.disks.s3.bucket"),$destinationPath);
		
			return	$url;
		} else {
			return	url()."/".$destinationPath;
		}
	}
	
	public function createIfNotExists($destinationPath) {
		// This method will look for the existence of the destination path and will create the folder 
		// if the folder does not exist

		$s3BucketEnabled = Config::get("moneymatch_settings.s3_bucket_enabled");
		
		if (!$s3BucketEnabled) {
			
			if(!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath, 0755, true);
			}
		}
	
	}
	
	public function deleteFile ($filePath) {
		
		$s3BucketEnabled	=	Config::get("moneymatch_settings.s3_bucket_enabled");
		if ($s3BucketEnabled) {
			$disk					=	Storage::disk('s3');
			$cmd = "s3cmd del s3://devfyn/".$filePath." 2>&1";
			$result = shell_exec($cmd);
			if(strpos($result, 'ERROR') !== false)
				$disk->delete(trim($filePath));
			return;
		} else {
			File::Delete($filePath);
		}
	}
}
