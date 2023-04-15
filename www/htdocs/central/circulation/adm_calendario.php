<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org
 * @file:      adm_calendario.php
 * @desc:      Update the calendar of holidays
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   2.2
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
include("../config.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("calendario_ver.php");

IF (!isset($arrHttp["mes"])) $arrHttp["mes"]="";
if (!isset($arrHttp["cadena"])) $arrHttp["cadena"]="";
if (!isset($arrHttp["ano"])) $arrHttp["ano"]="";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="guardar"){
	Calendario("feriados.tab");
	die;
}

include("../common/header.php");
?>
<script>
function Dias_Fe(Tipo) {
	document.tabla.cadena.value = ' '
	NumeroDias= document.tabla.dias.length
	switch (Tipo){
		case 0: document.tabla.Opcion.value="guardar"
			break
		case 1:
			document.tabla.mes.value = document.tabla.mes_ante.value
			document.tabla.ano.value = document.tabla.ano_ante.value
			break
		case 2:
			document.tabla.mes.value = document.tabla.mes_sig.value
			document.tabla.ano.value = document.tabla.ano_sig.value
			break;

	}
	TColum=' '
	for ( j = 0 ; j < NumeroDias; j++) {
  		if (document.tabla.dias[j].checked == true ){
			Tconta = j + 1
			TColum = TColum+(Tconta)+'|'
		}
	}//Fin de j
	document.tabla.cadena.value = TColum
	document.tabla.submit()
}
</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["typeofusers"];?>
	</div>
	<div class="actions">
<?php
	$ayuda="/circulation/calendario.html";
    $backtocancelscript="self.close()";
	$savescript="javascript:Dias_Fe(0)";
	$backtoscript="configure_menu.php?encabezado=s";

	if (isset($arrHttp["ver"])){
    	include "../common/inc_cancel.php";
	}else{
		include "../common/inc_back.php";

    include "../common/inc_save.php";
	}
?>
    </div>
    <div class="spacer">&#160;</div>
</div>
 
<?php include "../common/inc_div-helper.php"; ?>

<div class="middle form">
	<div class="formContent">
		<?php Calendario("feriados.tab"); ?>
	</div>
</div>
<?php include("../common/footer.php"); ?>