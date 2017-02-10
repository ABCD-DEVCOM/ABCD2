<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");;

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";


if (!isset($arrHttp["archivo"])) die;
$arrHttp["txt"]=stripslashes($arrHttp["txt"]);
$arrHttp["txt"]=str_replace("\"",'"',$arrHttp["txt"]);
$archivo=$arrHttp["archivo"];
$fp=fopen($db_path.$archivo,"w");
fputs($fp,$arrHttp["txt"]);
fclose($fp);
if (isset($arrHttp["base"]))
	$base="&".$arrHttp["base"];
else
	$base="";
include("../common/header.php");
if (isset($arrHttp["retorno"]))
	$retorno=$arrHttp["retorno"];
else
	$retorno="menu_modificardb.php?encabezado=s$base";
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>"." " .$msgstr["database"];
				if (isset($arrHttp["base"])) echo ": ".$arrHttp["base"];
				echo "</h5>"?>
			</div>

			<div class="actions">
<?php echo "<a href=\"$retorno\" class=\"defaultButton backButton\">";
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
<br><br>
<dd><table border=0>
	<tr>
		<TD>
			<p><h4>
<?php $ar=explode('/',$arrHttp["archivo"]);
$ix=count($ar)-1;
$file=$ar[$ix];
echo $file." ".$msgstr["updated"]?></h4>
<?php if (!isset($arrHttp["encabezado"]))
		echo "
			<script>if (top.frames.length<1)
			        document.writeln(\"<a href=javascript:self.close()>Cerrar</a>\")
			</script>
         ";
?>
		</TD>
</table>
</div></div>
<?php include("../common/footer.php")?>

</body>
</html>
