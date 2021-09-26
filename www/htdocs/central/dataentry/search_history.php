<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ('../config.php');
include("../lang/admin.php");
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//if (!isset($arrHttp["base"])) die;

include("../common/header.php");

?>
<body>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/search_history.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/search_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "  Script: dataentry/search_history.php" ?>

	</div>
<div class="middle form">
			<div class="formContent">

<?php
if (!isset($_SESSION["history"])){
	echo "<h4>".$msgstr["faltaexpr"]."</h4>";
	die;
}
sort($_SESSION["history"]) ;
?>

	<center>
		<a class="button_browse delete"	 href="search_history_ex.php?base=<?php echo $arrHttp["base"];?>&Opcion=clear"><i class="far fa-trash-alt"></i> Delete history</a>
	</center>
	
	<table align=center class="listTable" cellpadding=5>

<?php
$ix=0;
foreach ($_SESSION["history"] as $value){
	$h=explode('$$|$$',$value) ;
	$ix=$ix+1;
	if ($h[0]==$arrHttp["base"]){
?>
		<tr>
			<td><?php echo $h[0];?></td>
			<td><?php echo $h[1];?></td>
			<td><?php echo $h[2];?></td>
			<td>
				<a class="button_browse edit" href="search_history_ex.php?number=<?php echo $ix;?>">
				<i class="fab fa-searchengin"></i>
			</td>
		</tr>
<?php
	}
}
?>
</table>
</div>
</div>
</center>
<?php include("../common/footer.php");?>
