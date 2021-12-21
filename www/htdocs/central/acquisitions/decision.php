<?php
/* Modifications
20210310 fho4abcd Replaced helper code fragment by included file
20210310 fho4abcd html code:body at begin+...
*/
//
// Presenta la lista de sugerencias que tienen proveedores asignados
// a fin de que se seleccione aquellos para los cuales se elaborará orden de compra
// SHOWS THE LIST OF THOSE SUGGESTIONS WHICH PROVIDERS WERE ASSIGNED IN THE BIDDING PROCCESS
// IN ORDER TO SELECT THE ONES FOR CREATING THE PURCHASE ORDER
//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/acquisitions.php");

include("../common/get_post.php");
if(isset($_SESSION["permiso"]["ACQ_ACQALL"]))
	if (!isset($arrHttp["see_all"])) $arrHttp["see_all"]="Y";
include("../common/header.php");
$encabezado="";
?>
<body>

<?php
include("../common/institutional_info.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

// Se ubican todas las solicitudes que estén pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificación
// se lee el título de las columnas de la tabla
if (isset($arrHttp["sort"])) {
	$sortkey=$arrHttp["sort"];
}	else {
	$sortkey='TI';
}
switch($sortkey){
	case "TI":
		$index="ti_decision.pft";
		$tit="ti_decision_tit.tab";
		break;
	case "RB":
		$index="rb_decision.pft";
		$tit="rb_decision_tit.tab";
		break;
	case "DA":
		$index="da_decision.pft";
		$tit="da_decision_tit.tab";
		break;
	case "OP":
		$index="op_decision.pft";
		$tit="op_decision_tit.tab";
		break;
	default:
		$index="ti_decision.pft";
		$tit="ti_decision_tit.tab";

}


$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
$tit_tab=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
if (!file_exists($Formato)){
	echo $msgstr["missing"] ." $Formato";
	die;
}
if (!file_exists($tit_tab)) $tit_tab=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit" ;
if (!file_exists($tit_tab)){
	echo $msgstr["missing"] ." $tit";

}
$fp=file($tit_tab);
$tit_tab=implode("",$fp);
$Formato="@$Formato,/";
$Expresion="(STA_1 or STA_3 or STA_4)";
if (!isset($arrHttp["see_all"])) $Expresion.=" and OPERADOR_".$_SESSION["login"];
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){
	$value=trim($value);
	if ($value!="")	{
		$ix=$ix+1;
		$s=explode('|',$value);
		$key=$s[0].$ix;
		$recom[$key]=$value;
	}



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
	url="decision.php?base=suggestions&sort="+sort
	if (document.sort.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url

}
</script>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["decision"]?>
	</div>
	<div class="actions">

	</div>
	<?php include("suggestions_menu.php")?>
</div>
<?php $ayuda="acquisitions/decision.html"; include "../common/inc_div-helper.php" ?>
<form name="sort">
<div class="middle form">
	<div class="formContent">
		<?php echo $msgstr["sugginbid"]." ".$msgstr["sorted"]?>
		<div class="pagination">
			<a href='javascript:Enviar("TI")' class="singleButton">
						<?php echo $msgstr["title"]?>
					</a>
			<a href='javascript:Enviar("RB"' class="singleButton">
						<?php echo $msgstr["recomby"]?>
					</a>
			<a href='javascript:Enviar("DA")' class="singleButton">
						 <?php echo $msgstr["date_app"]?>
					</a>
			<a href='javascript:Enviar("OP")' class="singleButton">
						 <?php echo $msgstr["operator"]?>
					</a>
			<p align=right><input type=checkbox name=see_all
			<?php if (isset($arrHttp["see_all"]) and $arrHttp["see_all"]=="Y") echo "value=Y checked"?>><?php echo $msgstr["all_oper"]?>
		</div>

	<table class="listTable browse">
		<tr>

<?php
// se imprime la lista de recomendaciones pendientes
	echo "<th>&nbsp;</th>";
	$t=explode('|',$tit_tab);
	foreach ($t as $v)  echo "<th>".$v."</th>";

	foreach ($recom as $value){
		echo "\n<tr>";
		$r=explode('|',$value);
		$ix1="";
		foreach ($r as $cell){
			if ($ix1=="")
				$ix1=1;
			else
				if ($ix1==1){
					?>
					<td>
						<button class="button_browse edit" type="button" onclick="Editar('<?php echo $cell; ?>')">
							<i class="fas fa-edit"></i>
						</button>
						<button class="button_browse show" type="button" onclick="Mostrar('<?php echo $cell; ?>')">
							<i class="far fa-eye"></i>
						</button>
					</td>
					<?php
					$ix1=2;
				}else
	 				echo "<td>$cell</td>";
		}

	}
?>
</table>

</div>
</div>
</form>


<script>
function Mostrar(Mfn){
    msgwin=window.open("../dataentry/show.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["base"]?>.par&Mfn="+Mfn+"&encabezado=s&Opcion=editar","show","width=600,height=400,scrollbars, resizable")
    msgwin.focus()
}


function Editar(Mfn){
        document.editar.Mfn.value=Mfn
        document.editar.Opcion.value="editar"
        document.editar.submit()
}

</script>


<!--FORM EDITION-->
<form name="editar" method="post" action="decision_ex.php">
    <input type="hidden" name="base" value="<?php echo $arrHttp["base"]; ?>">
    <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]; ?>.par">
    <input type="hidden" name="Mfn">
    <input type="hidden" name="sort" value="<?php echo $sortkey;?>">
    <input type="hidden" name="Opcion" value="editar">
    <?php


    if (isset($arrHttp["encabezado"])){
        echo "<input type=hidden name=encabezado value=s>\n";
    }
    if (isset($arrHttp["return"])){
        echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
    }
    if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";
    ?>
</form>
<!--./FORM EDITION-->




<?php include("../common/footer.php");
echo "</body></html>" ;
?>