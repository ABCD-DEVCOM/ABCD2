<?php
/*
20220715 fho4abcd Use $actparfolder as location for .par files+div-helper+improve html+
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../common/header.php");
?>
<title>FST test</title>


<body bgcolor=white>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["maintenance"]." " .$msgstr["database"].": ".$arrHttp["base"]?>
    </div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
    <div class="formContent">
<?php
$t=explode("\n",stripslashes($arrHttp["ValorCapturado"]));
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
        $itstr="fst_".trim($it);
        $itdesc=$msgstr[$itstr];
		$Html[$ixt]="<tr><td bgcolor=white valign=top>$id</td><td bgcolor=white valign=top>$itdesc</td><td bgcolor=white valign=top>$pft</td>";
	}
}

$formato=urlencode(trim($formato));
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");

$fst_pft="";
foreach ($contenido as $linea)	{
    $fst_pft.=$linea."\n";}
?>
<table bgcolor=#eeeeee>
    <tr><th><?php echo $msgstr["id"]?></th>
        <th><?php echo $msgstr["intec"]?></th>
        <th><?php echo $msgstr["formate"]?></th>
        <th><?php echo $msgstr["value"]?></th>
    </tr>
<?php
$t=explode('$$$$',$fst_pft);
foreach ($t as $salida){	if (trim($salida)!=""){
		$ix=strpos($salida," ");
		$ix_fst=trim(substr($salida,0,$ix));
		$campo=trim(substr($salida,$ix));
		if (isset($Html[$ix_fst])){			echo  $Html[$ix_fst];
			if ($campo!="")
				echo "<td valign=top bgcolor=white><font size=1 face=arial>".nl2br($campo)."</font></td>";
			else
				echo "<td>&nbsp;</td>";
		}else{			//echo "<br>$salida";		}
	}}
?>
</table><br>
<?php

$query = "&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&Pft=ALL&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){	if (trim($linea)!="") {
//		if (substr($linea,strlen($linea)-4,4)=="<BR>") $linea=substr($linea,0,strlen($linea)-4);
		echo "$linea\n";
	}
	$primero="N";
}



echo "</body>
</html>";
?>