<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHP Upload - Simple Upload with Progress (Custom Validation) </title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="demo">
       <h2>Simple Upload with Progress (Custom Validation) </h2>
	<p> A sample demonstrating how to create user-defined validation functions for an upload script. In this example, we defined two validation rules:</p>
	<ul>
	    <li>Maximum file size: 100K</li>
	    <li>Allowed file types: <span style="color:red">jpeg, jpg, gif,png </span></li>
	</ul>
	<p>Click the following button to upload.</p>

		<?php
			$uploader=new PhpUploader();
			
			$uploader->MultipleFilesUpload=true;
			$uploader->InsertText="Upload (Max 100K)";
			
			$uploader->MaxSizeKB=100;	
			$uploader->AllowedFileExtensions="jpeg,jpg,gif,png,zip";
			
			//Where'd the files go?
			//$uploader->SaveDirectory="/myfolder";
			
			$uploader->Render();
		?>	
		
	<script type='text/javascript'>
	function CuteWebUI_AjaxUploader_OnTaskComplete(task)
	{
///		alert(task.FileName + " is uploaded!");
	}
	</script>		
	</div>
</body>
</html>
