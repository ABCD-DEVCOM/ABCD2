<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";die;
$arrHttp["ValorCapturado"]= htmlspecialchars_decode ($arrHttp["ValorCapturado"]);
$arrHttp["ValorCapturado"]= stripslashes ($arrHttp["ValorCapturado"]);
$t=explode("\n",$arrHttp["ValorCapturado"]);
$fp=fopen($db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab","w");
foreach ($t as $value){	fwrite($fp,stripslashes($value)."\n");
}
include("../common/header.php");

echo "<body>";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["typeofusers"]?>
	</div>

	<div class="actions">
		<a href="configure_menu.php" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php if ($_SESSION["permiso"]=="admloan") echo "<font color=white>&nbsp; &nbsp; Script: typeofusers_update.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><h4>
<?php echo $msgstr["typeofusers"]." ".$msgstr["saved"]?>!!!!</h4>

		</TD>
</table>
</center>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>
