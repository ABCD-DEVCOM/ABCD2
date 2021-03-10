<?php
/* Modifications
20210310 fho4abcd Replaced helper code fragment by included file
20210310 fho4abcd html code:body at begin
20210310 fho4abcd improved selection and error message of pft and order table
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/acquisitions.php");
include("../lang/admin.php");
include("../common/get_post.php");
include("../common/header.php");
$encabezado="";
?>
<body>
<script>
xEliminar=""
Mfn_eliminar=''
function Mostrar(Expresion){
	msgwin=window.open("../dataentry/show.php?base=suggestions&Expresion=CN_"+Expresion,"show"," width=550,height=400,resizable, scrollbars")
	msgwin.focus()}
function Editar(Mfn){
	document.EnviarFrm.Mfn.value=Mfn
	document.EnviarFrm.Opcion.value="editar"
	document.EnviarFrm.submit()

}

function Delete(Mfn){
		if (xEliminar==""){
			alert("".$msgstr["confirmdel"]."")
			xEliminar="1"
			Mfn_eliminar=Mfn
		}else{
			if (Mfn_eliminar!=Mfn){
				alert("".$msgstr["mfndelchanged"]."")
				xEliminar=""
                return
			}
			xEliminar=""
			document.eliminar.Mfn.value=Mfn
			document.eliminar.submit()
		}
	}
</script>
<?php
$arrHttp["base"]="purchaseorder";
$index="pv_order.pft";
$tit="pv_order_tit.tab";
include("../common/institutional_info.php");

// Se ubican todas las solicitudes que estén pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificación
// se lee el título de las columnas de la tabla

$Formato_order=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
if (!file_exists($Formato_order)) $Formato_order=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
if (!file_exists($Formato_order)){
	echo "<div><font color=red>".$msgstr["missing"]." file: ".$Formato_order."</font></div>";
	die;}
$tit_o=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($tit_o)) $tit_o=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit" ;
if (!file_exists($tit_o)){
	echo "<div><font color=red>".$msgstr["missing"]." file: ".$tit_o."</font></div>";
	die;
}
$fp=file($tit_o);
$tit_tab=implode("",$fp);

$Formato="@$Formato_order,/";
$Expresion="";
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=1&Formato=$Formato&Opcion=buscar&Expresion=PO_$";
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
function EnviarForma(){	sel="N"	if (ncheck==0){		if (document.order.oc.checked){			alert(document.order.oc.value)
			sel="S"		}	}else{		Mfn=""		for (i=0;i<ncheck;i++){			if (document.order.oc[i].checked){
				Mfn+=document.order.oc[i].value+"\n"
				sel="S"
			}		}	}
	if (sel=="N"){		alert("<?php echo $msgstr["err_order"]?>")
		return	}
	document.order.Mfn_sel.value=Mfn
	document.order.submit()}

</script>
<?php

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["pending"];?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>

<div class="middle form">
	<div class="formContent">
	<table class=listTable cellspacing=0 border=0>
		<tr>

<?php
// se imprime la lista de recomendaciones pendientes
	$t=explode('|',$tit_tab);
	echo "<th>&nbsp;</th>";
	foreach ($t as $v)  echo "<th>".$v."</th>";
    $ixelem=0;
	foreach ($recom as $value){		$r=explode('|',$value);
//		if ($r[8]=="OK")    // Se verifica si ya existe una órden para ese proveedor y ese objeto
//			$check="NO";
//		else
			$check="SI";
		$ix1=-1;
		if ($check=="SI"){			echo "\n<tr>";
			foreach ($r as $cell){				$ix1=$ix1+1;
				if ($ix1==1){					echo "<td nowrap><a href=javascript:Editar($cell)><img src=\"../images/edit.png\"></a>&nbsp;
					<a href=javascript:Delete($cell)><img src=\"../images/delete.png\"></a>&nbsp;
					</td>";				}				if ($ix1>1){
					echo "<td>$cell</td>";
				}			}
        }
	}
?>
</table>
</div>
</div>
<form name=EnviarFrm method=post action=pending_order_ex.php>
<input type=hidden name=base value="purchaseorder">
<input type=hidden name=Mfn value="">
<input type=hidden name=Opcion value="">
<input type=hidden name=encabezado value="S">

</form>
<?php echo "\n<script>ncheck=$ixelem</script>\n" ?>
<?php include("../common/footer.php");
?>
<form name=eliminar method=post action=../dataentry/eliminar_registro.php>
 <input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
 <input type=hidden name=retorno value=../acquisitions/pending_order.php>
 <input type=hidden name=Mfn>
</form>
</body></html>
