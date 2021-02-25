<?php
session_start();

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["login"])){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
include("../common/header.php");
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">

</script>
<body >
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/gestion_usuarios.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/gestion_usuarios.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: mail/index.php";
?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<form name=maintenance>

<table cellspacing=5 width=400 align=center >
	<tr>
		<td>

			<ul style="font-size:12px;line-height:20px">
				<li><a href=editar_correo_ini.php>Editar correo.ini</a>
				<li><a href=enviar_correo.php?base=<?php echo $_REQUEST["base"]?>>Enviar correos a nuevos usuarios</a></li>

			</ul>

		</td>
</table></form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
