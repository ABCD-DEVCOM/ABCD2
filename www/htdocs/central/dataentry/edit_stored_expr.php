<?php
/* Modifications
2021-11-09 rogercgui change line 72 from $e[1] to htmlspecialchars($e[1]) to display double quotes
2024-04-27 fho4abcd Improve html, allow ¨ in expressions,better messages
*/

session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ('../config.php');
include("../lang/admin.php");
include("../lang/dbadmin.php");
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!(isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$arrHttp["base"]."_EDITSTOREDEXPR"]))){
	echo "<span style='color:red'>".$msgstr["invalidright"]."<span>";
	die;
}
if (!file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab")){
	echo "<span style='color:red'>".$msgstr["no_search_expr_stored"]."<span>";
	die;
}

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

include("../common/header.php");

?>
<body>
<script>
function Delete(linea){
	Ctrl_name=eval("document.forma1.name_"+linea)
	Ctrl_expr=eval("document.forma1.expr_"+linea)
	Ctrl_name.value=""
	Ctrl_expr.value=""
	return
}

function Cancelar(){
	top.Menu('buscar')
}
</script>
<?php
	include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">

<form name="forma1" action="edit_stored_expr_ex.php" method="post">
<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">
<table align="center" cellpadding="3" width="90%">
<tr>
	<th><?php echo $msgstr["name"];?></th>
	<th><?php echo $msgstr["expresion"];?></th>
</tr>

<?php
$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
$i=0;
foreach ($fp as $value){
	if (trim($value)!=""){
		$i=$i+1;
		$e=explode('|',$value);
		/*
			for some reason quotes in expressions are converted to ¨
			The search does not care but the display her does not like it
		*/
		$e[1]=trim(str_replace("¨","'",$e[1]));
		?>	
		<tr>
			<td><input type="text" name="name_<?php echo $i;?>" value="<?php echo $e[0];?>" size="25"></td>
			<td><input type="text" name="expr_<?php echo $i;?>" value="<?php echo htmlspecialchars($e[1])?>" size="80">
			<a href="javascript:Delete(<?php echo $i;?>)" class="bt bt-red"><?php echo $msgstr["delete"];?></a>
		</tr>
		<?php
	}
}
echo "<tr><td colspan=2 bgcolor=#FFFFFF align=center>";
echo "<input type=submit value=".$msgstr["update"].">";
echo "&nbsp; &nbsp; &nbsp; " ;
echo "<input type=button value=".$msgstr["cancel"]." onclick=javascript:Cancelar()>";
echo "</table>";
?>

</form>

</div>
</div>
<?php include("../common/footer.php");?>