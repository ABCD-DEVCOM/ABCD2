<?php
/* Modifications
2021-01-05 guilda Added $msgstr["close"]
*/

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
	$retorno="../dbadmin/menu_modificardb.php?encabezado=s$base";
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo $msgstr["database"];
				if (isset($arrHttp["base"])) echo ": ".$arrHttp["base"];
				?>
			</div>

			<div class="actions">
				<?php
					$backtoscript=$retorno;
					include "../common/inc_back.php";
				?>

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
			        document.writeln(\"<a href=javascript:self.close()>".$msgstr["close"]."</a>\")
			</script>
         ";

echo $retorno;
echo '<meta http-equiv="refresh" content="0; URL='.$retorno.'">';
?>
		</TD>


</table>
</div></div>
<?php include("../common/footer.php")?>
