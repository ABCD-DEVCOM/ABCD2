<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
include("../common/get_post.php");

$t=explode("\n",stripslashes($arrHttp["ValorCapturado"]));
//echo "<table>";
$formato="";
$ixt=-1;
foreach ($t as $value) {	if (trim($value)!=""){
		$ix=strpos($value," ");
		$id=substr($value,0,$ix);
		$ix1=strpos($value," ",$ix+1);
		$it=substr($value,$ix,$ix1-$ix);
		$pft=substr($value,$ix1+1);
		$ixt=$ixt+1;
		$formato= $formato."'$ixt  ',x1,$pft,mpl '$$$$'"  ;
		$Html[$ixt]="<tr><td bgcolor=white valign=top>$id</td><td bgcolor=white valign=top>$it</td><td bgcolor=white valign=top>$pft</td>";
	}
}

$formato=urlencode(trim($formato));
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
?>
<html>
<title>FST test</title>


<body bgcolor=white>
<?php
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: fst_test.php</font>";
$fst_pft="";
foreach ($contenido as $linea)	{
    $fst_pft.=$linea."\n";}

 echo "<p><table bgcolor=#eeeeee>";
$t=explode('$$$$',$fst_pft);
foreach ($t as $salida){
	if (trim($salida)!=""){
		$ix=strpos($salida," ");
		$ix_fst=trim(substr($salida,0,$ix));
		$campo=trim(substr($salida,$ix));
		if (isset($Html[$ix_fst])){			echo  $Html[$ix_fst];
			if ($campo!="")
				echo "<td valign=top bgcolor=white><font size=1 face=arial>".nl2br($campo)."</td>";
			else
				echo "<td bgcolor=white><font size=1 face=arial>&nbsp;</td>";
		}else{			//echo "<br>$salida";		}
	}}
echo "</table>";

$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=ALL&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
include("../common/wxis_llamar.php");
echo "<font face=courier new size=2>";
foreach ($contenido as $linea){	if (trim($linea)!="") {
//		if (substr($linea,strlen($linea)-4,4)=="<BR>") $linea=substr($linea,0,strlen($linea)-4);
		echo "$linea\n";
	}
	$primero="N";
}



echo "</body>
</html>";
?>