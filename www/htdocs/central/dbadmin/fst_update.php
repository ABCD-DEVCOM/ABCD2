<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";
$arrHttp["ValorCapturado"]= htmlspecialchars_decode ($arrHttp["ValorCapturado"]);
$arrHttp["ValorCapturado"]= stripslashes ($arrHttp["ValorCapturado"]);
if ($arrHttp["Opcion"]=="new"){	$_SESSION["FST"]=$arrHttp["ValorCapturado"];
	header("Location:pft.php?Opcion=new&base=".$arrHttp["base"].$encabezado);
	die;}
$t=explode("\n",$arrHttp["ValorCapturado"]);
$fp=fopen($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst","w");

foreach ($t as $value){	fwrite($fp,stripslashes($value)."\n");
	//echo "$value<br>";}

include("../common/header.php");
echo "<body>";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["fst"].": ".$arrHttp["base"]?>
	</div>

	<div class="actions">
<?php if ($arrHttp["Opcion"]=="new"){
	echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">";
}else{
	echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
}
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "<font color=white>&nbsp; &nbsp; Script: fst_update.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><h4>
<?php echo $msgstr["fstupdated"]?></h4>

		</TD>
</table>
</center>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>
