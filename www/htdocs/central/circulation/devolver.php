<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org/
 * @file:      devolver.php
 * @desc:      Ask for the item to be returned
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   2.2
 *
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
if (!isset($uskey)) $uskey="";
$ec_output="";


include("../circulation/scripts_circulation.php");
include("../circulation/functions.php");
?>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13)
		EnviarForma()

    return true;
  };


function EnviarForma(){
	if (Trim(document.inventorysearch.inventory.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]?>")
		return
	}
	INV=escape(document.inventorysearch.inventory.value)
	<?php if (isset($inventory_numeric) and $inventory_numeric =="Y")
		//echo "INV=parseInt(document.inventorysearch.inventory.value,10)\n";
	?>
    document.inventorysearch.searchExpr.value=INV
    document.inventorysearch.submit()
}

function AbrirIndiceAlfabetico(){
	db="trans"
	cipar="trans.par"
	postings=1
	tag="10"
	<?php if (isset($_SESSION["library"])){
		echo "Prefijo='TR_P_".$_SESSION["library"]."_'\n";
	}else{
		echo "Prefijo='TR_P_'\n";
	}
	?>
	Ctrl_activo=document.inventorysearch.inventory
	lang="<?php echo $_SESSION["lang"]?>"
	Separa=""
	Repetible="1"
	Formato="v10,`$$$`,v10"
	Formato="ifp"
	Prefijo=Separa+"&prefijo="+Prefijo
	ancho=200
	url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+"&tagfst=10"+Prefijo+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato+"&postings=1"
	msgwin=window.open(url_indice,"Indice","width=480, height=425,left=300,scrollbars")
	msgwin.focus()
}

function DeleteSuspentions(){
	Mfn=""
	switch (nSusp){
		case 1:
			if (document.ecta.susp.checked){
            	Mfn=document.ecta.susp.value
			}
			break
		default:
			for (i=0;i<nSusp;i++){
				if (document.ecta.susp[i].checked){
					Mfn+=document.ecta.susp[i].value+"|"
				}
			}
			break
	}
	if (Mfn==""){
		alert("<?php echo $msgstr["selsusp"]?>")
		return
	}
	document.multas.Mfn.value=Mfn
	document.multas.submit()
}


</script>
<?php
echo "<body onload='javascript:document.inventorysearch.inventory.focus()'>\n";
include("../common/institutional_info.php");
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["return"]?>
	</div>
	<div class="actions">
	</div>
	<?php include("submenu_prestamo.php");?>
</div>


<?php
$ayuda="devolver.html";
include "../common/inc_div-helper.php";
?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">

	<form name="inventorysearch" action="devolver_ex.php" method="post" onsubmit="javascript:return false">
	<h4><?php echo $msgstr["inventory"]?></h4>

		<button type="button" name="list" title="<?php echo $msgstr["list"]?>" class="bt-blue w-10" onclick="javascript:AbrirIndiceAlfabetico();return false"/><i class="fa fa-search"></i> <?php echo $msgstr["list"]?></button>
		<textarea name="inventory" id="inventory" value="" class="w-10" /></textarea>
        <input type=hidden name=base value=trans>
        <input type=hidden name=searchExpr>
		<button type="submit" name="reservar" title="<?php echo $msgstr["return"]?>" class="bt-green w-10" onclick="javascript:EnviarForma()"/><?php echo $msgstr["return"]?> <i class="fas fa-arrow-right"></i></button>
		<small><?php echo $msgstr["clic_en"]." <i>[".$msgstr["return"]."]</i> ".$msgstr["para_c"]?></small>
	</form>
	</div>
	<div class="formContent col-9 m-2">
<?php
if (isset($arrHttp["usuario"])){
   // include("ec_include.php");
   // echo "<div class=formContent>$ec_output</div>";
}
if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S" and isset($arrHttp["errores"])){
	$inven=explode(';',$arrHttp["errores"]);
	foreach ($inven as $inventario){
		if (trim($inventario)!=""){
			$Mfn=trim($inventario);
			echo "<h3 class='color-green'>". $inventario." ".$msgstr["item"].": ".$msgstr["copynoexists"]." </h3>";
		}
	}

}

if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S" and isset($arrHttp["resultado"])){
	$lista_mfn=explode(';',$arrHttp["resultado"]);
	foreach ($lista_mfn as $Mfn){
		if (trim($Mfn)!=""){
			echo "<h3 class='color-green'>".$msgstr["returned"]." ".$msgstr["item"].":  </h3>";
			$Formato="v10,' ',mdl,v100'<br>'";
			$Formato="&Pft=$Formato";
			$IsisScript=$xWxis."leer_mfnrange.xis";
			$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
			include("../common/wxis_llamar.php");
			foreach ($contenido as $value){
				echo $value;
			}
		}
	}
}

//SE VERIFICA SI ALGUNO DE LOS EJEMPLARES DEVUELTOS ESTÁ RESERVADO
if (isset($arrHttp["lista_control"])) {
	include("../reserve/reserves_read.php");
	$rn=explode(";",$arrHttp["lista_control"]);
	$Expresion="";
	foreach ($rn as $value){
		$value=trim($value);
		if ($value!=""){
			if ($Expresion=="")
				$Expresion=$value;
			else
				$Expresion.=" or ".$value;
		}
	}
	$Expresion='('.$Expresion.')' ;
	$reserves_arr= ReservesRead($Expresion,"S");
	$reserves_title=$reserves_arr[0];
	if ($reserves_title!=""){
		echo "<p><!--strong>".$msgstr["reserves"]."</strong><br-->";
		echo $reserves_title."<p>";
	}
}

// se imprimen los recibos de devolucion, si procede
if (isset($arrHttp["rec_dev"])) {
	$r=explode(";",$arrHttp["rec_dev"]);
	$recibo="";
	foreach ($r as $Mfn){
		if ($Mfn!=""){
			$Formato="";
			if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/r_return.pft")){
				$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/r_return";
			}else{
				if (file_exists($db_path."trans/pfts/".$lang_db."/r_return.pft")){
					$Formato=$db_path."trans/pfts/".$lang_db."/r_return";
				}
			}
			if ($Formato!="") {
                $Formato="&Formato=$Formato";
				$IsisScript=$xWxis."leer_mfnrange.xis";
				$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
				include("../common/wxis_llamar.php");
				foreach ($contenido as $value){
					$recibo.=trim($value);
				}
			}
		}
	}

	$recibo_arr=$recibo;
	if (!empty($recibo_arr)) ImprimirRecibo($recibo);

}

if (isset($arrHttp["error"])){
	echo "<script>
			alert('".$arrHttp["error"]."')
			</script>
	";
}
?>

	</div>
	</div>
</div>

<?php include("../common/footer.php"); ?>