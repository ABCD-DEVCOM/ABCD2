<?php
/*
20220108 fho4abcd backButton+ div helper+improve html
20230430 fho4abcd use inframe parameter. Always ISO characterset
20230705 fho4abcd No longer sequence warning
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
// Switch to ISO characterset because marc-8 is converted via single byte sequences
$charset="ISO-8859-1";
header('Content-type: text/html; charset='.$charset);
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../common/header.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$inframe=1;                      // The default runs in a frame
$backtoscript="../dbadmin/z3950_conf.php";
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
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
		nuevo+="\n<br><input type=text name=\"ac"+i+"\" id=\"iac"+i+"\" value=\""+valores_ac[i]+"\" size=3>&nbsp; &nbsp; &nbsp;<input type=text name=\"nac"+i+"\" id=\"inac"+i+"\" value=\""+valores_nac[i]+"\" size=3>";
		ix=i
	}
	if (agregar>0){
		for (i=1;i<=agregar;i++){
			ix++
			nuevo+="\n<br><input type=text name=\"ac"+ix+"\" id=\"iac"+ix+"\" value=\"\" size=3>&nbsp; &nbsp; &nbsp;<input type=text name=\"nac"+ix+"\" id=\"inac"+ix+"\" value=\"\" size=3>";
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
        		if (campo!="" && Trim(campo1)=="" || campo=="" && Trim(campo1)!=""){
        			alert("<?php echo $msgstr["ft_l"]?>"+": "+campo+"/"+campo1+" <?php echo $msgstr["specvalue"]?>")
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
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["z3950"]." &rarr;<br>".$msgstr["z3950_diacritics"] ?>
	</div>
	<div class="actions">
    <?php
    include "../common/inc_back.php";
	include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="z3950_conf.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form name=eacfrm method=post action="z3950_diacritics_update.php?base=<?php echo $arrHttp['base']?>" onsubmit="javascript:return false">
<?php
unset($fp);
$m2afile="cnv/marc-8_to_ansi.tab";
$file=$db_path.$m2afile;
if (file_exists($file))
	$fp=file($file);
else
	$fp[]="  ";
$ix=-1;
?>
<table align=center><tr><td>
<div id=accent>&nbsp; &nbsp; Marc-8 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ANSI
<?php
foreach ($fp as $value){
    $value=trim($value);
	if ($value!=""){
		$ix=$ix+1;
		$v=explode(" ",$value);
		?>
        <br>
        <input type=text size=3 name=ac<?php echo $ix?> id=iac<?php echo $ix?> value="<?php echo $v[0]?>">&nbsp; &nbsp; &nbsp;
		<input type=text size=2 name=nac<?php echo $ix?> id=inac<?php echo $ix?> value="<?php if (isset($v[1])) {echo $v[1];}?>"><?php
	}
}
$ix=$ix+1;
for ($i=$ix;$i<$ix+5;$i++){
    ?>
    <br>
    <input type=text size=3 name=ac<?php echo $i?> id=iac<?php echo $i?> value="">&nbsp; &nbsp; &nbsp;
    <input type=text size=2 name=nac<?php echo $i?> id=inac<?php echo $i?> value=""><?php
}
?>
</div>
</td>
<td style="color:blue" valign=top>
<ul>
    <li><?php echo $msgstr["z3950_charset"]?></li>
    <li><?php echo $msgstr["z3950_indep_seq"]?></li>
</ul>
</tr>
<tr><td>
<?php echo $msgstr["add"]?> &nbsp;
<input type=text name=agregar size=2> <?php echo $msgstr["lines"]?> &nbsp; 
<a href='javascript:Agregar("accent")' class="bt bt-gray"><?php echo $msgstr["add"]?></a>
</td>
<td style="text-align:center">
<input type=submit value='<?php echo $msgstr["update"]." &nbsp; ".$m2afile?>'
    onclick=javascript:Enviar() class="bt bt-green">
</td></tr>
</table>
<input type=hidden name=ValorCapturado>
<?php
if (isset($arrHttp["inframe"])) {
    ?>
	<input type=hidden name=inframe value="<?php echo $inframe?>" >
<?php } ?>
</form>
</div>
</div>
<?php
include "../common/footer.php"
?>