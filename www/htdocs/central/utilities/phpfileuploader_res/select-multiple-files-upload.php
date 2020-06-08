<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<link href="demo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form name="import" action="../dbadmin/import_doc.php" method="post"><br>
  <input type="hidden" name="fn">
  <input type="hidden" name="base">
  </form>
	<div class="demo">
        <h2>Select the documents (max. 25 mb for each document)</h2>
        <p> Allowed file types: <span style="color:red">html,htm,pdf,doc,docx,xls</span>).
		<p> 
		<?php
			$uploader=new PhpUploader();
			
			$uploader->MultipleFilesUpload=true;
			$uploader->InsertText="Upload Multiple File";
			
			$uploader->MaxSizeKB=125600;	
			$uploader->AllowedFileExtensions="html,htm,pdf,doc,docx,xls";
			
			//Where'd the files go?
			include("../../config.php");
			$uploader->SaveDirectory=$db_path."/wrk";
			
			include("../common/get_post.php");
  			$base=$arrHttp["base"];
			$uploader->Render();
		?>	
		</p>
	<script type='text/javascript'>

	function CuteWebUI_AjaxUploader_OnTaskComplete(task)
	{

		var div=document.createElement("DIV");
		div.innerHTML=task.FileName + " is uploaded!";

		document.body.appendChild(div);
document.import.fn.value=names;
		document.import.base.value="<?php echo $base; ?>" ;
		//document.import.submit();

		
	}

	</script>		
	</div>
</body>
</html>
