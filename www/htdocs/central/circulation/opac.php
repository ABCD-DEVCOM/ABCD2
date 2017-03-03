<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
if (!isset($arrHttp["Expresion"])) $arrHttp["Expresion"]="";
include("../common/header.php");
echo "<body>
<div class=\"middle form\">
	<div class=\"formContent\">
<form name=forma1 method=post action=show.php>
<input type=hidden name=base value=".$arrHttp["base"].">
<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">
<input type=hidden name=Opcion value=".$arrHttp["Opcion"].">

	";
if (isset($arrHttp["Formato"])){	$Pft=$arrHttp["Formato"].".pft";}else{	$Pft=$arrHttp["base"].".pft";}
if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
if (!isset($arrHttp["to"])) $arrHttp["to"]="20";
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$Pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$Pft"  ;
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=".urlencode($arrHttp["Expresion"])."&Formato=@$Formato&Total=s&Opcion=buscar&from=".$arrHttp["from"]."&to=".$arrHttp["to"];
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$rec=0;
$total=0;
if (count($contenido)>0){
echo "<table bgcolor=#cccccc cellpadding=5>";
echo "<th>No.Inventario</th><th>Ubicación</th><th>Tipo Objeto</th><th>Situación</th><th>Disponibilidad</th>";
foreach ($contenido as $value){	$value=trim($value);
	echo "<tr>";	if (trim($value)!=""){		$y=explode('|',$value);
		echo "<td bgcolor=white>".$y[0]."</td><td bgcolor=white>".$y[1]."</td><td bgcolor=white>".$y[3]."</td>";
		echo "<td bgcolor=white>"." "."</td><td bgcolor=white>"." "."</td>";
	}
}
echo "</table>";
}
?>
</form>
</div>
</div>

</body>
</html>