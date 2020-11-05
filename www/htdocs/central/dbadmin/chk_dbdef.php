<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($_REQUEST  as $key=>$value)  echo "$key=$value<br>";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
?>
<body >
<?php

	include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["chk_dbdef"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"../dbadmin/menu_modificardb.php?reinicio=s&base=".$arrHttp["base"]."&encabezado=".$arrHttp["encabezado"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["back"]."</strong></span></a>";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
<?php
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=\"\" target=_blank>". $msgstr["help"].": abcdwiki.net</a>";

?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<form name=maintenance method=post>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=encabezado value=<?php echo $arrHttp["encabezado"]?>>

<?php
echo "<center><strong><font style='font-size:14px;'>".$msgstr["chk_dbdef"]."</font></strong></center>";
if (isset($msg_path))
	$path_this=$msg_path;
else
	$path_this=$db_path;
$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
$fp=file($a);
foreach ($fp as $value) {	$v=explode('=',$value);
	$lang_tab[$v[0]]=$v[1];}
$ll_t=$lang_tab;
echo "<h1>".$msgstr["def_lang"]." (lang.tab)</h1><br>";
$ixid=0;
foreach ($lang_tab as $v => $value){	echo "$v = $value ";
	$ixid=$ixid+1;
	if (!is_dir($db_path.$arrHttp["base"]."/pfts/$v")){
		echo " <font color=red>".$msgstr["falta"]." ".$db_path.$arrHttp["base"]."/pfts/$v</font>";
		echo " &nbsp; &nbsp; Create from ";
		foreach ($ll_t as $a=>$b){			if ($a !=$v) echo "&nbsp &nbsp;<input type=radio name=$a"."_$ixid value=$a> $a";		}
		echo " &nbsp; &nbsp;<input type=checkbox name=utf8_$ixid>Convert to utf8";
		echo "&nbsp; &nbsp; <a href=CrearDesde($ixid)>Crear</a>";
	}
	echo "<br>";
}
foreach ($lang_tab as $v => $value){
	if (is_dir($db_path.$arrHttp["base"]."/pfts/$v")){
  		echo "<h2>".$msgstr["analyzing"]." ".$db_path.$arrHttp["base"]."/pfts/$v</h2>";
  		Analizar('pfts',$db_path,$arrHttp["base"],$v);
	}
	echo "<br>";
}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
<?php
function Analizar ($tipo,$db_path,$base,$lang){global $msgstr;	switch ($tipo){		case 'pfts':
			$file="formatos.dat";
			echo "<br><font size=3><strong>formatos.dat</strong></font></br>";
			if (!file_exists($db_path.$base."/pfts/$lang/formatos.dat")){				echo "<font color=red>".$msgstr["falta"]." formatos.dat</font><br>";			}else{
				$fp=file($db_path.$base."/pfts/$lang/formatos.dat");
				foreach ($fp as $value){
					$value=trim($value);
					if ($value!=""){						echo $value;
						$v=explode('|',$value);
						$pft=trim($v[0]).".pft";
						if (!file_exists($db_path.$base."/pfts/$lang/$pft")) echo " <font color=red>".$msgstr["falta"]."</font>";
						echo "<br>";
					}				}
			}
			break;	}}