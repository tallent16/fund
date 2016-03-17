<?php namespace fileupload;
use File;
use Config;
use Storage;

class FileUpload {
	
	public function storeFile ($destinationPath,$file) {
		
		$s3BucketEnabled	=	Config::get("moneymatch_settings.s3_bucket_enabled");
		if ($s3BucketEnabled) {
			$filename 				= 	$file->getClientOriginalName();
			$fullDestinationPath	=	$destinationPath."/".$filename;
			$disk					=	Storage::disk('s3');
			$disk->put($fullDestinationPath,file_get_contents($file));
			$disk->setVisibility($fullDestinationPath, 'public');
		} else {
			$filename = $file->getClientOriginalName();
			$file->move($destinationPath, $filename);
		}
	}

	public function getFile ($destinationPath) {
		
		$s3BucketEnabled	=	Config::get("moneymatch_settings.s3_bucket_enabled");
		if ($s3BucketEnabled) {
			$disk	=	Storage::disk('s3');
			$url = $disk->getDriver()->getAdapter()->getClient()->getObjectUrl(Config::get("filesystems.disks.s3.bucket"),
																	$destinationPath);
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

}
