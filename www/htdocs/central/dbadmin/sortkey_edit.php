<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../common/header.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Agregar()
			return true;
	}

var valores_ac=new Array()
var valores_nac=new Array()

function LeerValores(){
	val=""
	j=-1;
	for (i=0;i<document.eacfrm.elements.length;i++){
        	tipo=document.eacfrm.elements[i].type
        	nombre=document.eacfrm.elements[i].name
        	if (nombre.substr(0,2)=="ac" || nombre.substr(0,3)=="nac"){

        		if (nombre.substr(0,2)=="ac"){
        			j++
        			valores_ac[j]= document.eacfrm.elements[i].value
        		}
        		if (nombre.substr(0,3)=="nac"){
        			valores_nac[j]= document.eacfrm.elements[i].value
        		}
        	}

 	}
}

function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function Agregar(IdSec){
	agregar=document.eacfrm.agregar.value
    ix=0
	nuevo=""
	LeerValores()
	for (i=0;i<valores_ac.length;i++){
		nuevo+="\n<br><input type=text name=\"ac"+i+"\" id=\"iac"+i+"\" value=\""+valores_ac[i]+"\" size=20>&nbsp; &nbsp; &nbsp;<input type=text name=\"nac"+i+"\" id=\"inac"+i+"\" value=\""+valores_nac[i]+"\" size=80>";
		ix=i
	}
	if (agregar>0){
		for (i=1;i<=agregar;i++){
			ix++
			nuevo+="\n<br><input type=text name=\"ac"+ix+"\" id=\"iac"+ix+"\" value=\"\" size=20>&nbsp; &nbsp; &nbsp;<input type=text name=\"nac"+ix+"\" id=\"inac"+ix+"\" value=\"\" size=80>";
		}
	}
	seccion=returnObjById( IdSec )
	seccion.innerHTML = nuevo;
}

function Enviar(){
	j=-1;
	ValorCapturado=""
	for (i=0;i<document.eacfrm.elements.length;i++){
        tipo=document.eacfrm.elements[i].type
        nombre=document.eacfrm.elements[i].name
        if (nombre.substr(0,2)=="ac" || nombre.substr(0,3)=="nac"){
        	val=""

        	if (nombre.substr(0,2)=="ac"){
        		j++
        		val=Trim( document.eacfrm.elements[i].value)
        		campo=val
        		campo1=""
        		valores_ac[j]=val
        	}
        	if (nombre.substr(0,3)=="nac"){
        		valores_nac[j]= document.eacfrm.elements[i].value
        		campo1=valores_nac[j]
        		if (val!="" && Trim(valores_nac[j]=="")){
        			alert("Línea: "+i+" Debe especificar el valor")
        			return
        		}
        	}
        	if (campo!="" && campo1!="")
        		ValorCapturado+=campo+"|"+ campo1+"\n"
        }
 	}
	document.eacfrm.ValorCapturado.value=ValorCapturado
	document.eacfrm.submit()
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["sortkeycreate"]." (".$arrHttp["base"].")" ?>
	</div>

	<div class="actions">
<?php
	if ($encabezado!="") echo "<a href=javascript:self.close() class=\"defaultButton cancelButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["close"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/sortkey.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/sortkey.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: sortkey_edit.php </font>";
?>
	</div>
<div class="middle form">
			<div class="formContent">
<form name=eacfrm method=post action=sortkey_update.php onsubmit="javascript:return false">
<?php
unset($fp);
$file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab";
if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab";
if (file_exists($file))
	$fp=file($file);
else
	$fp[]="  ";
$ix=-1;
echo "<center>";
echo $msgstr["r_desc"]." &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;
 &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;   ".$msgstr["pftex"]."
 &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; ";
echo "<div id=accent>";
foreach ($fp as $value){	if (trim($value)!=""){
		$ix=$ix+1;
		$v=explode('|',$value);
		echo "<br>";
		echo "<input type=text size=20 name=ac$ix id=iac$ix value=\"".$v[0]."\">&nbsp; &nbsp; &nbsp;";
		echo "<input type=text size=60 name=nac$ix id=inac$ix value=\"".$v[1]."\">";
	}}
$ix=$ix+1;
for ($i=$ix;$i<$ix+5;$i++){	echo "<br>";
	echo "<input type=text size=20 name=ac$i id=iac$i value=\"\">&nbsp; &nbsp; &nbsp;";
	echo "<input type=text size=60 name=nac$i id=inac$i value=\"\">";
}

echo "</div><br>";
echo "<font face=arial size=2>";
echo $msgstr["add"]." <input type=text name=agregar size=3> ".$msgstr["lines"];
echo " &nbsp; <a href='javascript:Agregar(\"accent\")'>".$msgstr["add"]."</a>";

if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>\n";
?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<p><br><input type=submit value=<?php echo $msgstr["update"]?> onclick=javascript:Enviar()>
<input type=hidden name=ValorCapturado>
</form>

</body>
</html>