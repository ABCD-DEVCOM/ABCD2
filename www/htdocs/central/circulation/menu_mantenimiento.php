<?php
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"])and !isset($_SESSION["permiso"]["CIRC_CIRCALL"]) ){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");

$lang=$_SESSION["lang"];

include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
include("../common/institutional_info.php");
?>

<script src=../dataentry/js/lr_trim.js></script>


<script language="javascript" type="text/javascript">

function EnviarForma(Opcion,Mensaje,base){
	switch (Opcion){		case "inicializar":
			if (confirm(Mensaje+": "+base+". "+"<?php echo $msgstr["areysure"]?>"))
				document.inicializar.action="bases_inicializar.php"
				document.inicializar.base.value=base
				document.inicializar.submit();
			break;
		case "inactivas":
			if (confirm("<?php echo $msgstr["areysure"]?>"))
				document.inicializar.action="vencidas2canceladas.php"
				document.inicializar.submit();
			break;
		case "eliminar":
			if (confirm("<?php echo $msgstr["areysure"]?>"))
				document.inicializar.action="canceladas2eliminar.php"
				document.inicializar.submit();
			break;	}
}

</script>
<body >
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["loantit"]. " " . $msgstr["basedatos"].": ".$msgstr["admtit"]."
			</div>
			<div class=\"actions\">
                <a href=\"../common/inicio.php?reinicio=s&modulo=loan\" class=\"defaultButton backButton\">
                <img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	           <span><strong>". $msgstr["back"]."</strong></span></a>
            </div>
	       <div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulacion/menu_mantenimiento.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<form name=maintenance>
<table cellspacing=5 width=500 align=center>
	<tr>
		<td>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>><font style="font-size:12px">
             <br>
			<!--ul>
			<li><a href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"].":".$msgstr["trans"]?>","trans")'><?php echo $msgstr["mnt_ibd"].": ".$msgstr["trans"]?> (trans)</a></li>
			<?php
				if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){					?><li><a href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"].": ".$msgstr["reserve"]?>","reserve")'><?php echo $msgstr["mnt_ibd"].": ".$msgstr["reserve"]?> (reserve)</a></li>
			<?php } ?>
			<li><a href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"].": ".$msgstr["suspen"]?>","suspml")'><?php echo $msgstr["mnt_ibd"].": ".$msgstr["suspen"]?> (suspml)</a></li>
			<?php if (file_exists($db_path."logtrans/data/logtrans.mst")){				echo "<li><a href='javascript:EnviarForma(\"inicializar\",\"". $msgstr["mnt_ibd"].": ".$msgstr["logtrans"]."\",\"logtrans\")'>".$msgstr["mnt_ibd"].": ".$msgstr["logtrans"]." (logtrans)</a></li>";			}
			?>
			<!--li><a href='javascript:EnviarForma("inactivas","<?php echo $msgstr["susp_inac"]?>")'><?php echo $msgstr["susp_inac"]?></a></li-->

			</ul-->

		</td>
</table></form>
<form name=inicializar method=post  onSubmit="Javascript:return false">
<input type=hidden name=base>

</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
