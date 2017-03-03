<!DOCTYPE html> <head> <meta charset="utf-8">
 <title>Import documents</title> 
 </head> <body onunload=win.close()> 

 <?php 
include("../common/get_post.php");
include("../config.php");
include("../common/get_post.php");
$base=$arrHttp['base'];
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
 echo "<br>".$_FILES["archivo"]["name"][$i]." uploaded to $carpetaDestino"; 
$fn.=$_FILES["archivo"]["name"][$i]."&*";
 }
 else
 { 
 echo "<br>Unable to upload: ".$_FILES["archivo"]["name"][$i]; 
 }

 }
 else
 { 
 echo "<br>Unable to create folder: up/".$user; 
 } 
 
 }

 }
 else
 { 
 echo "<br>"; 
 }
if($fn!="")
{
echo "<br><a href='javascript:send();'><br><img src='../images/importDatabase.png'><br>Start Import</a><br>"; 




}
 ?>
<h3> Digital document import</h3>
 <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion" target="_self" onsubmit="OpenWindows();"> 
Upload location <br><input type="text" name=cd size=75 value='<?php echo $img_path.$base;?>/collection/ABCDImportRepo/'><br><br>
 Select one or more files<br><input type="file" size=40 name="archivo[]" multiple="multiple"> 
<input type="hidden" name=base value="<?php echo $base;?>">
 <input type="submit" value="Send" class="trig"> 
 </form> 
<form name="import" method="post" action="../dbadmin/import_doc.php">
<input type="hidden" name=fn>
<input type="hidden" name=base>
<input type="hidden" name=cd>
</form>
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
 </body> </html>
