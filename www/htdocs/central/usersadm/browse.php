<?php
session_start();
include ("../config.php");

include("../lang/dbadmin.php");

include("../lang/admin.php");
$Permiso=$_SESSION["permiso"];
if (strpos($Permiso,'adm')===false and strpos($Permiso,'dbadm')===false){
	echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
	die;
}

include("../common/get_post.php");


$arrHttp["Mfn"]=1;
$Formato=$db_path."acces/pfts/".$_SESSION["lang"]."/tbusers";
if (!file_exists($Formato)) $Formato=$db_path."acces/pfts/".$lang_db."/tbusers";
$query = "&base=acces&cipar=$db_path"."par/acces.par"."&from=".$arrHttp["Mfn"]."&to=50&Formato=$Formato";
$IsisScript=$xWxis."leer_mfnrange.xis";
include("../common/wxis_llamar.php");
$lista_users=$contenido;
include("../common/header.php");
?>
<script>
xEliminar="";
	function Eliminar(Mfn){		if (xEliminar==""){
			alert("<? echo $msgstr["confirmdel"]?>")
			xEliminar="1"
		}else{
			xEliminar=""
			document.eliminar.Mfn.value=Mfn
			document.eliminar.submit()
		}	}
</script>
<?php
echo "<body>";
$encabezado="";
if (isset($arrHttp["encabezado"])) {	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["usuarios"]?>
	</div>
	<div class="actions">
<?php
if (isset($arrHttp["encabezado"])){?>
		<a href="../inicio.php?reinicio=s<?php echo $encabezado?>" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
<?php }?>
		<a href="../dataentry/fmt.php?base=acces&cipar=acces.par&Mfn=New<?php echo $encabezado?>&Opcion=nuevo" class="defaultButton  newButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["newoper"]?></strong> </span>
		</a>

	</div>
	<div class="spacer">&#160;</div>
</div>



<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/browse.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
        		<a href=../documentacion/edit.php?archivo=<?php echo $_SESSION["lang"]?>/browse.html target=_blank><?echo $msgstr["edhlp"]?></a>
<?php if ($_SESSION["permiso"]=="adm") echo "<font color=white>&nbsp; &nbsp; Script: browse.php</font>" ?>
</div>

		<div class="middle list">
			<table class="listTable">
				<tr>
					<!-- para ordenar utilize: class=asc|desc -->
					<th>&nbsp;</th>
					<th><?php echo $msgstr["username"]?></th>
					<th><?php echo $msgstr["userid"]?></th>
					<th><?php echo $msgstr["password"]?></th>
					<th><?php echo $msgstr["rights"]?></th>
					<th><?php echo $msgstr["database"]?></th>
					<th class="action">&nbsp;</th>
				</tr>
<?php
foreach ($lista_users as $value){
	if (trim($value)!=""){		echo "<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";		$u=explode('|',$value);
		$Mfn=$u[0];
		$Status=$u[1];
		$desde=$u[2];
		$hasta=$u[3];
		echo "<td>".$u[2]."/",$u[3];
		if ($Status==1) echo "<img src=\"../images/delete.png\" align=absmiddle alt=\"excluir base de dados\" title=\"excluir base de dados\" />";
		echo "</td>";
		for ($ix=4;$ix<count($u);$ix++) echo "<td>" .$u[$ix]."</td>";
		echo "<td class=\"action\">
			<a href=../dataentry/fmt.php?base=acces&cipar=acces.par&Mfn=$Mfn".$encabezado."&Opcion=editar><img src=\"../images/edit.png\" alt=\"editar base de dados\" title=\"editar base de dados\" /></a>";
		if ($Status==0) echo "
			<a href=\"javascript:Eliminar($Mfn)\"><img src=\"../images/delete.png\" alt=\"".$msgstr["eliminar"]."\" title=\"".$msgstr["eliminar"]."\" /></a>";
		else
			echo $msgstr["recdel"];
		echo "</td>";
		echo "</tr>";
	}}
echo "			</table>";
if ($desde<$hasta){
?>			<div class="tMacroActions">
				<div class="pagination">
					<a href="#" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#171; anterior
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton singleButtonSelected">
						<span class="sb_lb">&#160;</span>
						1
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton">
						<span class="sb_lb">&#160;</span>
						2
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton">
						<span class="sb_lb">&#160;</span>
						3
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton">
						<span class="sb_lb">&#160;</span>
						4
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton">
						<span class="sb_lb">&#160;</span>
						5
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="#" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#187; próximo
						<span class="sb_rb">&#160;</span>
					</a>
					<div class="spacer">&#160;</div>
				</div>
				<div class="spacer">&#160;</div>
			</div>
		</div>
<?php }
echo "</div></div>";
include("../common/footer.php");

echo "
 <form name=eliminar method=post action=../dataentry/eliminar_registro.php>
 <input type=hidden name=base value=acces>
 <input type=hidden name=Mfn>\n";
 if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
echo "</form>


	</body>
</html>";