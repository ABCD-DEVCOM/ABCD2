<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHP Upload - Customizing the UI</title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="demo">
        <h2>Customizing the UI</h2>
		<p>A sample demonstrates how to customize the look and feel of file upload scripts. In this example, the appearance of a progress panel, progress text, upload button and cancel button have been customized (Allowed file types: <span style="color:red">jpg, gif, png, zip</span>). </p>		    
			<div style="padding:10px">			
				<img id="uploadbutton" title="Upload File" alt="Upload File" src="http://phpfileuploader.com/images/upload.png" />	
				<div id="uploaderprogresspanel" style='display:none;background-color:orange;border:dashed 2px gray;padding:4px;' BorderColor="Orange" BorderStyle="dashed">
					<span id="uploaderprogresstext" style='color:firebrick'></span>
				</div>
				
				<img id="uploadercancelbutton" style='display:none;' alt="Cancel" src="http://phpfileuploader.com/images/cancel_button.gif" />

				<?php

					$uploader=new PhpUploader();
					$uploader->MaxSizeKB=10240;
					$uploader->AllowedFileExtensions="jpeg,jpg,gif,png,zip";
					$uploader->Name="myuploader";

					//specify a button instead the uploader create it own button
					$uploader->InsertButtonID="uploadbutton";

					$uploader->MultipleFilesUpload=true;

					$uploader->ProgressCtrlID="uploaderprogresspanel";
					$uploader->ProgressTextID="uploaderprogresstext";
					$uploader->CancelButtonID="uploadercancelbutton";
					
					
			//Where'd the files go?
			//$uploader->SaveDirectory="/myfolder";
			
					$uploader->Render();

				?>
			</div>
	</div>
</body>
</html>

