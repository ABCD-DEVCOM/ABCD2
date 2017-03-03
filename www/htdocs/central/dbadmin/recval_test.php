<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$vc=explode("\n",$arrHttp["ValorCapturado"]);
$Pft=array();
$ix=-1;
foreach ($vc as $var=>$value) {	$value=trim($value);	if ($value!=""){
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
foreach ($Pft as $value){	$ixt=$ixt+1;
	if (substr(trim($value["PFT"]),0,1)=="@"){		$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($value["PFT"],1));
		if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($value["PFT"],1));
		$value["PFT"]="@".$pft_file;
	}
	$formato= $formato."'".$ixt."|".$value["TAG"]."  ','  ',".$value["PFT"].",  /,mpl '$$$$'"  ;
	$Html[$ixt]="<tr><td bgcolor=white valign=top>".$value["TAG"]."</td><td bgcolor=white valign=top><font face=\"courier new\">".$value["PFT"]."</td>";
}
$formato=urlencode(trim($formato));
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
?>
<html>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
<?php echo "<a href=\"javascript:self.close()\" class=\"defaultButton cancelButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["close"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="middle form">
	<div class="formContent">
<?php

echo "<h5>&nbsp; &nbsp; Script: dbadmin/recval_test.php</h5>";
$recval_pft="";
$recval_pft=implode("<BR>",$contenido);
if (!strpos($recval_pft,'execution error')===false){
    echo $recval_pft;
   	die;
}

echo "<p><table bgcolor=#eeeeee cellspacing=3 border=0>
<tr><td>".$msgstr["tag"]."</td><td>".$msgstr["pftval"]."</td><td>".$msgstr["recval"]."</td></tr>";

$t=explode('$$$$',$recval_pft);
foreach ($t as $salida){	if (trim($salida)!=""){
		$ix_sal=explode('|',$salida);
	    $ixt=$ix_sal[0];
	    $salida=$ix_sal[1];
	    $ix=strpos($salida,' ');
	    if ($ix===false){	    	$campo="";	    }else{	    	$campo=substr($salida,$ix+1);	    }
		echo  $Html[$ixt];
		if ($campo!="")
			echo "<td valign=top bgcolor=white>".$campo."</td>\n";
		else
			echo "<td bgcolor=white>&nbsp;</td>";
	}
}
echo "<tr><td colspan=3><a href=javascript:self.close() class=>".$msgstr["close"]."</a></td></tr>";
echo "</table>";

echo "</div></div></body>
</html>";
?>