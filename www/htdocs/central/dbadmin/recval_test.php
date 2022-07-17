<?php
/*
20220716 fho4abcd Use $actparfolder as location for .par files + div-helper + new style close button
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$vc=explode("\n",$arrHttp["ValorCapturado"]);
$Pft=array();
$ix=-1;
foreach ($vc as $var=>$value) {
	$value=trim($value);
	if ($value!=""){
		$ix=$ix+1;
		$Pft[$ix]["TAG"]=substr($value,0,4);
		$xx=substr($value,4);
		$xx=explode('$$|$$',$xx);
		$Pft[$ix]["PFT"]=urldecode($xx[0]);
		$Pft[$ix]["FATAL"]=$xx[1];
	}
}
$formato="";
$ixt=-1;
foreach ($Pft as $value){
	$ixt=$ixt+1;
	if (substr(trim($value["PFT"]),0,1)=="@"){
		$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($value["PFT"],1));
		if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($value["PFT"],1));
		$value["PFT"]="@".$pft_file;
	}
	$formato= $formato."'".$ixt."|".$value["TAG"]."  ','  ',".$value["PFT"].",  /,mpl '$$$$'"  ;
	$Html[$ixt]="<tr><td bgcolor=white valign=top>".$value["TAG"]."</td><td bgcolor=white valign=top><font face=\"courier new\">".$value["PFT"]."</td>";
}
$formato=urlencode(trim($formato));
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
?>
<html>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
    <?php include "../common/inc_close.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"?>
<div class="middle form">
	<div class="formContent">
<?php

$recval_pft="";
$recval_pft=implode("<BR>",$contenido);
if (!strpos($recval_pft,'execution error')===false){
    echo $recval_pft;
   	die;
}

echo "<p><table bgcolor=#eeeeee cellspacing=3 border=0>
<tr><td>".$msgstr["tag"]."</td><td>".$msgstr["pftval"]."</td><td>".$msgstr["recval"]."</td></tr>";

$t=explode('$$$$',$recval_pft);
foreach ($t as $salida){
	if (trim($salida)!=""){
		$ix_sal=explode('|',$salida);
	    $ixt=$ix_sal[0];
	    $salida=$ix_sal[1];
	    $ix=strpos($salida,' ');
	    if ($ix===false){
	    	$campo="";
	    }else{
	    	$campo=substr($salida,$ix+1);
	    }
		echo  $Html[$ixt];
		if ($campo!="")
			echo "<td valign=top bgcolor=white>".$campo."</td>\n";
		else
			echo "<td bgcolor=white>&nbsp;</td>";
	}
}
echo "</table>";

echo "</div></div></body>
</html>";
?>