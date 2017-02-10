<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");

function PresentarLeader($leader,$tc){	$fp=file($leader);
	foreach ($fp as $value){		$t=explode('|',$value);		echo "<tr><td bgcolor=white>".$t[2]."</td>";
		echo "<input type=hidden name=tag value=".$t[1].">";
		echo "<td bgcolor=white>".$t[1]."</td>";
		$tag=$t[1];
		echo "<td bgcolor=white><input type=text name=rotulo size=30 value=\"";
		if (isset($tc[$tag][0]))
			echo $tc[$tag][0];

		echo "\"></td>";
		echo "<td bgcolor=white class=td>text</td>";
		echo "<td bgcolor=white class=td><input type=hidden name=subc></td>";
		echo "<td bgcolor=white class=td><input type=hidden name=editsubc></td>";
		echo "<td bgcolor=white class=td><input type=hidden name=occ></td>";
		echo "<td bgcolor=white class=td><input type=text name=formato size=40 value=\"";
		if (isset($tc[$tag][5])) echo $tc[$tag][5];
		echo "\"></td>";	}}


if (!isset($arrHttp["accion"])) $arrHttp["accion"]="";

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";


if (!isset($arrHttp["proceso"]) or $arrHttp["proceso"]!="eliminar"){
include("../common/header.php");
?>
<script src=js/lr_trim.js></script>
<script language=javascript>
function Eliminar(Archivo){
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+Archivo)==true){
		url="carga_txt_cnv.php?base=<?php echo $arrHttp["base"]?>&cnv="+Archivo+"&Opcion=cnv&proceso=eliminar&lang=<?php echo $lang?>&accion=<?php echo $arrHttp["accion"]?>"
		self.location=url
	}
}
 function check( x )  {
    x = x.replace(/\*/g, "")      // delete *
   	x = x.replace(/\[/g, "")      // delete [
   	x = x.replace(/\]/g, "")      // delete ]
   	x = x.replace(/\</g, "")      // delete <
   	x = x.replace(/\>/g, "")      // delete >
   	x = x.replace(/\=/g, "")      // delete =
   	x = x.replace(/\+/g, "")      // delete +
   	x = x.replace(/\'/g, "")      // delete '
   	x = x.replace(/\"/g, "")      // delete "
   	x = x.replace(/\\/g, "")      // delete \
   	x = x.replace(/\//g, "")      // delete /
   	x = x.replace(/\,/g, "")      // delete ,
   	x = x.replace(/\./g, "")      // delete .
   	x = x.replace(/\:/g, "")      // delete :
   	x = x.replace(/\;/g, "")      // delete ;
   	x = x.replace(/ /g, "_")         // delete spaces
	return x
}
function GuardarTabla(){
	Tabla=""
	linea=""
	for (i=0;i<document.explora.rotulo.length;i++){

		rot=Trim(document.explora.rotulo[i].value)
		if (!document.explora.delimited.checked){
			if (rot!=""){
				if (rot.substr(0,2)!='$$'){
					alert("<?php echo $msgstr["cnv_inicior"]?>")
					return
				}
				if (rot.substr(rot.length-1,1)!=":"){
					alert("<?php echo $msgstr["cnv_finr"]?>")
					return
				}
			}
		}
		if (Trim(document.explora.rotulo[i].value)!=""){
			linea=document.explora.rotulo[i].value+"|"+document.explora.tag[i].value+"|"+document.explora.subc[i].value+"|"+document.explora.editsubc[i].value+"|"+document.explora.occ[i].value+"|"+document.explora.formato[i].value
			if (Tabla==""){
				Tabla=linea
			}else{
				Tabla+="!!"+linea
			}
		}
		if (Trim(document.explora.separador.value)=="" && !document.explora.delimited.checked){
			alert ("<?php echo $msgstr["cnv_separador"]?>")
			return
		}

	}
	document.explora.tablacnv.value=Tabla

	archivo=Trim(document.explora.fn.value)
	archivo=check(archivo)
	if (archivo==""){
		alert("<?php echo $msgstr["cnv_faltantc"]?>")
		return
	}
	document.explora.action="carga_txt_guardar.php";
	document.explora.fn.value=archivo
	document.explora.submit()

}

function AbrirVentana(){
	msgwin=window.open("","Nuevo","resizable=yes,width=600,height=500,top=0, left=0,scrollbars=yes,status=yes")
	msgwin.focus()
}

</script>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_".$arrHttp["accion"]]." ".$msgstr["cnv_".$arrHttp["tipo"]]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"administrar.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/carga_txt_cnv.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>

<form name=explora action=eliminararchivo.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=tablacnv value="">
<input type=hidden name=tipo value="txt">
<input type=hidden name=accion value=<?php echo $arrHttp["accion"]?>>
<?
}
$Dir=$db_path.$arrHttp["base"]."/".$arrHttp["Opcion"]."/";
$the_array = Array();
$handle = opendir($Dir);
if (!isset($arrHttp["proceso"]) or $arrHttp["proceso"]!="eliminar"){
	while (false !== ($file = readdir($handle))) {
	   if ($file != "." && $file != "..") {
	   		if(is_file($Dir."/".$file))
	            $the_array[]=$file;
	        else
	            $dirs[]=$Dir."/".$file;
	   }
	}
	closedir($handle);
	if (count($the_array)>0){
		sort ($the_array);
		reset ($the_array);
		$Url="";
		echo "<dd><b>".$msgstr["cnv_sel"]."</b>
		<a href=../documentacion/ayuda.php?help=$lang/conversion_table.html target=_blank><img src=img/helper_bg.png border=0 align=absmiddle>".$msgstr["help"]."</a>&nbsp; &nbsp;";
        if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
        	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/conversion_tabla.html target=_blank>".$msgstr["edhlp"]."</a>";
		echo "<dd><table><td>";
		echo "<table border=0  cellspacing=1 cellpadding=0 bgcolor=#cccccc>
		     <tr><td><Font size=1 face=arial>".$msgstr["ver"]."</td><td><Font size=1 face=arial>".$msgstr["seleccionar"]."</td><td><Font size=1 face=arial>".$msgstr["editar"]."</td><td><Font size=1 face=arial>".$msgstr["eliminar"]."</td><td><Font size=1 face=arial>".$msgstr["archivo"]."</td>
			 <tr>
		   			<td bgcolor=white width=10></td>
		   			<td bgcolor=white></td>
		   			<td bgcolor=white></td>
		   			<td bgcolor=white></td>
		   			<td bgcolor=white></td>";
		while (list ($key, $val) = each ($the_array)) {
		   echo "<tr>
		   			<td bgcolor=white width=10><a href=carga_txt_ver.php?base=".$arrHttp["base"]."&cnv=$val&lang=$lang target=_new><img src=img/preview.gif alt=\"".$msgstr["ver"]."\" border=0></a></td>
		   			<td bgcolor=white><a href=";
					if ($arrHttp["accion"]=="import")
						echo "carga_txt.php";
					else
						echo "exporta_txt.php";
					echo "?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&cnv=$val&lang=$lang&accion=".$arrHttp["accion"]."&tipo=".$arrHttp["tipo"]."><img src=img/aceptar.gif alt=\"".$msgstr["cnv_sel"]."\" border=0></a></td>
		   			<td bgcolor=white width=40><a href=carga_txt_cnv.php?base=".$arrHttp["base"]."&cnv=$val&Opcion=cnv&proceso=editar&lang=$lang&tipo=".$arrHttp["tipo"]."&accion=".$arrHttp["accion"]."><img src=img/barEdit.png border=0 alt=\"".$msgstr["editar"]."\"></a></td>
		   			<td bgcolor=white width=40><a href=javascript:Eliminar('$val')><img src=img/barDelete.png border=0 alt=\"".$msgstr["eliminar"]."\"></a></td>
					<td bgcolor=white><font face=verdana size=2 color=darkred><b>$val</b></td>";
		}
		echo "

		</table>
		</td>
		<td valign=top>
		<Font size=1 face=arial color=red>".$msgstr["ver"].": <font color=#222222>".$msgstr["cnv_avis"]."<br>
		<Font size=1 face=arial color=red>".$msgstr["seleccionar"].": <font color=#222222>".$msgstr["cnv_asel"]."<br>
		<Font size=1 face=arial color=red>".$msgstr["editar"].": <font color=#222222>".$msgstr["cnv_aedit"]."<br>
		<Font size=1 face=arial color=red>".$msgstr["eliminar"].": <font color=#222222>".$msgstr["cnv_aelim"]."<br>
		</td>
		</table>";
		echo "<hr>";
	}

}
$tc=array();
$rep="";
$separador="";
$delimited="";
$tit=$msgstr["nueva"];
if (isset($arrHttp["proceso"])){
	switch ($arrHttp["proceso"]){
		case "editar":
			$tit=$msgstr["editar"];
			$fp=file($db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"]);
			foreach ($fp as $value){				$value=trim($value);
				if ($rep==""){
					if ($value=='[TABS]'){
						$delimited=$value;
						$separador="";
						$rep="S";
					}else{
						$rep="S";
						$separador=$value;
					}
				}else{
					$a=explode('|',$value);
					$tc[$a[1]][0]=$a[0];  //rotulo
					$tc[$a[1]][1]=$a[1];  //tag
					$tc[$a[1]][2]=$a[2];  //subcampos
					$tc[$a[1]][3]=$a[3];  //delimitador
					$tc[$a[1]][4]=$a[4];  //ocurrencias
					$tc[$a[1]][5]=$a[5];  //formato
				}
			}
			break;
		case "eliminar":
			$fp=$db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"];
			if (file_exists($fp)) {
				$r=unlink($db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"]);
			}
			header("Location: carga_txt_cnv.php?base=".$arrHttp["base"]."&tipo=txt&Opcion=cnv&accion=".$arrHttp["accion"]);
			die;
			break;
		default:

	}
}

echo "<dd><h4>$tit ".$msgstr["cnv_tab"];
if (count($the_array)<=0) {	echo "&nbsp; <a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/conversion_table.html target=_blank><img src=img/helper_bg.png border=0>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
        	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/conversion_table.html target=_blank>".$msgstr["edhlp"]."</a>";
}
echo "</h4>";

$fpDb_fdt = $db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($fpDb_fdt)) {
	$fpDb_fdt = $db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
	if (!file_exists($fpDb_fdt)){
  			echo $arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt"." no existe";
		die;
	}
}
$fp=file($fpDb_fdt);


echo "<dd><input type=checkbox name=delimited ";
if ($delimited=="[TABS]") echo "checked";
echo ">".$msgstr["delimited_tab"];
echo "<dd><table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1 class=td>";
echo "<tr><td>".$msgstr["campo"]."</td><td>".$msgstr["tag"]."</td><td>".$msgstr["cnv_rotulo"]."</td><td>".$msgstr["tipo"]."</td><td>".$msgstr["subc"]."</td><td>".$msgstr["editsubc"]."</td><td with=10>".$msgstr["osep"]."</td><td nowrap>".$msgstr["pftex"]."</td>";
$ix=-1;

foreach ($fp as $value){
	$t=explode('|',$value);
	if ($t[0]!='G'){
		if ($t[0]=="LDR"){			PresentarLeader($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/leader.fdt",$tc);
			continue;		}
		$ix=$ix+1;
		$tag=$t[1];
		if ($tag!=""){
			echo "\n<tr><td bgcolor=white class=td>";
			echo $t[2];
			echo "</td>";
			echo "<td bgcolor=white class=td>".$tag."<input type=hidden name=tag value=".$tag."></td>";
			echo "<td bgcolor=white><input type=text name=rotulo size=30 value=\"";
			if (isset($tc[$tag][0])) echo $tc[$tag][0];
			echo "\"></td>";
			echo "<td bgcolor=white class=td>";
			$tipo=$t[7];
			switch ($tipo){
				case "O":
					echo "Option";
					break;
				case "C":
					echo "Check (Repetible)";
					break;
				case "A":
					echo "HTML";
					break;
				case "R":
					echo "Text (Repetible)";
					break;
				default:
					echo "Text";
					break;
			}
			echo "</td><td bgcolor=white class=td><input type=text name=subc size=10 value='";
			if (isset($tc[$tag][2]))
				echo $tc[$tag][2];
			else
				if ($t[5]!="" and ($tipo=="R" or $tipo=="")) echo $t[5];
			echo "'>";
			echo "</td><td bgcolor=white class=td><input type=text name=editsubc size=10 value='";
			if (isset($tc[$tag][3]))
				echo $tc[$tag][3];
			else
				//if (trim(substr($value,59,2))!="" and ($tipo=="R" or $tipo=="")) echo rtrim(substr($value,74,10));
				echo rtrim($t[6]);
			echo "'>";
			echo "</td><td bgcolor=white width=5><input type=text name=occ size=5 value=\"";
			if (isset($tc[$tag][4])) {
				echo $tc[$tag][4];
			}else{
				if ($t[4]==1)echo "R";
			}
			echo "\"></td><td bgcolor=white><input type=text name=formato size=40 value=\"";
			if (isset($tc[$tag][5])) echo $tc[$tag][5];
			echo "\"></td>";
		}
	}
}

echo "<tr><td colspan=8 bgcolor=linen>".$msgstr["cnv_sep"].": <input type=text size=5 name=separador value=\"$separador\"></td>";
$arch="";
if (isset($arrHttp["cnv"])){
	$ixpos=strpos($arrHttp["cnv"],".");
	$arch=substr($arrHttp["cnv"],0,$ixpos);
}
echo "<tr><td colspan=6 valign=top align=right><font color=darkred>".$msgstr["cnv_ntab"].": <input type=text size=20 name=fn value=$arch> .cnv <a href=javascript:GuardarTabla()><img src=img/barSave.png align=middle border=0></td>";
echo "</table>";
echo "</form>

</body></html>";
?>