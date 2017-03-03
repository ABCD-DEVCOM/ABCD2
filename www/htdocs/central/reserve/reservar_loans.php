<?php
session_start();
// RESERVA DESDE EL SISTEMA DE PRESTAMOS
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";


include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
die;

include("../config.php");
include("../lang/prestamo.php");
include("../common/header.php");
include("../common/institutional_info.php");
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
?>

<script>
function Enviar(){	Codigo=Trim(document.reserva.codigo.value)
	if (Codigo==""){		alert("Debe especificar su código de usuario")
		return	}
	document.reserva.submit()}
function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,left=200,scrollbars")
		msgwin.focus()
}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"
	switch (Tipo){
		case "U":
<?php
# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$codigo=LeerPft("loans_uskey.pft","users");
?>
			Separa=""
			Formato="<?php if (isset($t[2]))  echo trim($t[2]); else echo 'v30';?>,`$$$`,<?php echo str_replace("'","`",$codigo)?>"
    		Prefijo=Separa+"&prefijo=<?php if (isset($t[1])) echo trim($t[1]); else echo 'NO_';?>"
    		ancho=200
			url_indice="../circulation/capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
			break
	}
	msgwin=window.open(url_indice,"Indice","width=480, height=450,left=300,scrollbars")
	msgwin.focus()
}

</script>
</head>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["reserve"]?>
	</div>
	<div class="actions">
<?php
	  echo "<a href=\"buscar.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&count=1&Opcion=buscar_en_este&Expresion=".$arrHttp["Expresion"]."\" class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulacion/reserva.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulacion/reserva.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reserve/reservar_loans.php" ?></font>
</div>
<div class="middle form">
	<div class="formContent">
	<form name=reserva action=reservar_loans_ex.php method=post>
	<input type=hidden name=cn value=<?php echo $arrHttp["cn"]?>>
	<input type=hidden name=Expresion value=<?php echo $arrHttp["Expresion"]?>>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<div class="searchBox">
		<table width=100% border=0>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td>
		<td>
		<input type="text" name="usuario" id="usuario" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry'; "
<?php
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
	echo "value=\"".$arrHttp["usuario"]."\"";
?>
 onclick="document.reserva.usuario.value=''"
/>
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('U',document.reserva.usuario)"/>
		<input type="submit" name="reservar" value="<?php echo $msgstr["reserve"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>

		</td></table>
        <?php echo $msgstr["clic_en"]." <i>[".$msgstr["loan"]."]</i> ".$msgstr["para_c"]?>

	</div>
<?php

?>

   </div>
</div>
<?php
	include("../common/footer.php");
?>
</body>
</html>