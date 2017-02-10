<?php
session_start();
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");



?>
<script src=../dataentry/js/lr_trim.js></script>
<script>

function EnviarForma(){
	if (Trim(document.inventorysearch.inventory.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]." / ".$msgstr["usercode"]?>")
		return
	}
    document.inventorysearch.submit()}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"

	switch (Tipo){		case "I":
			Separa=""
    		Prefijo=Separa+"&prefijo=IN_"
    		ancho=200
			url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato=@autoridades.pft"
			break
	}
	msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
	msgwin.focus()
}

</script>
<?php
$encabezado="";
echo "<body onLoad=javascript:document.inventorysearch.inventory.focus()>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["co_history"];
		?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/item_history.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/item_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: item_history.php </font>
	</div>";
// prestar, reservar o renovar
?>


<form name=inventorysearch action=item_history_ex.php method=post onsubmit="javascript:return false">
<input type=hidden name=Opcion value=prestar>
<div class="middle list">
	<div class="searchBox">
	<table width=100% border=0>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td>
		<input type="text" name="inventory" id="inventory" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('I',document.inventorysearch.inventory);return false"/>
		<input type="submit" name="reservar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>
		</td>
	</table>
	</div>
</div>

</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>