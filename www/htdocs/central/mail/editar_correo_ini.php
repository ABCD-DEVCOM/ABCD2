<?php
session_start();

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=>$value<br>";
if (!isset($_SESSION["login"])){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Enviar(){	document.maintenance.submit()}
</script>
<body >
<?php
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Distribución
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"";
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="actualizar")
	echo "index.php";
else
	echo "index.php";
echo "\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>Regresar</strong></span></a>";
if (!isset($arrHttp["Opcion"]) or $arrHttp["Opcion"]!=="actualizar"){
	echo "<a href=\"javascript:Enviar()\" class=\"defaultButton saveButton\">";
	echo "
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
			<span><strong>". $msgstr["save"]."</strong></span>
			</a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/distribucion.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: mail/editar_correo_ini.php";
$ini_vars=array("HOST","PORT","USERNAME","PASSWORD","FROM","FROMNAME","SUBJECT","TEST","PHPMAILER");
$ini=array();
if (file_exists("correo.ini")){	$fp=file("correo.ini");
	foreach ($fp as $key=>$value){
		$value=trim($value);
		if ($value!=""){
			$x=explode('=',$value);
			$ini[$x[0]]=$x[1];
		}
	}}
?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<form name=maintenance>
<input type=hidden name=Opcion value="actualizar">

<?php
if (!isset($arrHttp["Opcion"])){
	echo "<table cellspacing=5 width=400 align=center >";
	foreach ($ini_vars as $key){		echo "<tr>
		         <td>$key</td>
		         <td><input  name=ini_$key size=150 ";
		         if ($key=="PASSWORD" ) echo "type=\"password\""; else echo "type=\"text\"" ;
		         echo "value='";
		if (isset($ini[$key])) echo $ini[$key];
		echo "'></td></tr>\n";	}
	echo "</table>";
}else{    $fp=fopen("correo.ini","w");
    foreach ($arrHttp as $var=>$value){    	if (substr($var,0,4)=="ini_"){    		$tag=substr($var,4);
    		echo $var."=$value<br>";
    		fwrite($fp,$tag."=".trim($value)."\n");    	}    }
    fclose($fp);}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
