<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHP Upload - Simple Upload with Progress</title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form name="import" action="../dbadmin/vmxISO_load.php" method="post"><br>
  <h2>Select the operation</h2>
  <select name="OpISO">
  <option>append</option>
  <option>create</option>
  </select>
  <input type="hidden" name="fn">
  <input type="hidden" name="base">
  </form>
	<div style=margin:10px>
	
        <h2>Select the file .iso</h2>
       
		<p>
		<?php
			$uploader=new PhpUploader();
			
			$uploader->MultipleFilesUpload=false;
			$uploader->InsertText="Upload File (Max 100M)";
			
			$uploader->MaxSizeKB=10240000;	
			$uploader->AllowedFileExtensions="iso";
			
			//Where'd the files go?
			include("../../config.php");
			$uploader->SaveDirectory=$db_path."/wrk";
			
			$uploader->Render();
			 include("../common/get_post.php");
  $base=$arrHttp["base"];
  
		?>
		</p>	
		
	<script type='text/javascript'>
	function CuteWebUI_AjaxUploader_OnTaskComplete(task)
	{
		//document.write(task.FileName + " is uploaded!");
		document.import.fn.value=task.FileName;
		document.import.base.value="<?php echo $base; ?>" ;
		document.import.submit();
		} 
		
	</script>		
	</div>
</body>
</html>
