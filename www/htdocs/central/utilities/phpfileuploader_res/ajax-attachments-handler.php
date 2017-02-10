<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php

$uploader=new PhpUploader();

if(@$_GET["download"])
{
	$fileguid=$_GET["download"];
	$mvcfile=$uploader->GetUploadedFile($fileguid);
	header("Content-Type: application/oct-stream");
	header("Content-Disposition: attachment; filename=\"" . $mvcfile->FileName . "\"");
	readfile($mvcfile->FilePath);
}

if(@$_POST["delete"])
{
	$fileguid=$_POST["delete"];
	$mvcfile=$uploader->GetUploadedFile($fileguid);
	unlink($mvcfile->FilePath);
	echo("OK");
}

if(@$_POST["guidlist"])
{
	$guidarray=explode("/",$_POST["guidlist"]);

	//OUTPUT JSON

	echo("[");
	$count=0;
	foreach($guidarray as $fileguid)
	{
		$mvcfile=$uploader->GetUploadedFile($fileguid);
		if(!$mvcfile)
			continue;
		
		//process the file here , move to some where
		//rename(...)	
		
		if($count>0)
			echo(",");
		echo("{");
		echo("FileGuid:'");echo($mvcfile->FileGuid);echo("'");
		echo(",");
		echo("FileSize:'");echo($mvcfile->FileSize);echo("'");
		echo(",");
		echo("FileName:'");echo($mvcfile->FileName);echo("'");
		echo("}");
		$count++;
	}
	echo("]");
}

exit(200);

?>