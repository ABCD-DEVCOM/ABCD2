<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$fd="date_".$arrHttp["codigo"];
if (isset($arrHttp[$fd])){	$Date=$arrHttp[$fd];
	$Date=substr($Date,6,4).substr($Date,3,2).substr($Date,0,2);
}
$sel="select_".$arrHttp["codigo"];

if (isset($arrHttp[$sel])){	$tipo=$arrHttp[$sel];
}
//die;
include("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");

function ErrorEnSalida($err){global $msgstr,$db_path,$institution_name,$meta_encoding;	include("../common/header.php");
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="menu.php" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
<div class="middle form">
	<div class="formContent">
<?php
echo "<h4>$err</h4></div></div>";
include ("../common/footer.php");
die;

}

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>"; die;
$bd=$arrHttp["base"];
if (file_exists($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst")){
	$fp=file($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst");
	foreach ($fp as $value){
		$value=trim($value);
		if (substr($value,0,2)=="//") continue;
		$l=explode('|',$value);
		if ($l[0]==$arrHttp["codigo"]){			$linea=$value;
			break;		}

	}
}

$l=explode('|',$linea);
$Disp_format=$l[1];
$Titles=$l[2];
$Sort=$l[3];
$Expresion=$l[4];
$Nombre=$l[5];
if (isset($l[6]) and $l[6]!=""){	$Ask=$l[6];}else{	$Ask="";}
if (isset($l[7]) and $l[7]!=""){
	$Tag=$l[7];
}else{
	$Tag="";
}
$headings="";
$msgerr="";
$Pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$Disp_format;
if (!file_exists($Pft)){	$Pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$Disp_format;}
if (!file_exists($Pft)){	$msgerr= $Disp_format. " ** ".$msgstr["falta"];
	$arrHttp["vp"]="";}

if ($Expresion!="") {
    $Opcion="buscar";
}else{
	$Opcion="rango";
}

if ($msgerr==""){
	if ($Ask!="" and $Tag!="")
		$Pft="v$Tag".'`$$$`,@'.$Pft;
	else
		$Pft='@'.$Pft;
	if (isset($def["EMAIL"]) and $def["EMAIL"]=="Y" )
		$email="/s2:=('Y')/" ;
	else
		$email="";
	$Pft=$email.$Pft;
	if ($Ask!=""){		switch ($Ask){			case "DATEQUAL":
				$Expresion=$Expresion.$Date;
				break;
			case "DATE":
				break;
			default:
				break;		}	}
	if ($Expresion!=""){		switch ($arrHttp["base"]){			case "trans":
				if (isset($arrHttp["Expresion_trans"]))
					$Expresion="(".$Expresion.")"." and (".$arrHttp["Expresion_trans"].")";
				break;
			case "suspml":
				if (isset($arrHttp["Expresion_suspml"]))
					$Expresion="(".$Expresion.")"." and (".$arrHttp["Expresion_suspml"].")";
				break;
			case "reserve":
				if (isset($arrHttp["Expresion_reserve"]))
					$Expresion="(".$Expresion.")"." and (".$arrHttp["Expresion_reserve"].")";
				break;		}	}
	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par&Expresion=".$Expresion."&Opcion=$Opcion&Formato=".$Pft;
	if ($Sort==""){
		$IsisScript=$xWxis."imprime.xis";
	}else{
		$query.='&sortkey='.urlencode($Sort);
		$IsisScript=$xWxis."sort.xis";
	}
	$contenido=array();
	include("../common/wxis_llamar.php");
	$data="\n";
	$encab="<H3>$Nombre ";
	if ($Ask!=""){		switch ($Ask){			case "DATE":
			case "DATEQUAL":
				if (isset($Date)) $encab.= "(". $arrHttp[$fd].")";
				break;
			default:
				if (isset($tipo) and $tipo !="") $encab.= "(". $tipo.")";
				break;		}	}
	$encab.= "<br>".$msgstr["o_issued"].": ".date("d-m-Y")."</h3>";
	if ($arrHttp["vp"] !="TB") $encab.= "<p><table border=0 width=100%>";
	if ($Titles!=""){		$h=explode('#',$Titles);
		foreach ($h as $value){			if ($arrHttp["vp"] =="TB")
				$data.=$value."\t";
			else				$data.="<td>$value</td>";		}	}
	if ($arrHttp["vp"] =="TB") $data.="\n";
	foreach ($contenido as $linea){
		if (trim($linea)!=""){
			$continuar="Y";			if ($Ask!="" and $Tag!=""){
				$out=explode('$$$',$linea);

				//if (!isset($out[1])) echo "$linea<br>";
				$linea=$out[1];
				$ff=$out[0];
				switch ($Ask){					case "DATE":
						if ($ff>=$Date)
							$continuar="Y";
						else
							$continuar="N";
						break;
					case "DATEQUAL":
						if ($ff==$Date)
							$continuar="Y";
						else
							$continuar="N";
						break;
					case "DATELESS":
						if ($ff<=$Date)
							$continuar="Y";
						else
							$continuar="N";
						break;
					default:
						if (isset($tipo) and $tipo!=""){
							if (strtoupper($ff)==strtoupper($tipo))
								$continuar="Y";
							else
								$continuar="N";
						}
						break;				}
			}
			if ($continuar=="Y"){
				$l=explode('|',$linea);
				if ($arrHttp["vp"]=="TB"){
					foreach ($l as $val)
						$data.=trim(strip_tags($val))."\t";
					$data.="\n";				}else{
					$data.="<tr>";
					foreach ($l as $val)
						$data.="<td valign=top>$val</td>";
					$data.="</tr>"."\n" ;
				}
			}
		}	}
}else{	ErrorEnSalida($msgerr);	die;
}
if (!isset($arrHttp["vp"])) $arrHttp["vp"]="";
switch ($arrHttp["vp"]){	case "WP":
    	$filename=$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		#echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		#echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		#echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		echo $encab;
		break;
	case "TB":
		$filename=$arrHttp["codigo"].".xls";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		break;
	case "TXT":
		$filename=$arrHttp["base"].".txt";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
   		echo $encab;
		break;
	default:
		include("../common/header.php");
		include("../common/institutional_info.php");
		if (isset($def["EMAIL"]) and $def["EMAIL"]=="Y" and $arrHttp["vp"]!="WP" and $arrHttp["vp"]!="TB" and $arrHttp["vp"]!="TXT" ){		echo "
<script>
	function GenerarCorreos(){		ixn=document.forma1.chk_p.length
    	result=\"N\"
		Seleccion=\"\"
    	for (i=0;i<ixn;i++){
    		if(document.forma1.chk_p[i].checked){
    			Seleccion=Seleccion+\"|\"+document.forma1.chk_p[i].value
    			result=\"S\"
    		}
    	}
    	if (result==\"N\"){
    		alert(\"Debe seleccionar los contactos\")
    		return
    	}
    	msgwin=window.open(\"\",\"Correos\",\"width=800, height=600, resizable, scrollbars, menubar,statusbar\")
    	document.forma1.target=\"Correos\"
    	document.forma1.contactos.value=Seleccion
    	document.forma1.action=\"correos.php\";
    	msgwin.focus()
    	document.forma1.submit()	}
	function Seleccionar(){
		if (document.forma1.chkall.checked)
			bool=1
		else
			bool=0
		for(i=0; i<document.forma1.elements.length; i++){
			Ctrl=document.forma1.elements[i].name
			if (Ctrl.substr(0,4)==\"chk_\"){
				if (bool==1){
					if(document.forma1.elements[i].checked==false){
						document.forma1.elements[i].checked=true
					}
				}else{
					document.forma1.elements[i].checked=false
				}
			}
		}
	}
</script>
";
}

?>
	<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="menu.php" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
<div class="middle form">
	<div class="formContent">

<?php
	if (isset($def["EMAIL"]) and $def["EMAIL"]=="Y" and $arrHttp["vp"]!="WP" and $arrHttp["vp"]!="TB" and $arrHttp["vp"]!="TXT" ){		echo "<form name=forma1  action=correo.php method=post>\n";
		echo "<input type=checkbox name=chkall onchange=Seleccionar()> ".$msgstr["selall"];
		echo "&nbsp &nbsp <input type=button name=generar value='".$msgstr["mailgenerate"]."' onclick=GenerarCorreos()>";
		echo " &nbsp; <a href=../dbadmin/leertxt.php?base=trans&desde=recibos&archivo=mail_dev.pft target=_blank>".$msgstr["edit"].": mail_dev.pft</a>";	}
	echo $encab;
	break;
}
echo $data;
if (isset($def["EMAIL"]) and $def["EMAIL"]=="Y" and $arrHttp["vp"]!="WP" and $arrHttp["vp"]!="TB" and $arrHttp["vp"]!="TXT" ){	echo "<input type=hidden name=contactos>\n";
	echo "</form>\n";
}
if ($arrHttp["vp"]!="TB")
	echo "</body></html>";

die;

?>
