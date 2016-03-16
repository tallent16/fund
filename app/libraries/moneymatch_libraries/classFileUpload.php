<?php namespace fileupload;
use File;
use Config;
use Storage;

class FileUpload {
	
	public function storeFile ($destinationPath,$file) {
		
		$s3BucketEnabled	=	false;
		if ($s3BucketEnabled) {
			//This will be implemented later 

		} else {
			$filename = $file->getClientOriginalName();
			$file->move($destinationPath, $filename);
		}
	}

	public function getFile ($destinationPath) {
		
		$s3BucketEnabled	=	false;
		if ($s3BucketEnabled) {
			$disk	=	Storage::disk('s3');
			
		} else {
			return	url()."/".$destinationPath;
		}
	}
	
	public function createIfNotExists($destinationPath) {
		// This method will look for the existence of the destination path and will create the folder 
		// if the folder does not exist

		$s3BucketEnabled = false; // S3 to be implemented later
		
		if (!$s3BucketEnabled) {
			$basePath = base_path();
			if(!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath, 0755, true);
			}
		} else {
			// Get the bucket details and create a folder in the bucket system
			$disk = Storage::disk('s3');
			if(!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath, 0755, true);
			}
			
			
		}
	
	}

}
