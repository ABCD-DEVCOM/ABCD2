<?php
/*
20220202 fh04abcd buttons+div-helper
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");

include("../common/header.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script>

function CargarTabla(Tabla){
	url="picklist_edit.php?base=<?php echo $arrHttp["base"]?>&picklist="+Tabla+"&row=<?php echo $arrHttp["row"]?>&pl_type=<?php echo $arrHttp["pl_type"]?>&type=<?php echo $arrHttp["type"]?>"
    self.location.href=url
}

function EditCreate(){
	if (Trim(document.pl.picklist.value)==""){
		alert("<?php echo $msgstr["misfilen"].": ".$msgstr["picklistname"]?>")
		return
	}
	fn=document.pl.picklist.value
	bool=  /^[a-z][\w]+$/i.test(fn)
	bool=true
 	if (bool){

   	}
   	else {
      	alert("<?php echo $msgstr["errfilename"]?>");
      	return
   	}

	document.pl.submit()
}

function Pl_name(Tabla,DB){
		CargarTabla(Tabla)
		document.pl.picklist.value=Tabla
	}
function PickList_update(){
	row="<?php echo $arrHttp["row"]?>"
	name=self.document.pl.picklist.value
	if (window.top.frames.length>1){
		window.top.frames[2].valor=name
		window.top.frames[2].Asignar()
	}else{
		window.opener.valor=name
		window.opener.Asignar()
	}
	self.close()
}


function EliminarArchivo(){
	Tabla=Trim(document.pl.picklist.value)
	if (Tabla==""){
		alert("please, select the picklist to be deleted")
		return
	}
    document.frmdelete.tab.value=Tabla
    document.frmdelete.path.value="def"
    document.frmdelete.submit()
}
</script>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["picklist"]. ": " . $arrHttp["base"]?>
    </div>
    <div class="actions">
        <?php include "../common/inc_close.php";?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="picklist_tab.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form name=pl method=post action=picklist_edit.php>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=row value="<?php echo $arrHttp["row"]?>">
<input type=hidden name=type value="<?php echo $arrHttp["type"]?>">
<?php if (isset($arrHttp["pl_type"])) echo "<input type=hidden name=pl_type value=".$arrHttp["pl_type"].">\n"?>
<?php echo $msgstr["editcreatepl"]?> <span style='color:blue'><?php echo $msgstr["updfdt"]?></span><p>

<p><?php echo $msgstr["picklistname"]?>:<input type=text name=picklist value="<?php if (isset($arrHttp["picklist"]))echo $arrHttp["picklist"]?>">
&nbsp; &nbsp; <a href=javascript:EditCreate()><?php echo $msgstr["editcreate"]?></a>
&nbsp; | &nbsp;
<a href=javascript:EliminarArchivo()><?php echo $msgstr["delete"]?></a>
&nbsp; | &nbsp;
<a href=javascript:PickList_update()><?php echo $msgstr["updfdt"]?></a>
</form>
<form name=explora>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
$Dir=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"];
$DirHttp="";
$handle = opendir($Dir);
echo "<font face=verdana size=2>";
$the_array=array();
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file)){
            if  (substr($file,-4,4)==".tab") $the_array[$file]=$file;
        }else

            $dirs[]=$file;
   }
}
closedir($handle);
$Dir=$db_path.$arrHttp["base"]."/def/".$lang_db;
$handle = opendir($Dir);
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file)){
            if  (substr($file,-4,4)==".tab")
            	if (!isset($the_array[$file]))$the_array[$file]=$file;
        }
   }
}
$wks="";
if (isset($arrHttp["wks"])) $wks="&wks=".$arrHttp["wks"];
sort ($the_array);
reset ($the_array);

foreach ($the_array as $key=>$val) {
//	echo "key=".$key."<br>val=$val<br>wks=$wks<br>"  ;
   echo "<a href=javascript:Pl_name(\"$val\",\"".$arrHttp["base"]."\")>$val</a>; ";

}
?>
</td>
</table>

</form>
<div id="dwindow" style="position:relative;background-color:#ffffff;cursor:hand;left:0px;top:0px;height:200" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
<div id="dwindowcontent" style="height:100%;">
</div>
</div>
<form name=frmdelete action=delete_file.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=path>
<input type=hidden name=tab>
</form>
</body></html>
