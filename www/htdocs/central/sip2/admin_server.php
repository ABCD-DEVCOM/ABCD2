<?php
/*
	INTERFAZ GRÁFICA PARA INICIAR Y PARAR EL SERVIDOR.
	ADICIONALMENTE SE PUEDE GESTIONAR PARÁMETROS DE
	CONFIGURACIÓN DESDE AQUÍ, ESTO MODIFICARÍA EL
	ARCHIVO CONFIG.PHP EN SUS PARAMETROS PARA SIP.
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}else{
	if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CENTRAL_CRDB"])){
		header("Location: ../common/error_page.php") ;
	}
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../common/header.php")
//foreach ($arrHttp as $var=>$

?>

</head>
<body>

<?php
	include("../common/institutional_info.php");
	
?>
	<div class="sectionInfo">

		<div class="breadcrumb">
				<?php echo "SIP Manager"?>
		</div>

		<div class="actions">
<?php if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>
	";
}
?>
		</div>
		<div class="spacer">&#160;</div>
	</div>
    
	<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/admin.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/admin.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: automation/admin_server.php</font>";
?>
	</div>


    
<table bgcolor="#FFFFFF" width="100%" height="500px">
<tr>
<td align="center" width="50%">
    SIP 2 Server
    <br>
    (Session Interchange Protocol)
    <br>
    <br>
    <br>
    <!--<img src="images/selfcheck.jpg" width="18%"/>-->
    <br>
    <table align="center" width="30%">
        <tr>
            <td align="center">
            	Start
                <form action="socket_server.php" name="star_server" method="post">
                    <input type="submit" value="" name="icon" style="background:url(images/defaultButton_go.png); width:43px; height:43px;" onClick="alert('Servidor ejecutado. Si desea puede cerrar esta pantalla.')"/>
                    <input type="hidden" value="start_server" name="pedido" />
                </form>
            </td>
            <td align="center">
            	Stop
                <form action="socket_server.php" name="stop_server" method="post">
                    <input type="submit" value="" name="icon" style="background:url(images/defaultButton_cancel.png); width:43px; height:43px;"/>
                    <input type="hidden" value="stop_server" name="pedido" />
                </form>
            </td>
        </tr>
    </table>

</td><!--<td align="center" width="50%">

    Servidor SIP de ANTENAS:
    <br>
    <img src="images/antenna.jpg" width="25%"/>
    <br>
    <table align="center" width="100%">
        <tr>
            <td align="right">
                <form action="socket_server.php" name="star_antenas" method="post">
                    <input type="submit" value="" name="icon" style="background:url(images/defaultButton_go.png); width:43px; height:43px;" onClick="alert('Servidor ejecutado. Si desea puede cerrar esta pantalla.')"/>
                    <input type="hidden" value="start_antenas" name="pedido"/>
                </form>
            </td>
            <td align="left">
                <form action="socket_server.php" name="stop_antenas" method="post">
                    <input type="submit" value="" name="icon" style="background:url(images/defaultButton_cancel.png); width:43px; height:43px;"/>
                    <input type="hidden" value="stop_antenas" name="pedido"/>
                </form>
            </td>-->
        </tr>
    </table>

</td></tr></table>

<?php include("../common/footer.php");?>
	</body>
</html>
