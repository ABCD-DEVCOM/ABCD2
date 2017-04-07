<!DOCTYPE html> <head> <meta charset="utf-8">
 <title>Import documents</title> 
 </head> <body onunload=win.close()> 

 <?php 
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
echo '<div class="helper">';

if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_docbatchimport.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: upload_myfile.php</font>";
echo '</div>		
<div class="middle form">
	<div class="formContent">';
$base=$arrHttp['base'];
$arrHttp['encabezado']="s";
$fn="";

 # si hay algun archivo que subir 
 if($_FILES["archivo"]["name"][0]) 
 { 
$base=$_POST['base'];
 # definimos la carpeta destino 
 $carpetaDestino=$_POST['cd']; 
 # recorremos todos los arhivos que se han subido
 for($i=0;$i<count($_FILES["archivo"]["name"]);$i++) 
 { 
 
 # si exsite la carpeta o se ha creado 
 if(file_exists($carpetaDestino) || @mkdir($carpetaDestino)) { $origen=$_FILES["archivo"]["tmp_name"][$i]; $destino=$carpetaDestino.$_FILES["archivo"]["name"][$i]; 
 # movemos el archivo 
 if(@move_uploaded_file($origen, $destino)) 
 { 
 echo "<br>".$_FILES["archivo"]["name"][$i]." <font color='green'>uploaded to</font> $carpetaDestino"; 
$fn.=$_FILES["archivo"]["name"][$i]."&*";
 }
 else
 { 
 echo "<br><font color='red'>Unable to upload:</font> ".$_FILES["archivo"]["name"][$i]; 
 }

 }
 else
 { 
 echo "<br><font color='red'>Unable to create folder:</font> up/".$user; 
 } 
 
 }

 }
 else
 { 
 echo "<br>"; 
 }
if($fn!="")
{
	$arrHttp['base']=$base;
	echo "<br><br><form name='import' method='post' action='../utilities/docbatchimport.php'>
<input type='hidden' name=fn>
<input type='hidden' name='base' value='$base'>
<input type='hidden' name='cd'>
<input type='hidden' name='arrHttp' value='".$arrHttp."'>
CONTINUE <input type='submit' value='Configure Doc Import'>
</form>";
//echo "<a href='javascript:send();'><br><img src='../images/importDatabase.png'><br>Start Import</a><br>"; 
echo "<script>
document.getElementById('form_file').style.display='none';
</script>
";
}
//tomando valor de dr_path
//$fp=file($db_path.$base."/dr_path.def");
//foreach($fp as $line)
//{
//	$pos = strpos($line, "COLLECTION");
//	if ($pos !== false)
//	 {
//		$str_line=explode("=",$line);		
//		$collection=$str_line[1];
//	 }	$collection=trim($collection); 
//}
//echo "drpath=".$db_path.$base."/dr_path.def<BR>";
$def = parse_ini_file($db_path.$base."/dr_path.def");
	if (isset($def["COLLECTION"])){
        $collection=trim($def["COLLECTION"]);
        }
        else echo "Collection path not set in dr_path.def !";
if($collection=="")
{
$collection=$db_path."collections/".$base."/ABCDImportRepo/";
}
//end
 ?>
 <div id="form_file" style="display:block;">
<h3> Digital document import</h3>
 <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion" target="_self" onsubmit="OpenWindows();"> 
Upload destination on server <br><input type="text" name=cd size=75 value='<?php echo $collection; ?>'><br><br>
 Select one or more files<br><input type="file" size=40 name="archivo[]" multiple="multiple"> 
<input type="hidden" name=base value="<?php echo $base;?>">
 <input type="submit" value="Send" class="trig"> 
 </form></div> 
</div></div></div>
<script>
var win;
function send()
{
document.import.fn.value='<?php echo $fn;?>';
document.import.base.value='<?php echo $base;?>';
document.import.cd.value='<?php echo  $carpetaDestino;?>';
OpenWindows();
document.import.submit();
}


    function OpenWindows() {      
NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
win.focus()
    }	
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
 </script>
 </body> 
 <?php
include("../common/footer.php");
?>
 </html>
