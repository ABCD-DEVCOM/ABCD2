<?php require_once "include_phpuploader.php" ?>
<?php

set_time_limit(3600);

$uploader=new PhpUploader();

$uploader->PreProcessRequest();



$mvcfile=$uploader->GetValidatingFile();

if($mvcfile->FileName=="thisisanotvalidfile")
{
	$uploader->WriteValidationError("My custom error : Invalid file name. ");
	exit(200);
}


if( $uploader->SaveDirectory )
{
	if(!$uploader->AllowedFileExtensions)
	{
		$uploader->WriteValidationError("When using SaveDirectory property, you must specify AllowedFileExtensions for security purpose.");
		exit(200);
	}

	$cwd=getcwd();
	chdir( dirname($uploader->_SourceFileName) );
	if( ! is_dir($uploader->SaveDirectory) )
	{
		$uploader->WriteValidationError("Invalid SaveDirectory ! not exists.");
		exit(200);
	}
	chdir( $uploader->SaveDirectory );
	$wd=getcwd();
	chdir($cwd);

	$targetfilepath=  "$wd/" . $mvcfile->FileName;
	if( file_exists ($targetfilepath) )
		unlink($targetfilepath);

	$mvcfile->CopyTo( $targetfilepath );
}

$uploader->WriteValidationOK("");

?>