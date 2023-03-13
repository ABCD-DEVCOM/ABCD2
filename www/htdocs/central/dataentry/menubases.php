<?php
/* Modifications
2021-04-15 fho4abcd use charset from config.php+show charsets like institutional_info.php
2021-04-21 fho4abcd no undefined index for emergency user.
2021-05-03 fho4abcd Use include to select best language tables
2022-01-20 fho4abcd Improve html + remove unused top.listabases + translate error
*/
global $valortag;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");
include("../config.php");

if (isset($arrHttp["lang"]) and  $arrHttp["lang"]!="")  $_SESSION["lang"]=$arrHttp["lang"];
include ("../lang/admin.php");
include ("../lang/lang.php");
//include("leerregistroisispft.php");

//$arrHttp["IsisScript"]="ingreso.xis";
if (isset($_SESSION["mfn_admin"])){
    $arrHttp["Mfn"]=$_SESSION["mfn_admin"];
} else {
    //Pointing to a user mfn in the acces database is not good.
    //The fake name is set in inicio.php
}
$basesdatfile=$db_path."bases.dat";
$fp = file($basesdatfile);
if (!$fp){
	echo $msgstr["falta"]." ".$msgstr["archivo"].": ".$basesdatfile;
	die;
}
include("../common/header.php");
?>
<body>
<script>
top.basesdat=Array()
<?php
foreach ($fp as $linea){
	$linea=trim($linea);
	if ($linea!="") {
		$ix=strpos($linea,"|");
		$ix_bb=explode('|',$linea);
		$llave=trim($ix_bb[0]);
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
		echo "top.basesdat['$llave']='".$ix_bb[1]."'\n";
	}
}
?>
</script>
<?php
$verify_selbase="Y";

require_once ('../common/institutional_info.php');

if (isset($arrHttp["inicio"]))
	$inicio="&inicio=s";
else
	$inicio="";
?>
<script>
top.menu.location.href="menu_main.php?base="+top.base+"<?php echo $inicio?>"
</script>
</body>
</html>

