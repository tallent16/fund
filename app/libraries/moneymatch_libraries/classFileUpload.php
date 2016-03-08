<?php namespace fileupload;

class FileUpload {
	
	public function storeFile ($destinationPath,$file) {
		
		$s3BucketEnabled	=	false;
		if ($s3BucketEnabled) {
			//Later this will implement
		} else {
			$filename = $file->getClientOriginalName();
			$file->move($destinationPath, $filename);
		}
	}


}
