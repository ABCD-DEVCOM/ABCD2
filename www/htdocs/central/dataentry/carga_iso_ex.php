<?
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");


if (!isset($arrHttp["accion"])) $arrHttp["accion"]="";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;
if ($arrHttp["accion"]=="eliminar"){
	$fp=$db_path."wrk/".$arrHttp["cnv"];
	if (file_exists($fp)) {
		$r=unlink($db_path."wrk/".$arrHttp["cnv"]);
	}
	header("Location: carga_iso.php?base=".$arrHttp["base"]."&Opcion=cnv&tipo=".$arrHttp["tipo"]);
	die;
}

include("../common/header.php");

function UseMx($db_path,$mx_path,$Dir){global $arrHttp,$msgstr;
	$base=$arrHttp["base"];
	$iso=$Dir."/".$arrHttp["cnv"];
	if (isset($arrHttp["tolinux"])){		echo $msgstr["tolinux"];
		echo "<xmp>tr -d \"\\015\" < ".$iso." > ".$Dir."/tmp.iso</xmp>";		exec("tr -d \"\\015\" < ".$iso." > ".$Dir."/tmp.iso");
		$iso=$Dir."/tmp.iso";	}
	if (isset($arrHttp["borrar"]))
		$accion=" create";
	else
		$accion=" append";
	if (isset($arrHttp["toansi"])){		$toansi=" convert=ansi";
		echo $msgstr["toansi"];	}else{
		$toansi="";
	}
	echo "<p>".$msgstr["importiso_mx"];
	$base=$db_path.$base."/data/$base";
	$command=$mx_path." iso=$iso $toansi $accion=$base -all now tell=1";

	echo "<xmp>".$command."</xmp>";
	exec($command, $output,$t);
	if (isset($arrHttp["tolinux"]))
		$r=unlink($iso);
	$straux="";
	for($i=0;$i<count($output);$i++){		$straux.=$output[$i]."<br>";
	}
	if ($t==0)
		$straux="<h3>process Output: ".$straux."<br>process Finished OK</h3><br>";
	else
		$straux="<h2>Out: <br>process NOT EXECUTED</h2><br>";
	return $straux;
}

?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_import"]." ".$msgstr["cnv_iso"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"carga_iso.php?base=".$arrHttp["base"]."&tipo=".$arrHttp["tipo"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["edhlp"]."</a>";
		echo "<font color=white>&nbsp; &nbsp; Script: dataentry/carga_iso_ex.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<form name=explora>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=tablacnv value="">
<?
$Dir=$db_path."wrk";
if (isset($arrHttp["accion"])){
	switch ($arrHttp["accion"]){
		case "importar":
			if (isset($arrHttp["toansi"]) or isset($arrHttp["usemx"]) ){				$cont=UseMx($db_path,$mx_path,$Dir);
				echo $cont;
				break;			}
			echo "<dd><table><td>";
			$IsisScript=$xWxis."export_txt.xis";
			$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=importar&archivo=$Dir/".$arrHttp["cnv"]."&borrar=".$arrHttp["borrar"];
			if (isset($arrHttp["fullinv"]))
				$query.="&fullinv=".$arrHttp["fullinv"];
			include("../common/wxis_llamar.php");
			foreach($contenido as $linea) {				$linea=trim($linea);
				$ix=strpos($linea,'[');
				if ($ix===false){
					echo "$linea<br>";
				}else{
					$ix1=strpos($linea,']');
					$msg=substr($linea,$ix+1,$ix1-$ix-1);
					echo substr($linea,$ix1+1)." ".$msgstr[$msg]."<br>";
				}
				flush();
    			ob_flush();

			}
			echo "</td></table>";
			break;

		case "ver":
			echo "<dd><table><td>";
			$IsisScript=$xWxis."iso_view.xis";
			$query="&iso_file=".$db_path."wrk/".$arrHttp["iso_file"];
			include("../common/wxis_llamar.php");
			$valortag=array();
			foreach($contenido as $linea){
				if (substr($linea,0,4)=="mfn="){  //para saltar la primera línea que tiene el mfn en el formato all
			        echo "<hr>";
				}
				echo $linea;
			}
			echo "</td></table>";
			break;
		default:

	}
}
echo "</form>";
if (!isset($arrHttp["fullinv"]))
	echo "<dd><h5><".$msgstr["recordarli"]."</h5>";
echo "</div></div>";
include("../common/footer.php");
?>