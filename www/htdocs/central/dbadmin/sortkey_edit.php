<?php
/*
20220121 fho4abcd backbutton-> close button + div-helper + improve html + bug in enter value wih
*/

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
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Agregar("accent")
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
    include "../common/inc_close.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="sortkey.html";
include "../common/inc_div-helper.php>";
?>
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
?>
<table>
<tr>
    <th style="width:20ch"><?php echo $msgstr["r_desc"]?></th>
    <th style="width:60ch"><?php echo $msgstr["pftex"]?></th>
</tr>
</table>
<div id="accent">
<?php
foreach ($fp as $value){
	if (trim($value)!=""){
		$ix=$ix+1;
		$v=explode('|',$value);
        ?>
		<input type=text size=20 name=ac<?php echo $ix?> id=iac<?php echo $ix?> value="<?php echo $v[0]?>"> &nbsp;
		<input type=text size=60 name=nac<?php echo $ix?> id=inac<?php echo $ix?> value="<?php echo $v[1]?>"><br>
        <?php
	}
}
$ix=$ix+1;
for ($i=$ix;$i<$ix+5;$i++){
    ?>
	<input type=text size=20 name=ac<?php echo $i?> id=iac<?php echo $i?> value=''> &nbsp;
	<input type=text size=60 name=nac<?php echo $i?> id=inac<?php echo $i?> value=''><br>
    <?php
}
?>
</div><br>
<div><?php echo $msgstr["add"]?>
        <input type=text name=agregar size=3> <?php echo $msgstr["lines"];?> &nbsp;
        <a href='javascript:Agregar("accent")'><?php echo $msgstr["add"]?></a>
</div>

<?php
if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>\n";
?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<p><br><input type=submit value=<?php echo $msgstr["update"]?> onclick=javascript:Enviar()>
<input type=hidden name=ValorCapturado>
</form>
</div></div>
</body>
</html>