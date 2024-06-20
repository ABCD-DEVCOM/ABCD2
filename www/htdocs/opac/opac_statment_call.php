<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
include("../central/config_opac.php");

if (isset($_REQUEST["Opcion"])) $_REQUEST["Opcion_Original"]=$_REQUEST["Opcion"];


$indice_alfa="N";
$sidebar="N";



include($Web_Dir."/head.php");
chdir($CentralPath."circulation");

$desde_opac="Y";
$ecta_web="Y";

//include ('opac_statment_ABCD.php');
include("../common/get_post.php");


if (!isset($Web_Dir)){
	echo "Falta el parámetro Web_Dir en config_opac.php";
	die;
}


$xis_path=$xWxis;
$exe_path=$Wxis;

//$xWxis=$xis_path;
//$Wxis=$exe_path;

if (isset($_REQUEST["db_path"]))
	$db_path=$_REQUEST["db_path"];
else
	if (isset($_REQUEST["DB_PATH"]))
		$db_path=$_REQUEST["DB_PATH"];

$_SESSION["DATABASE_DIR"]=$db_path;
$_SESSION["DB_PATH"]=$db_path;
$_SESSION["super_user"]="";

if (!isset($_REQUEST["lang"]))
	$_REQUEST["lang"]="en";
$arrHttp["lang"]=$lang;
$arrHttp["DB_PATH"]=$db_path;
$_SESSION["lang"]=$lang;
include("../lang/admin.php");
include("../lang/prestamo.php");
$indice_alfa="n";
$desde="ecta";

?>

<div id="prestamo">
	<table class="table">
		<td>
			<h4><?php echo $msgstr["front_ecta"]?></h4><hr>
                
			<form name="ecta" onsubmit="return false">
<?php
include("leer_pft.php");

// se lee la configuración local
include("calendario_read.php");
include("locales_read.php");
// SE LEE LA RUTINA PARA CALCULAR EL LÍMITE DE LA SUSPENSION
include("fecha_de_devolucion.php");
// se leen las politicas de préstamo
include("loanobjects_read.php");
// se lee la configuración de la base de datos de usuarios

include("borrowers_configure_read.php");
$ec_output="";



include("ec_include.php");
//echo $ec_output;

if (substr(trim($ec_output),0,2)=="**" or strlen($ec_output)<100){
	if (isset($msgstr["front_iah_usuario_notfound"])){
		echo "<p><strong>".$msgstr["iah_usuario_notfound"]."</strong></p>";
	}else{
	    echo "<p><strong>User not found</strong></p>";
	}
}else{
	echo $ec_output;
	if (isset($WebRenovation) and $WebRenovation=="Y"){
		if (count($prestamos)>0) {
			echo  "<input class='btn btn-success' type=submit value=\"".$msgstr["front_renew"]."\" onclick=Renovar() id=renovar>";
			if (isset($msgstr["front_iah_usuario_msgecta"])) echo "<p>".$msgstr["front_iah_usuario_msgecta"]."</p>";
		}
	}
	//SE LEEN LAS RESERVAS PENDIENTES
	$desde_opac="Y";
	if (isset($WebReservation) and $WebReservation=="Y" ){
		include("../reserve/reserves_read.php");
		$reservas_activas=0;
		$cuenta=0;
		$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"],"S","","N");
		$reserves_user=$reserves_arr[0];
		echo $reserves_user;
		if ($reserves_user!=""){
			echo "<p>".$msgstr["front_iah_reserve_msg"];
		}
	}
	//if (isset($msgstr["opac_ecta"]))  echo "<br>".$msgstr["opac_ecta"]."<br>";
}
?>
</form>

