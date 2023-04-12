<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org/
 * @file:      borrower_history.php
 * @desc:      Ask for the borrower for showing the transactions history
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
include("../lang/admin.php");
include("../lang/prestamo.php");

$arrHttp["base"]="users";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;
}

//se lee la configuración del usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$prefijo_codigo=$t[0];
if (isset($t[1]))
	$prefijo_nombre=$t[1];
else
	$prefijo_nombre="";
if (isset($t[2]))
	$formato_nombre=$t[2];
else
	$formato_nombre="";
if ($prefijo_codigo=="") $prefijo_codigo="CO_";
if ($prefijo_nombre=="") $prefijo_nombre="NO_";
if ($formato_nombre=="") $formato_nombre="v30";
# Se lee el formato para extraer el código de usuario
$codigo=LeerPft("loans_uskey.pft","users");
?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }

function EnviarForma(Proceso){
	if (Trim(document.usersearch.code.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]?>")
		return
	}
	document.EnviarFrm.usuario.value=document.usersearch.usercode.value
	document.EnviarFrm.action="borrower_history_reports.php"
	document.EnviarFrm.target="receiver"
	document.EnviarFrm.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
		msgwin.focus()
}

function AbrirIndice(TipoI,Ctrl){

	switch (TipoI){
		case "U":
			db="users"
			Formato="<?php echo trim($formato_nombre)?>,`$$$`,<?php echo str_replace("'","`",trim($codigo))?>"
			prefijo="<?php echo trim($prefijo_nombre)?>"
			AbrirIndiceAlfabetico(Ctrl,"<?php echo trim($prefijo_nombre)?>","","","users","users.par","30",1,"0",Formato)
			break
	}
}
</script>
<?php
$encabezado="";
echo "<body onLoad=javascript:document.usersearch.usercode.focus()>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">

	</div>
	<?php include("submenu_prestamo.php");?>
</div>


<?php
$ayuda="borrower_history.html";
include "../common/inc_div-helper.php";
?> 	


<div class="middle form row m-0">
	<div class="formContent col-2 m-2">

	<h4><?php echo $msgstr["usercode"]?></h4>
	<form name="usersearch" action="" method=post onsubmit="javascript:return false" target="results">
	<input type="hidden" name="Indice">
	
		<button type="button" name="index" title="<?php echo $msgstr["list"]?>" class="bt-blue col-2 p-2 m-0" onClick="javascript:AbrirIndice('U',document.usersearch.usercode)" /><i class="fa fa-search"></i></button>

		<input type="text" name="usercode" id="code" value="<?php if (isset($arrHttp["usuario"])) echo $arrHttp["usuario"]?>" class="w-8 p-2 m-0" />

		<button type="button" name="buscar" title="<?php echo $msgstr["search"]?>" class="bt-green w-10 mt-2" onclick="javascript:EnviarForma('U')"/><?php echo $msgstr["search"]?> <i class="fas fa-arrow-right"></i></button>
	</form>
	<small>
		<?php echo $msgstr["clic_en"]." <i>".$msgstr["search"]."</i> ".$msgstr["para_c"]?>
	</small>
	</div>

	<div class="formContent col-9 m-2">
		<iframe class="iframe w-10" height="600px" name="receiver" id="receiver" frameborder="0"></iframe>
	</div>
</div>


<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=inventory>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){
	echo "
	<script>
	alert('".$arrHttp["inventory"].": El número de inventario no está prestado')
	</script>
	";
}

if (isset($arrHttp['usuario'])) echo "<script> window.onload = function(){
  EnviarForma('U');
}</script>";
?>