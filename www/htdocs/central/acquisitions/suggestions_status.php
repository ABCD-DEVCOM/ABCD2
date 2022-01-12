<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");

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
function Mostrar(Mfn){
	msgwin=window.open(\"../dataentry/show.php?base=".$arrHttp["base"]."&Mfn="."\"+Mfn,\"show\",\"width=600, height=600, scrollbars, resizable\")
	msgwin.focus()
}
</script>
";
echo "<body>\n";
include("../common/institutional_info.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

// Se ubican todas las solicitudes que estén pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificación
// se lee el título de las columnas de la tabla

//$arrHttp["sort"] ="";

switch($arrHttp["sort"]){
	case "TI":
		$index="ti.pft";
		$tit="ti_tit.tab";
		break;
	case "RB":
		$index="rb.pft";
		$tit="rb_tit.tab";
		break;
	case "DR":
		$index="dr.pft";
		$tit="dr_tit.tab";
		break;
	case "OP":
		$index="op_order.pft";
		$tit="op_order_tit.tab";
		break;
	default:
		$index="ti_decision.pft";
		$tit="ti_decision_tit.tab";		
}
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
$tit_tab=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($tit_tab)) $tit_tab=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit";
if (!file_exists($Formato)){
	echo $msgstr["missing"] ." $index";
	die;
}
if (!file_exists($tit_tab)){
	echo $msgstr["missing"] ." $tit";

}
$fp=file($tit_tab);
$tit_tab=implode("",$fp);
$Formato="@$Formato,/";
$Expresion="STA_0 ";
if (!isset($arrHttp["see_all"])) $Expresion.="and OPERADOR_".$_SESSION["login"];

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
		while (strlen($ix)<4) $ix="0".$ix;
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
	url="suggestions_status.php?base=suggestions&sort="+sort
	if (document.sort.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url

}
</script>
<?php

?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["approve"]."/".$msgstr["reject"]?>
	</div>
	<div class="actions">
	</div>
	<?php include("suggestions_menu.php")?>
</div>

<?php
$ayuda="acquisitions/approval_rejection.html";
include "../common/inc_div-helper.php";
?>

<form name=sort>
<div class="middle form">
	<div class="formContent">
         <h2><?php echo $msgstr["pending_sort"]?></h2>
		<div class="pagination">
			<a href='javascript:Enviar("TI")' class="bt bt-gray">
				<?php echo $msgstr["title"]?>
			</a>

			<a href='javascript:Enviar("RB")' class="bt bt-gray">
				<?php echo $msgstr["recomby"]?>
			</a>
			<a href='javascript:Enviar("DA")' class="bt bt-gray">
				<?php echo $msgstr["date_app"]?>
			</a>
			<a href='javascript:Enviar("OP")' class="bt bt-gray">
			 <?php echo $msgstr["operator"]?>
			</a>
			
			<p align=right>
				<input type=checkbox name=see_all
			<?php 
			if (isset($arrHttp["see_all"]) and $arrHttp["see_all"]=="Y") 
				echo "value=Y checked"?>> <?php echo $msgstr["all_oper"]?>
			</p>
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
		foreach ($r as $mfn){
			if ($ix1=="")
				$ix1=1;
			else
				if ($ix1==1){
					echo "<td nowrap>";

 					echo "<a  class=\"button_browse edit bt-green\" href=javascript:Editar($mfn)><i class=\"fas fa-edit\" alt=".$msgstr["edit"]." title=".$msgstr["edit"]."></i></a>&nbsp;";

					echo '<a class="button_browse show bt-blue" type="button" title='.$msgstr["show"].' href="javascript:Mostrar('.$mfn.')"><i class="far fa-eye" alt="'.$msgstr["show"].'" title="'.$msgstr["show"].'"></i> </a>';

					
					echo "

					</td>";
					$ix1=2;
				}else
	 				echo "<td>$mfn</td>";
		}

	}
?>
</table>

</div>
	</div>
</div>
</form>

<form name="EnviarFrm" method="post" action="suggestions_status_ex.php" >
	<input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>">
	<input type="hidden" name="Mfn" value="">
	<input type="hidden" name="Opcion" value="">
	<input type="hidden" name="sort" value=<?php echo $arrHttp["sort"]?>>
	<input type="hidden" name="retorno" value="../acquisitions/suggestions_status.php">
	<input type="hidden" name="encabezado" value="S">
	<?php 
		if (isset($arrHttp["see_all"])) 
			echo '<input type="hidden" name="see_all" value="S">';
	?>
</form>
<?php include("../common/footer.php");?>