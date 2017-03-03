<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ('../config.php');
include("../lang/admin.php");
include("../lang/dbadmin.php");
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!(isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$arrHttp["base"]."_EDITSTOREDEXPR"]))){	echo "<h1>Usted no tiene permisos para ejecutar esta función</h1>";
	die;
}
if (!file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab")){	echo "<h1>".$msgstr["no_search_expr_stored"]."<h1>";
	die;}

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//if (!isset($arrHttp["base"])) die;

include("../common/header.php");

?>
<script>
function Delete(linea){	Ctrl_name=eval("document.forma1.name_"+linea)
	Ctrl_expr=eval("document.forma1.expr_"+linea)
	Ctrl_name.value=""
	Ctrl_expr.value=""
	return}
function Cancelar(){	top.Menu('buscar')}
</script>
<body>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/edit_stored_expr.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/edit_stored_expr.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dataentry/edit_stored_expr.php" ?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">
<form name=forma1 action=edit_stored_expr_ex.php method=post>

<?php
echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";

echo "<table align=center bgcolor=#cccccc cellpadding=3>";
echo "<tr><th>".$msgstr["name"]."</th><th>".$msgstr["expresion"]."</th></tr>";
$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
$i=-1;
foreach ($fp as $value){	if (trim($value)!=""){		$i=$i+1;		$e=explode('|',$value);
		echo "<tr>";
		echo "<td><input type=text name=name_$i value=\"".$e[0]."\" size=30></td>";
		echo "<td><input type=text name=expr_$i value=\"".$e[1]."\" size=150>";
		echo "<a href=javascript:Delete($i)>".$msgstr["delete"]."</a>";
		echo "</td>";
		echo "</tr>";	}}
echo "<tr><td colspan=2 bgcolor=#FFFFFF align=center>";
echo "<input type=submit value=".$msgstr["update"].">";
echo "&nbsp; &nbsp; &nbsp; " ;
echo "<input type=button value=".$msgstr["cancel"]." onclick=javascript:Cancelar()>";echo "</table>";
?>

</form>
</div>
</div>
</center>
<?php include("../common/footer.php");?>
</body>
</html>
