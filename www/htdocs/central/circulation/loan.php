<?php
session_start();
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
function EnviarFormaUsuario(){	if (Trim(document.usersearch.usercode.value)==""){		alert("Debe especificar el usuario")
		return	}
	document.EnviarFrm.usuario.value=document.usersearch.usercode.value
	document.EnviarFrm.action="usuario_prestamos_presentar.php"
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
			prefijo="NO_"
			AbrirIndiceAlfabetico(Ctrl,"NO_","","","users","cipres.par","30",1,"","v30,`$$$`,v35")
			break
 		case "C":
			db="presta"
			prefijo="!Z"
   			top.main.location="prestamos.php?Opcion=localiza_titulo&userid="+userid+"&base="+db+"&cipar=cipres.par&prefijo="+prefijo
			break
 		case "N":
 			return
			db="presta"
			if (top.CentroP!="*****")
				prefijo="!I"+top.CentroP
			else
				prefijo="!I"

   			top.main.location="prestamos.php?Opcion=localiza_titulo&userid="+userid+"&base="+db+"&cipar=cipres.par&prefijo="+prefijo
	}
}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["loan"]."/".$msgstr["return"]."/".$msgstr["reserve"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
// busqueda por código de usuario
?>

<div class="middle list">
	<div class="searchBox">
	<form name=usersearch action="" method=post onsubmit="javascript:return false">
	<input type=hidden name=Indice>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td><td>
		<input type="text" name="usercode" id="usercode" value="" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

		<input type="submit" name="ok" value="<?php echo $msgstr["search"]?>" class="submit" onClick=Javascript:EnviarFormaUsuario() />
		<input type="submit" name="index" value="<?php echo $msgstr["list"]?>" class="submit" onClick="javascript:AbrirIndice('U',document.usersearch.usercode)" />
		</td></table>
	</form>
	</div>
	<div class=\"spacer\">&#160;</div>
	<div class="searchBox">
	<form name=inventorysearch action=inventorysearch.php method=post>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td>
		<input type="text" name="searchExpr" id="searchExpr" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />

		<input type="submit" name="ok" value="<?php echo $msgstr["search"]?>" class="submit" onclick="javascript:return false"/>
		<input type="submit" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:return false"/>
		</td></table>
	</form>
	</div>
</div>
<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>