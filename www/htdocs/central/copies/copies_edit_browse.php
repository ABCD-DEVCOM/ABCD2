<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");

include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$ex=explode("_",$arrHttp["Expresion"]);
$arrHttp["base"]=$ex[1];

$Permiso=$_SESSION["permiso"];

if (isset($arrHttp["unlock"])){
// if the record editing was cancelled unlock the record or keep deleted
	$query="";
    if (isset($arrHttp["unlock"])){
    	if (isset($arrHttp["Status"]) and $arrHttp["Status"]!=0)
    		$IsisScript=$xWxis."eliminarregistro.xis";
    	else
    		$IsisScript=$xWxis."unlock.xis";
    	$query = "&base=copies&cipar=$db_path"."par/copies.par&Mfn=" . $arrHttp["Mfn"]."&login=".$_SESSION["login"];
    	include("../common/wxis_llamar.php");
    	$res=implode("",$contenido);
    	$res=trim($res);
    }}
if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
if (isset($arrHttp["Expresion"])) $arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$arrHttp["Mfn"]=1;
$Formato=$db_path."copies/pfts/".$_SESSION["lang"]."/tbcopies";
if (!file_exists($Formato.".pft")) $Formato=$db_path."copies/pfts/".$lang_db."/tbcopies";
//$to=$arrHttp["from"]+9;
$to="";
if (!isset($arrHttp["Expresion"])){
	$query = "&base=copies&cipar=$db_path"."par/copies.par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato&Opcion=buscar";
	//$query.='&cttype=s';
	$IsisScript=$xWxis."leer_mfnrange.xis";
	include("../common/wxis_llamar.php");
	$inventary=$contenido;
}else{
	$query = "&base=copies&cipar=$db_path"."par/copies.par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato".".pft&Expresion=".urlencode($arrHttp["Expresion"]);
	//$query.='&cttype=s';
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$inventary=$contenido;
}

include("../common/header.php");
?>
<script>
xEliminar="";
Mfn_elminar=0;
top.toolbarEnabled=""
	function Editar(Mfn,Status){		document.editar.Mfn.value=Mfn
		document.editar.Status.value=Status
		document.editar.Opcion.value="editar"
		document.editar.submit()	}

	function Eliminar(Mfn){
		if (xEliminar==""){
			alert("<?php echo $msgstr["confirmdel"]?>")
			xEliminar="1"
			Mfn_eliminar=Mfn
		}else{
			if (Mfn_eliminar!=Mfn){
				alert("<?php echo $msgstr["mfndelchanged"]?>")
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
echo "<body>";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["admin"]." (".$arrHttp["base"],")"?>
	</div>
	<div class="actions">
		<?php
		if (!isset($arrHttp["return"])){
			$ret="../common/inicio.php?reinicio=s$encabezado";
		}else{
			$ret=str_replace("|","?",$arrHttp["return"])."&encabezado=".$arrHttp["encabezado"];
		}
		?>
		<a href='javascript:top.toolbarEnabled="";top.Menu("same")' class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		<a href=loan_objects_add.php?cn=<?php echo $arrHttp["Expresion"]?>&base=<?php echo $arrHttp["base"]?> class="defaultButton copiesdbaddButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["addloansdb"]?></strong></span>
		</a>

	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/copies/copies_edit_browse.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/copies/copies_edit_browse.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: copies_edit_browse.php</font>\n";
?>
	</div>

		<div class="middle form">
		<div class="formContent">
<?php
	echo "<Script>Indices='N'</script>\n" ;
echo "
			<table class=\"listTable\">
				<tr>
					<th>&nbsp;</th>
	";
// se lee la tabla con los títulos de las columnas
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/tbtit.tab";
if (!file_exists($archivo)) $archivo=$db_path."copies/pfts/".$lang_db."/tbtit.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
	foreach ($fp as $value){		$value=trim($value);
		if (trim($value)!=""){			$t=explode('|',$value);
			foreach ($t as $rot) echo "<th>$rot</th>";
		}	}
}
echo "<th class=\"action\">&nbsp;</th></tr>";
$desde=0;
$hasta=0;
foreach ($inventary as $value){
	$value=trim($value);
	if ($value!=""){
	echo "<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
		$u=explode('|',$value);
		$Mfn=$u[0];
		if (($u[1])=="") $u[1]=0;
		$Status=$u[1];
		$desde=$u[2];
		$hasta=$u[3];
		echo "<td>".$u[2]."/",$u[3];
		if ($Status==1) echo "<img src=\"../images/delete.png\" align=absmiddle alt=\"excluir base de dados\" title=\"excluir base de dados\" />";
		echo "</td>";
		for ($ix=4;$ix<count($u);$ix++) echo "<td>" .$u[$ix]."</td>";
		echo "<td class=\"action\">
			<a href=javascript:Editar($Mfn,$Status)>
			<img src=\"../images/edit.png\" alt=\"editar base de dados\" title=\"editar base de dados\" /></a>
			<a href=../dataentry/show.php?base=copies&cipar=copies.par&Mfn=$Mfn".$encabezado."&Opcion=editar  target=_blank><img src=\"../images/zoom.png\"/></a>";
		if ($Status==0) echo "
			<a href=\"javascript:Eliminar($Mfn)\"><img src=\"../images/delete.png\" alt=\"".$msgstr["eliminar"]."\" title=\"".$msgstr["eliminar"]."\" /></a>";
		else {			switch ($Status){				case -2:
					echo $msgstr["recblock"];
					break;
				case 1:
					echo $msgstr["recdel"];
					break;
			}
		}
		echo "</td>";
		echo "</tr>";
	}
}
echo "			</table>";

echo "</div></div>";
include("../common/footer.php");
echo "
 <form name=eliminar method=post action=../dataentry/eliminar_registro.php>
 <input type=hidden name=base value=copies>
 <input type=hidden name=from value=".$arrHttp["from"].">
 <input type=hidden name=retorno value=../copies/copies_edit_browse.php?base".$arrHttp["base"]."&Expresion=".urlencode($arrHttp["Expresion"]).">
 <input type=hidden name=Mfn>\n";
 if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
 if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
 $desde=$desde+1;
echo "</form>
<form name=editar method=post action=copies_edit_read.php>
	<input type=hidden name=from value=".$arrHttp["from"].">
	<input type=hidden name=base value=copies>
	<input type=hidden name=cipar value=copies.par>
    <input type=hidden name=Mfn>
    <input type=hidden name=Status>
    <input type=hidden name=retorno value=../copies/copies_edit_browse.php?base=copies&Expresion=".urlencode($arrHttp["Expresion"]).">
    <input type=hidden name=Opcion value=editar>
";
if (isset($arrHttp["encabezado"])){	echo "<input type=hidden name=encabezado value=s>\n";}
if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
echo "</form>
	</body>
</html>
<script>
	first=1
	last=$hasta
	desde=$desde
</script>
";
if (isset($arrHttp["error"])){
	echo "\n<script>alert('".$arrHttp["error"]."')</script>";
}
?>