<form name="renovar" action="<?php echo $CentralHttp;?>/central/circulation/renovar_ex.php" method="post" onsubmit="javascript:return false">
	<input type="hidden" name="searchExpr">
	<input type="hidden" name="usuario" value="<?php echo $arrHttp["usuario"]?>">
	<input type="hidden" name="vienede" value="<?php if (isset($arrHttp["vienede"])) echo $arrHttp["vienede"]?>">
	<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
	<input type="hidden" name="lang" value="<?php echo $arrHttp["lang"]?>">
	<input type="hidden" name="OpacHttp" value="<?php echo $OpacHttp?>">
	<input type="hidden" name="Web_Dir" value="<?php echo $Web_Dir?>">
</form>

<form name="anular" method="post" action=reservar_anular_ABCD.php>
	<input type="hidden" name=Mfn>
	<input type="hidden" name=usuario value="<?php echo $arrHttp["usuario"]?>">
	<input type="hidden" name=vienede value="<?php if (isset($arrHttp["vienede"])) echo $arrHttp["vienede"]?>">
	<input type="hidden" name=db_path value="<?php echo $db_path?>">
	<input type="hidden" name=lang value="<?php echo $arrHttp["lang"]?>">
	<input type="hidden" name=Web_Dir value="<?php echo $Web_Dir?>">
	<input type="hidden" name=OpacHttp value="<?php echo $OpacHttp?>">
</form>

</table>
<?php
	//echo "<a href=$OpacHttp>Volver al catálogo</a>";
?>
</div>
<?php
if (isset($arrHttp["error"])){
	echo "<script>alert(\"".$arrHttp["error"]."\")</script>";
}else{
	if (isset($arrHttp["resultado"])){
		$inven=explode(';',$arrHttp["resultado"]);
		$msg="";
		foreach ($inven as $inventario){
			$msg.=  $inventario.'\r'  ;
		}
		echo "<script>alert(\"".$msg."\")</script>";
	}
}

?>
  <br><br><br><br>


<?php
chdir($Web_Dir);
include($Web_Dir."/views/footer.php");
?>

<script>
function CancelReserve(Mfn){
	document.anular.Mfn.value=Mfn
	document.anular.submit()
}
function Renovar() {
	//document.renovar.action="renovar_ex.php"
	marca="N"
	switch (np){     // número de préstamos del usuario
		case 1:
			if (document.ecta.chkPr_1.checked){
				document.renovar.searchExpr.value=document.ecta.chkPr_1.id
				atraso=document.ecta.chkPr_1.value
				politica=document.ecta.politica.value
				marca="S"
			}
			break
		default:
			for (i=1;i<=np;i++){
				Ctrl=eval("document.ecta.chkPr_"+i)
				if (Ctrl.checked){
					marca="S"
					document.renovar.searchExpr.value=Ctrl.id
					atraso=Ctrl.value
					politica=document.ecta.politica[i-1].value
					break
				}
			}
	}
	fecha_d="<?php echo date("Ymd")?>"
	if (marca=="S"){
		p=politica.split('|')
		if (p[6]=="0"){     // the object does not accept renovations
			alert("<?php echo $msgstr["front_noitrenew"] ?>")
			return
		}
		if (atraso!=0){
			if (p[13]!="Y"){
				alert("<?php echo $msgstr["front_loanoverdued"]?>")
				return
			}
		}
		if (Trim(p[15])!=""){
			if (fecha_d>p[15]){
				alert("<?php echo $msgstr["front_limituserdate"]?>"+": "+p[15])
				return
			}
		}
		if (Trim(p[16])!=""){
			if (fecha_d>p[16]){
				alert("<?php echo $msgstr["front_limitobjectdate"]?>"+": "+p[16])
				return
			}
		}
		if (nMultas!=0){
			alert("**<?php echo $msgstr["front_norenew"]?>")
			return
		}
		document.renovar.submit()
		var division = document.getElementById("overlay");
		division.style.display="block"
		var division = document.getElementById("popup");
		division.style.display="block"
		var enlace = document.getElementById("enlace");
		enlace.href="javascript:void(0)"

	}else{
		alert("<?php echo $msgstr["front_markloan"]?>")
	}
}
</script>
