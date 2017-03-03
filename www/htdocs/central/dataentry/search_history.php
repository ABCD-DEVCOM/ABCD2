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
echo "<font color=white>&nbsp; &nbsp; Script: dataentry/search_history.php" ?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">

<?php
if (!isset($_SESSION["history"])){
	echo "<h4>".$msgstr["faltaexpr"]."</h4>";
	die;
}
sort($_SESSION["history"]) ;
echo "<center><a href=search_history_ex.php?base=".$arrHttp["base"]."&Opcion=clear>Delete history</a></center>";
echo "<table align=center bgcolor=#cccccc cellpadding=5>";
$ix=0;
foreach ($_SESSION["history"] as $value){	$h=explode('$$|$$',$value) ;
	$ix=$ix+1;
	if ($h[0]==$arrHttp["base"]){
		echo "<tr><td bgcolor=white>".$h[0]."</td><td bgcolor=white>".$h[1]."</td>";
		echo "<td bgcolor=white>".$h[2]."</td>";
		echo "<td bgcolor=white><a href=search_history_ex.php?number=$ix><img src=img/toolbarSearchHistory.png></td></tr>";
	}}
?>
</table>
</div>
</div>
</center>
<?php include("../common/footer.php");?>
</body>
</html>
