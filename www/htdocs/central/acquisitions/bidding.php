<?php
//
//Presenta la lista de sugerencias aprobadas
//SHOW THE LIST OF APPROVED SUGGESTIONS
//APPLIES THE SEARCH EXPRESSION "STA_1+or+STA_3" ON THE SUGGESTIONS DATABASE
// USES THE DISPLAY FORMATS
// BY TITLE: ti_bidding.pft,ti_bidding_tit.tab
// BY PROVIDER : rb_bidding.pft, rb_bidding_tit.tab
// BY DATE OF APPROVAL: da_bidding.pft, da_bidding_tit.tab
//

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
if(isset($_SESSION["permiso"]["ACQ_ACQALL"]))
	if (!isset($arrHttp["see_all"]))$arrHttp["see_all"]="Y";
include("../common/header.php");
$encabezado="";
echo "<script>
function Editar(Mfn){
	document.EnviarFrm.Mfn.value=Mfn
	document.EnviarFrm.Opcion.value=\"editar\"
	document.EnviarFrm.submit()
}
function Mostrar(Mfn){	msgwin=window.open(\"../dataentry/show.php?base=".$arrHttp["base"]."&Mfn="."\"+Mfn,\"show\",\"width=600, height=600, scrollbars, resizable\")
	msgwin.focus()}
</script>
";
echo "<body>\n";
include("../common/institutional_info.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

// Se ubican todas las solicitudes que estén pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificación
// se lee el título de las columnas de la tabla
switch($arrHttp["sort"]){	case "TI":
		$index="ti_bidding.pft";
		$tit="ti_bidding_tit.tab";
		break;
	case "RB":
		$index="rb_bidding.pft";
		$tit="rb_bidding_tit.tab";
		break;
	case "DA":
		$index="da_bidding.pft";
		$tit="da_bidding_tit.tab";
		break;
	case "OP":
		$index="op_bidding.pft";
		$tit="op_bidding_tit.tab";
		break;}
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
$tit_pft=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
if (!file_exists($Formato)){	echo $msgstr["missing"] ." $Formato";
	die;}
if (!file_exists($tit_pft)) $tit_pft=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit" ;
if (!file_exists($tit_pft)){
	echo $msgstr["missing"] ." $tit_pft";

}
$fp=file($tit_pft);
$tit_tab=implode("",$fp);
$Formato="@$Formato,/";
$Expresion="(STA_1 or STA_3)";        //recomendaciones aprobadas o en proceso de selección de proveedores
if (!isset($arrHttp["see_all"])) $Expresion.=" and OPERADOR_".$_SESSION["login"];
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){
	$value=trim($value);
	if ($value!="")	{		$ix=$ix+1;
		$s=explode('|',$value);
		$key=$s[0].$ix;
		$recom[$key]=$value;	}


}
ksort($recom);
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }
function Enviar(sort){
	url="bidding.php?base=suggestions&sort="+sort
	if (document.sort.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url

}
</script>
<?php

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["bidding"]?>
	</div>
	<div class="actions">
		<?php include("suggestions_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/bidding.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/bidding.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: bidding.php</font>\n";
?>
	</div>
<form name=sort>
<div class="middle form">
	<div class="formContent">
		<?php echo $msgstr["approved_rec"]." ".$msgstr["sorted"]?>
		<div class="pagination">
			<a href=javascript:Enviar("TI") class="singleButton singleButtonSelected">
						<span class="sb_lb">&#160;</span>
						[  <?php echo $msgstr["title"]?> ]
						<span class=sb_rb>&#160;</span>
					</a>
			<a href=javascript:Enviar("RB") class="singleButton singleButtonSelected">
						<span class="sb_lb">&#160;</span>
						[  <?php echo $msgstr["recomby"]?> ]
						<span class=sb_rb>&#160;</span>
					</a>
			<a href=javascript:Enviar("DA") class="singleButton singleButtonSelected">
						<span class="sb_lb">&#160;</span>
						[ <?php echo $msgstr["date_app"]?> ]
						<span class=sb_rb>&#160;</span>
					</a>
			<a href=javascript:Enviar("OP") class="singleButton singleButtonSelected">
						<span class="sb_lb">&#160;</span>
						[ <?php echo $msgstr["operator"]?> ]
						<span class=sb_rb>&#160;</span>
					</a>
			<p align=right><input type=checkbox name=see_all
			<?php if (isset($arrHttp["see_all"])) echo " value=Y checked"?>><?php echo $msgstr["all_oper"]?>
		</div>

		</h5>
	<table class=listTable cellspacing=0 border=1>
		<tr>

<?php
// se imprime la lista de recomendaciones pendientes
	echo "<th>&nbsp;</th>";
	$t=explode('|',$tit_tab);
	foreach ($t as $v)  echo "<th>".$v."</th>";

	foreach ($recom as $value){		echo "\n<tr>";		$r=explode('|',$value);
		$ix1="";
		foreach ($r as $cell){			if ($ix1=="")
				$ix1=1;
			else
				if ($ix1==1){					echo "<td nowrap><a href=javascript:Editar($cell)><img src=\"../images/edit.png\"></a>&nbsp;
					<a href=javascript:Mostrar($cell)><img src=\"../images/zoom.png\"></a>
					</td>";
					$ix1=2;				}else
	 				echo "<td>$cell</td>";		}

	}
?>
</table>

</div>
	</div>
</div>
</form>
<form name=EnviarFrm method=post action=bidding_ex.php>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=Mfn value="">
<input type=hidden name=Opcion value="">
<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
<input type=hidden name=retorno value=../acquisitions/bidding.php>
<input type=hidden name=encabezado value="S">
<?php if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";?>

</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>