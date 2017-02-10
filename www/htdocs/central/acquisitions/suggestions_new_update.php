<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
include("../common/get_post.php");
include("../lang/admin.php");
include("../lang/acquisitions.php");
//include("../dataentry/autoincrement.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
	// se procesan los valores que vienen de la página
$ValorCapturado="";
foreach ($_GET as $var => $value) {
	VariablesDeAmbiente($var,$value);
}
if (count($arrHttp)==0){
	foreach ($_POST as $var => $value) {
		VariablesDeAmbiente($var,$value);
	}
}
$cn="";
$arrHttp["Opcion"]="actualizar";
$cipar=$arrHttp["cipar"];
$base=$arrHttp["base"];
$xtl="";
$xnr="";
$arrHttp["wks"]="new.fmt";
include("../dataentry/plantilladeingreso.php");
include("../dataentry/actualizarregistro.php");
require_once ('../dataentry/leerregistroisis.php');
foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=explode("_",$var);
		if (isset($variables[$tag[0]])){
			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}
}
ActualizarRegistro();

	include("../common/header.php");
	echo "<body>\n";
	include("../common/institutional_info.php");
?>
	<div class="sectionInfo">
		<div class="breadcrumb">
			<?php echo $msgstr["suggestions"].": ".$msgstr["purchase"]?>
		</div>
		<div class="actions">
			<?php include("suggestions_menu.php")?>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions_new_update.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/suggestions_new_update.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: suggestions_new_update.php</font>\n";

	?>
	</div>
	<div class="middle form">
		<div class="formContent">
<?php
if ($cn!=""){
	$arrHttp["Formato"]=$arrHttp["base"];	echo LeerRegistroFormateado($arrHttp["Formato"]);
}else{
	echo "<h5>".$msgstr["noseq"]."</h5>";
	$url="";
    echo "<form name=enviar method=post action=suggestions_new_update.php>\n";
    foreach ($arrHttp as $var=>$value) {    	echo "<input type=hidden name=$var value=\"$value\">\n";    }
    echo "<input type=submit value=\"".$msgstr["tryagain"]."\">

    </form>";
    echo "<p>$url";//	$permisos=VerificarPermisos($perms);
//	echo $permisos."<p>";
	die;}
die;
//------------------------------------------------------
function VariablesDeAmbiente($var,$value){
global $arrHttp;

		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
					if (isset($arrHttp[$var])){
						$arrHttp[$var].=$value;
					}else{
						$arrHttp[$var]=$value;
					}
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}


function VerificarPermisos($perms){	if (($perms & 0xC000) == 0xC000) {
	    // Socket
	    $info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	    // Enlace Simbólico
	    $info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	    // Regular
	    $info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	    // Bloque especial
	    $info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	    // Directorio
	    $info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	    // Caracter especial
	    $info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	    // Pipe FIFO
	    $info = 'p';
	} else {
	    // Desconocido
	    $info = 'u';
	}

	// Dueño
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	            (($perms & 0x0800) ? 's' : 'x' ) :
	            (($perms & 0x0800) ? 'S' : '-'));

	// Grupo
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	            (($perms & 0x0400) ? 's' : 'x' ) :
	            (($perms & 0x0400) ? 'S' : '-'));

	// Mundo
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	            (($perms & 0x0200) ? 't' : 'x' ) :
	            (($perms & 0x0200) ? 'T' : '-'));

 	return $info;
}
?>
