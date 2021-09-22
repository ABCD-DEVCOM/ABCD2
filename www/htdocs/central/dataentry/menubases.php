<?php
/* Modifications
2021-04-15 fho4abcd use charset from config.php+show charsets like institutional_info.php
2021-04-21 fho4abcd no undefined index for emergency user.
2021-05-03 fho4abcd Use include to select best language tables
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
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
include("leerregistroisispft.php");

$arrHttp["IsisScript"]="ingreso.xis";
if (isset($_SESSION["mfn_admin"])){
    $arrHttp["Mfn"]=$_SESSION["mfn_admin"];
} else {
    //Pointing to a user mfn in the acces database is not good.
    //The fake name is set in inicio.php
}

$fp = file($db_path."bases.dat");
if (!$fp){
	echo "falta el archivo bases.dat";
	die;
}
include("../common/header.php");
echo "<script>
top.listabases=Array()
top.basesdat=Array()\n";
foreach ($fp as $linea){
	$linea=trim($linea);
	if ($linea!="") {
		$ix=strpos($linea,"|");
		$ix_bb=explode('|',$linea);
		$llave=trim($ix_bb[0]);
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
		echo "top.listabases['$llave']='".trim(substr($linea,$ix+1))."'\n";
		echo "top.basesdat['$llave']='".$ix_bb[1]."'\n";
	}

}
echo "</script>\n";

?>

</head>
<body>

<?php

$verify_selbase="Y";

require_once ('../common/institutional_info.php');

?>



<script>
<?php
if (isset($arrHttp["inicio"]))
	$inicio="&inicio=s";
else
	$inicio="";
echo "top.menu.location.href=\"menu_main.php?base=\"+top.base+\"$inicio\"\n";?>
</script>
</body>
</html>

