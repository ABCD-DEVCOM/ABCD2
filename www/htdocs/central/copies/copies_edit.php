<?php
/*
20220209 fho4abcd div-helper,backButton, cleanup, remove unused LeerFDT
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/acquisitions.php");
//     foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

//se lee la FDT de la base de datos para determinar el campo donde se almacena el número de control
$tag_ctl="";
$error="";
LeerFst($arrHttp["base"]);

if ($error==""){
	$Formato="v".$tag_ctl;
    //Se lee el registro bibliográfico para capturar el número del objeto

	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=$Formato&Opcion=rango";
	$IsisScript=$xWxis."imprime.xis";
	include("../common/wxis_llamar.php");
	$valortag[1]=implode("",$contenido);
	if ($valortag[1]=="")     //CHECK IF THE RECORD HAS CONTROL NUMBER
		$err_copies="Y";
	else
		$err_copies="N";
}else{
	$err_copies="Y";
}
if ($err_copies=="Y"){
    include("../common/header.php");
    ?>
    <body>
	<div class="sectionInfo">
		<div class="breadcrumb">
			<?php echo $msgstr["m_editdelcopies"]?>
		</div>
		<div class="actions">
        <?php
            $backtoscript='javascript:top.toolbarEnabled="";top.Menu("same")';
            include "../common/inc_back.php";
		?>
 		</div>
		<div class="spacer">&#160;</div>
	</div>
    <?php
    $ayuda="copies/copies_add.html";
    include "../common/inc_div-helper.php";
    ?>
	<div class="middle form">
		<div class="formContent">
    <?php echo "
        <dd><h4>".$msgstr["err_cannotaddcopies"]."</h4>";
    ?>
	</div>
    </div>
    <?php include("../common/footer.php"); 
	die;
}else{
 	$Expresion="CN_".$arrHttp["base"]."_".$valortag[1];
    header("Location:copies_edit_browse.php?Expresion=$Expresion&base=copies");
}
?>


<?php
// ==================================================================================

function LeerFst($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr,$error;
// GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
	$archivo=$db_path.$base."/data/".$base.".fst";
	if (!file_exists($archivo)){
		echo "missing file ".$base."/data/".$base.".fst";
		die;
	}
	$fp=file($archivo);
	$tag_ctl="";
	$pref_ctl="CN_";
	foreach ($fp as $linea){
		$linea=trim($linea);
		$ix=strpos($linea,"\"CN_\"");
		if ($ix===false){
			$ix=strpos($linea,'|CN_|');
		}
		if ($ix===false){
		}else{
			$ix=strpos($linea," ");
			$tag_ctl=trim(substr($linea,0,$ix));
			break;
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl==""){
        //echo "****nose encontro";
		$error="missingctl";
	}
}
?>