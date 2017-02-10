<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Ajax - Build attachments table
	</title>
	<link href="demo.css" rel="stylesheet" type="text/css" />
			
	<script type="text/javascript">
		var handlerurl='ajax-attachments-handler.php'
		
		function CreateAjaxRequest()
		{
			var xh;
			if (window.XMLHttpRequest)
				xh = new window.XMLHttpRequest();
			else
				xh = new ActiveXObject("Microsoft.XMLHTTP");
			
			xh.open("POST", handlerurl, false, null, null);
			xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			return xh;
		}
	</script>
	<script type="text/javascript">
	
	var fileArray=[];
	
	function ShowAttachmentsTable()
	{
		var table = document.getElementById("filelist");
		while(table.firstChild)table.removeChild(table.firstChild);
		
		AppendToFileList(fileArray);
	}
	function AppendToFileList(list)
	{
		var table = document.getElementById("filelist");
		
		for (var i = 0; i < list.length; i++)
		{
			var item = list[i];
			var row=table.insertRow(-1);
			row.setAttribute("fileguid",item.FileGuid);
			row.setAttribute("filename",item.FileName);
			var td1=row.insertCell(-1);
			td1.innerHTML="<img src='phpuploader/resources/circle.png' border='0'/>";
			var td2=row.insertCell(-1);
			td2.innerHTML=item.FileName;
			var td4=row.insertCell(-1);
			td4.innerHTML="[<a href='"+handlerurl+"?download="+item.FileGuid+"'>download</a>]";
			var td4=row.insertCell(-1);
			td4.innerHTML="[<a href='javascript:void(0)' onclick='Attachment_Remove(this)'>remove</a>]";
		}
	}
	
	function Attachment_FindRow(element)
	{
		while(true)
		{
			if(element.nodeName=="TR")
				return element;
			element=element.parentNode;
		}
	}
	
	function Attachment_Remove(link)
	{
		var row=Attachment_FindRow(link);
		if(!confirm("Are you sure you want to delete '"+row.getAttribute("filename")+"'?"))
			return;
		
		var guid=row.getAttribute("fileguid");
		
		var xh=CreateAjaxRequest();
		xh.send("delete=" + guid);

		var table = document.getElementById("filelist");
		table.deleteRow(row.rowIndex);
		
		for(var i=0;i<fileArray.length;i++)
		{
			if(fileArray[i].FileGuid==guid)
			{
				fileArray.splice(i,1);
				break;
			}
		}
	}
	
	function CuteWebUI_AjaxUploader_OnPostback()
	{
		var uploader = document.getElementById("myuploader");
		var guidlist = uploader.value;

		var xh=CreateAjaxRequest();
		xh.send("guidlist=" + guidlist);

		//call uploader to clear the client state
		uploader.reset();

		if (xh.status != 200)
		{
			alert("http error " + xh.status);
			setTimeout(function() { document.write(xh.responseText); }, 10);
			return;
		}

		var list = eval(xh.responseText); //get JSON objects
		
		fileArray=fileArray.concat(list);

		AppendToFileList(list);
	}
	
	function ShowFiles()
	{
		var msgs=[];
		for(var i=0;i<fileArray.length;i++)
		{
			msgs.push(fileArray[i].FileName);
		}
		alert(msgs.join("\r\n"));
	}
	
	</script>
</head>
<body>
	<div class="demo">
        <h2>Building attachment table (AJAX)</h2>
		<p>This sample demonstrates how to build your own attachment table.</p>
		    
				<?php

				$uploader=new PhpUploader();
				$uploader->MaxSizeKB=10240;
				$uploader->Name="myuploader";
				$uploader->MultipleFilesUpload=true;
				$uploader->InsertText="Select multiple files (Max 10M)";
				$uploader->AllowedFileExtensions="*.jpg,*.png,*.gif,*.bmp,*.txt,*.zip,*.rar";		
				$uploader->Render();

				?>
			
			<br/><br/>

			<table id="filelist" style='border-collapse: collapse' class='Grid' border='0' cellspacing='0' cellpadding='2'>
			</table>
			
			<br/><br/>
			
			<button onclick="ShowFiles()">Show files</button>

	</div>
	
	<script type='text/javascript'>
	//this is to show the header..
	ShowAttachmentsTable();
	</script>
	
</body>
</html>

