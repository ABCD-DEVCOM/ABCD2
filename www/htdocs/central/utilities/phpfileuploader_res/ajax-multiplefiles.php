<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start();
include("../../common/get_post.php");
$base=$arrHttp["base"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Ajax - Multiple files upload
	</title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		var handlerurl='../dbadmin/phpfileuploader/ajax-multiplefiles-handler.php'
	</script>
	<script type="text/javascript">

	function CuteWebUI_AjaxUploader_OnPostback()
	{
		var uploader = document.getElementById("myuploader");
		var guidlist = uploader.value;

		//Send Request
		var xh;
		if (window.XMLHttpRequest)
			xh = new window.XMLHttpRequest();
		else
			xh = new ActiveXObject("Microsoft.XMLHTTP");
		
		xh.open("POST", handlerurl, false, null, null);
		xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
		xh.send("guidlist=" + guidlist);

		//call uploader to clear the client state
		uploader.reset();

		if (xh.status != 200)
		{
			alert("http error " + xh.status);
			setTimeout(function() { document.write(xh.responseText); }, 10);
			return;
		}

		var filelist = document.getElementById("filelist");
var strlist="";
		var list = eval(xh.responseText); //get JSON objects
		//Process Result:
		for (var i = 0; i < list.length; i++)
		{
			var item = list[i];
			var msg = "Processed: " + list[i].FileName;
			var li = document.createElement("li");
			li.innerHTML = msg;
			filelist.appendChild(li);
strlist=strlist+list[i].FileName+"&*";

		}
document.import.fn.value=strlist;
document.import.base.value="<?php echo $base; ?>" ;
document.import.submit();
	}
	</script>

</head>
<body>
	<div class="demo">                        
        <h2>Please select the files to import</h2>
		
		    
			<?php
				$uploader=new PhpUploader();
				$uploader->MaxSizeKB=1024000;
				$uploader->Name="myuploader";
				$uploader->MultipleFilesUpload=true;
				$uploader->InsertText="Select multiple files (Max 25M)";
				$uploader->AllowedFileExtensions="*.pdf,*.html,*.doc,*.docx,*.xls,*.odt";
				include("../../config.php");
				if($cisis_ver!="")
				$dir=str_replace("cgi-bin/$cisis_ver","htdocs/bases",$cisis_path);
				else
				$dir=str_replace("cgi-bin","htdocs/bases",$cisis_path);
				$uploader->SaveDirectory=$dir.$base."/collection";	
				
				$uploader->Render();
			?>
					
			<ol id="filelist">
			</ol>		
	</div>
<form name="import" action="../dbadmin/import_doc.php" method="post"><br>
  <input type="hidden" name="fn">
  <input type="hidden" name="base">
  </form>
</body>
</html>
