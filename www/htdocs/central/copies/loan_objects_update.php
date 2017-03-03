<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/acquisitions.php");

include("../lang/admin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
$base_ant=$arrHttp["base"];
$arrHttp["db_addto"]=$base_ant;
$arrHttp["base"]="loanobjects";
$xtl="";
$xnr="";
include("../dataentry/plantilladeingreso.php");
include("../dataentry/actualizarregistro.php");

//GET THE RECORD FROM LOANOBJECTS USING THE CONTROL NUMBER TO CHECK IF ALREADY LOADED (IN CASE OF REFRESH)
$Formato=$db_path."loanobjects/pfts/".$_SESSION["lang"]."/loanobjects_add.pft" ;
if (!file_exists($Formato)) $Formato=$db_path."loanobjects/pfts/".$lang_db."/loanobjects_add.pft"  ;
$Expresion="CN_".$base_ant."_".$arrHttp["cn"];
$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par"."&from=1&Formato=@$Formato&Opcion=buscar&Expresion=".urlencode($Expresion);
//echo $query;die;
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
//foreach ($contenido as $value) echo "$value<br>";
$c=implode("",$contenido);
$dup=array();
$variables["tag959"]="";
if (trim($c)==""){
	$arrHttp["Mfn"]="New";
	$arrHttp["Opcion"]="crear";
	$variables["tag1"]=$arrHttp["cn"];
	$variables["tag10"]=$base_ant;
}else{
	$arrHttp["Opcion"]="addocc";
	$ixc=0;
	foreach ($contenido as $value){
		$value=trim($value);
		if ($value!=""){
			if ($ixc==0){				$ixc=1;
				$v=explode('$$$',$value);
				$arrHttp["Mfn"]=$v[0];
				$value=$v[1];			}
			$inv=explode('|',$value);
			$dup[$inv[2]]="Y";
		}
	}
}
$vc=explode("\n",$arrHttp["ValorCapturado"]);
$arrHttp["ValorCapturado"]="";
$inventarios="";
foreach ($vc as $value){
	$value=trim($value);
	if ($value!=""){
		$ix=strpos($value,'^i');
		$ix=$ix+2;
		$ix1=strpos($value,'^',$ix);
		$inv=substr($value,$ix,$ix1-$ix);

		if (!isset($dup[$inv])) {			if ($variables["tag959"]=="")
				$variables["tag959"]=$value;
			else
				$variables["tag959"].="\n".$value;
	       $inventarios.="|".$inv;		};
	}
}
Print_page();
$base="loanobjects";
$cipar="$base.par";
if ($variables["tag959"]!="") {	ActualizarRegistro();

	if ($inventarios!=""){		$inven=explode('|',$inventarios);
		foreach ($inven as $value){			$value=trim($value);
			if ($value!=""){				$actualizar[$value]=CambiarStatusCopia($arrHttp["base"],$arrHttp["cn"],$value,$arrHttp["copy_status"]);			}		}	}
}

//GET THE RECORD FROM LOANOBJECTS USING THE CONTROL NUMBER
$Formato=$db_path."loanobjects/pfts/".$_SESSION["lang"]."/loanobjects_add.pft" ;
if (!file_exists($Formato)) $Formato=$db_path."loanobjects/pfts/".$lang_db."/loanobjects_add.pft"  ;
$Expresion="CN_".$base_ant."_".$arrHttp["cn"];
$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par"."&from=1&Formato=@$Formato&Opcion=buscar&Expresion=".urlencode($Expresion);
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$old_c=$contenido;
$ix=0;
foreach ($old_c as $value){
    if ($ix==0){    	$t=explode('$$$',$value);
    	$value=$t[1];
    	$t=explode('|',$value);
    	$ix=1;
    	$cn=$t[0];
    	$db=$t[1];
    	break;
    }
}
echo "<strong><a href=../dataentry/show.php?base=loanobjects&Expresion=CN_".$base_ant."_".$arrHttp["cn"]." target=blank>".$msgstr["cn"].": $cn ($db)</a></strong><br>";
echo "<table class=\"statTable\" cellspacing=5 cellpadding=5 width=100%>
		<tr>";
$archivo=$db_path."copies/pfts/".$_SESSION["lang"]."/copies_add.tit";
if (!file_exists($archivo))
	$archivo=$db_path."copies/pfts/".$lang_db."/copies_add.tit";
$fp=file($archivo);
foreach ($fp as $linea) {
	$l=explode('|',$linea);
	foreach ($l as $lx)
		if (trim($lx)!="")echo "<th>$lx</th>";
	break;
}
foreach ($old_c as $value){	if (trim($value)!=""){
		$t=explode("|",$value);
		echo "<tr><td align=center>";
		if (isset($t[2])){			 echo $t[2];
			 //if (isset($dup[$t[2]]))
			 //	echo "**";
		}
		echo "</td><td>";
		if (isset($t[3])) echo $t[3];
		echo "</td><td>";
		if (isset($t[4])) echo $t[4];
		echo "</td><td align=center>";
		if (isset($t[5])) echo $t[5];
		echo "</td><td align=center>";
		if (isset($t[6])) echo $t[6];
		echo "</td>";
		echo "<td align=center>";
		if (isset($t[7])) echo $t[7];
		//if (isset($dup_inv[0])) echo "**";
		echo "</td>";
	}
}
echo "</table>
</div>
</div>
";
include("../common/footer.php");
//=====================================

function CambiarStatusCopia($base,$cn,$inven,$status){global $msgstr,$arrHttp,$xWxis,$Wxis,$wxisUrl,$db_path;
	$Expresion="IN_".$inven;
	$IsisScript= $xWxis."buscar_ingreso.xis";
	$Pft="v1'|',v10'|',v20/";
	$query = "&base=copies&cipar=$db_path"."par/copies.par&Expresion=$Expresion&Pft=$Pft";
	include("../common/wxis_llamar.php");
	$Mfn="";
	foreach ($contenido as $linea){
		if (trim($linea)!=""){			if (substr($linea,0,6)=="[MFN:]"){
				$Mfn=substr($linea,6);
				break;
            }
		}
	}
	$ValorCapturado="d200<200 0>".$status."</200>";
	$ValorCapturado.="<500 0>^a".date("Ymd")."^b".$_SESSION["login"]."</500>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar.xis";
	$query = "&base=copies&cipar=$db_path"."par/copies.par&login=".$_SESSION["login"]."&Mfn=$Mfn&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
	//foreach ($contenido as $value) echo "???$value<br>";}

function Print_page(){
Global $arrHttp,$msgstr,$cn,$db;
	$encabezado="";
	include("../common/header.php");
	echo "<body>\n";
	if (isset($arrHttp["encabezado"])){
		include("../common/institutional_info.php");
		$encabezado="&encabezado=s";
	}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["loanobjects"]?>
	</div>
	<div class="actions">
		<a href="javascript:top.Menu('same' )" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
        </a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/copies/loan_objects_update.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/copies/loan_objects.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: loan_objects_update.php</font>\n";
echo "
	</div>
		<div class=\"middle list\">
";
}
?>
