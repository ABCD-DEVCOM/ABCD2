<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");;

$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["archivo"];
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>"; die;

$fp=fopen($archivo,"w");
fputs($fp,$arrHttp["txt"]);
fclose($fp);
include("../common/header.php");
echo "<body>" ;
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");

?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["fst"]." " .$msgstr["database"].": ".$arrHttp["base"]."</h5>"?>
			</div>

			<div class="actions">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php }?>
<div class="middle form">
			<div class="formContent">

<?php echo "<font size=1> &nbsp; &nbsp; Script: advancedsearch_update.php</font>"?>
<br><br>
<dd><table border=0>
	<tr>
		<TD>
			<p><h4><?php echo $arrHttp["base"]. "/pfts/".$_SESSION["lang"]."/".$arrHttp["archivo"]." ".$msgstr["updated"]?></h4><P>
		</TD>
</table>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>
