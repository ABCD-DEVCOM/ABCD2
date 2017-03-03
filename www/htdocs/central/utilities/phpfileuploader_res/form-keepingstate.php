<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Form - Keeping state after submitting
	</title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="demo"> 
			
			<h2>Keeping state after submitting</h2>
			<p>A sample demonstrates how to keep uploaded file state during page postbacks.</p>

			<!-- do not need enctype="multipart/form-data" -->
			<form id="form1" method="POST">
				<?php

				$uploader=new PhpUploader();
				$uploader->MaxSizeKB=10240;
				$uploader->MultipleFilesUpload=true;
				$uploader->Name="myuploader";
				$uploader->InsertText="Select multiple files (Max 10M)";
				$uploader->AllowedFileExtensions="*.jpg,*.png,*.gif,*.bmp,*.txt,*.zip,*.rar";	
				$uploader->Render();

				?>
				
				<br/><br/><br/>
				
<?php

$files=array();

$processedlist=@$_POST["processedlist"];
if($processedlist)
{
	$guidlist=explode("/",$processedlist);
	foreach($guidlist as $fileguid)
	{
		$mvcfile=$uploader->GetUploadedFile($fileguid);
		if($mvcfile)
		{
			array_push($files,$mvcfile);
		}
	}
}
$fileguidlist=@$_POST["myuploader"];
if($fileguidlist)
{
	$guidlist=explode("/",$fileguidlist);
	foreach($guidlist as $fileguid)
	{
		$mvcfile=$uploader->GetUploadedFile($fileguid);
		if($mvcfile)
		{
			//Process the file here..
			//rename(..)
			
			if($processedlist)
				$processedlist= $processedlist . "/" . $fileguid;
			else
				$processedlist= $fileguid;
		
			array_push($files,$mvcfile);
		}
	}
}

if(count($files)>0)
{
	echo("<table style='border-collapse: collapse' class='Grid' border='0' cellspacing='0' cellpadding='2'>");
	foreach($files as $mvcfile)
	{
		echo("<tr>");
		echo("<td>");echo("<img src='phpuploader/resources/circle.png' border='0' />");echo("</td>");
		echo("<td>");echo($mvcfile->FileName);echo("</td>");
		echo("<td>");echo($mvcfile->FileSize);echo("</td>");
		echo("</tr>");
		
		//Moves the uploaded file to a new location.
		//$mvcfile->MoveTo("/uploads");
		//Copys the uploaded file to a new location.
		//$mvcfile->CopyTo("/uploads");
		//Deletes this instance.
		//$mvcfile->Delete();
	}
	echo("</table>");
}

?>

				<input type='hidden' name='processedlist' value='<?php echo($processedlist) ?>' />

				<br /><br />
				<input type='submit' value="Submit Form" />
				Now: <?php echo(date("H:i:s",time())) ?>
				
			</form>
			
				
	</div>
</body>
</html>
