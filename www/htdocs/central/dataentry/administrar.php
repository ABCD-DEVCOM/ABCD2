<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>


<script languaje=javascript>

function Activar(Opcion){
	if (top.base==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}else{
		seleccionados=""
		<?php
			if (isset($arrHttp["seleccionados"])){
				echo 'seleccionados=\'&seleccionados='.$arrHttp["seleccionados"]."'\n";
			}
		?>
		switch (Opcion){
			case "imptxt":
				self.location="carga_txt_cnv.php?base="+top.base+"&Opcion=cnv&accion=import&tipo=txt&lang=<?php echo $_SESSION["lang"]?>"
				break
			case "exptxt":
				self.location="carga_txt_cnv.php?base="+top.base+"&Opcion=cnv&accion=export&tipo=txt&lang=<?php echo $_SESSION["lang"]?>"
				break
			case "expiso":
				self.location="exporta_txt.php?base="+top.base+"&cipar="+top.base+".par&tipo=iso&lang=<?php echo $_SESSION["lang"]?>"+seleccionados
				break
			case "impiso":
				self.location="carga_iso.php?base="+top.base+"&cipar="+top.base+".par&tipo=iso&lang=<?php echo $_SESSION["lang"]?>"
				break
			case "soporte":
				self.location="soporte.php?base="+top.base+"&cipar="+top.base+".par"
				break

		}
	}
}
function EnviarForma(Opcion,Mensaje){
	if (top.base==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}else{
	//	if (confirm(Mensaje)==true){
			switch (Opcion){
				case "fullinv":
					msgwin=window.open("","fullinv","menu=no,status,resizable,scrollbars")
					msgwin.document.writeln("<html><title><?php echo $msgstr["mnt_gli"]?></title><body><font color=red face=verdana><?php echo $msgstr["mnt_lig"].". ".$msgstr["mnt_espere"]?> ...")
					msgwin.document.writeln("</body></html>")
					msgwin.focus()
					document.admin.target="fullinv"
					break
				case "estructuras":
					document.admin.action="orbita_estructuras.php"
					document.admin.target=""
					break;
				case "eliminarbd":
					document.admin.action="eliminarbd.php"
					document.admin.target=""
					break;
				case "globalc":
					document.admin.action="c_global.php"
					document.admin.target=""
					break;
				case "listar":
				case "unlock":
					document.admin.action="mfn_ask_range.php";
					document.admin.target=""
					break;
				default:
					document.admin.target=""
					break;
				case "dbcp":
					document.admin.action="copy_db.php";
					document.admin.target=""
					break;
				case "fullinvMX":
				    document.admin.action="../utilities/vmx_fullinv.php"
				    document.admin.target=""
			}
			document.admin.Opcion.value=Opcion
			document.admin.base.value=top.base
			document.admin.cipar.value=top.base+".par"
			document.admin.submit()
		}


//	}
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"]) and $arrHttp["encabezado"]=="s"){
	include("../common/institutional_info.php");
}
 echo "
	<div class=\"sectionInfo\">
		<div class=\"breadcrumb\">".
			 $msgstr["mantenimiento"]."
		</div>
		<div class=\"actions\">\n";
if (isset($arrHttp["encabezado"])){
			echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>";
}
echo "	</div>
		<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/administrar.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php

$db=$arrHttp["base"];
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/administrar.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: administrar.php" ?></font>
	</div>

	<div class="middle homepage">
<?php if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or
          isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
          isset($_SESSION["permiso"]["CENTRAL_IMPEXP"]) or
          isset($_SESSION["permiso"]["CENTRAL_IMPORT"]) or
          isset($_SESSION["permiso"]["CENTRAL_EXPORT"]) or
          isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or
          isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or
          isset($_SESSION["permiso"][$db."_CENTRAL_IMPEXP"]) or
          isset($_SESSION["permiso"][$db."_CENTRAL_IMPORT"]) or
          isset($_SESSION["permiso"][$db."_CENTRAL_IMPORT"])){
?>
		<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
			<div class="boxTop">
				<div class="btLeft">&#160;</div>
				<div class="btRight">&#160;</div>
			</div>
			<div class="boxContent titleSection">
				<div class="sectionTitle">
					<h4><strong><?php echo $msgstr["cnv_import"]?></strong></h4>
				</div>
				<div class="sectionButtons">
					<a href=javascript:Activar("impiso") class=""">
						<span><strong><?php echo $msgstr["cnv_iso"]?></strong></span></a>
						<a href=../documentacion/ayuda.php?help=<?php echo $lang?>/importiso.html target=_blank><img src=img/barHelp.png border=0 align=absmiddle></a>&nbsp &nbsp;
       	<?PHP if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/importiso.html target=_blank>edit help file</a>"?>
                           <br>
        					<a href=javascript:Activar("imptxt") class="">
						<ximg src="../images/mainBox_iconBorder.gif" alt="" title="" />
						<span><strong><?php echo $msgstr["cnv_txt"]?></strong></span>
					</a>
                       <a href=../documentacion/ayuda.php?help=<?php echo $lang?>/txt2isis.html target=_blank><img src=img/barHelp.png border=0 align=absmiddle></a>&nbsp &nbsp;
       	<?PHP if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/txt2isis.html target=_blank>edit help file</a>"?>
		<br>
				</div>
				<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
				<div class="bbLeft">&#160;</div>
				<div class="bbRight">&#160;</div>
			</div>
		</div>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
    isset($_SESSION["permiso"]["CENTRAL_IMPEXP"]) or
    isset($_SESSION["permiso"]["CENTRAL_EXPORT"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_IMPEXP"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_EXPORT"])){
?>
		<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
			<div class="boxTop">
				<div class="btLeft">&#160;</div>
				<div class="btRight">&#160;</div>
			</div>
			<div class="boxContent toolSection">
				<div class="sectionTitle">
					<h4>&#160;<strong><?php echo $msgstr["cnv_export"]?></strong></h4>
				</div>
				<div class="sectionButtons">
					<a href=javascript:Activar("expiso")><?php echo $msgstr["cnv_iso"]?></a>
					<a href=../documentacion/ayuda.php?help=<?php echo $lang?>/exportiso.html target=_blank><img src=img/barHelp.png border=0 align=absmiddle></a>&nbsp &nbsp;
       				<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/exportiso.html target=_blank>edit help file</a>"?>
					<br><a href=javascript:Activar("exptxt")><?php echo $msgstr["cnv_txt"]?></a>
					<a href=../documentacion/ayuda.php?help=<?php echo $lang?>/exporttxt.html target=_blank><img src=img/barHelp.png border=0 align=absmiddle></a>&nbsp &nbsp;
       				<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/exporttxt.html target=_blank>edit help file</a>"?>
				</div>
				<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
				<div class="bbLeft">&#160;</div>
				<div class="bbRight">&#160;</div>
			</div>
		</div>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
    Isset($_SESSION["permiso"]["CENTRAL_UNLOCKDB"]) or
    isset($_SESSION["permiso"]["CENTRAL_LISTBKREC"]) or
    isset($_SESSION["permiso"]["CENTRAL_UNLOCKDBREC"]) or
    isset($_SESSION["permiso"]["CENTRAL_FULLINV"]) or
    isset($_SESSION["permiso"]["CENTRAL_COPYDB"]) or
    isset($_SESSION["permiso"]["CENTRAL_GLOBC"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDB"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_LISTBKREC"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDBREC"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_FULLINV"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_COPYDB"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_GLOBC"])
    ){
?>
		<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
			<div class="boxTop">
				<div class="btLeft">&#160;</div>
				<div class="btRight">&#160;</div>
			</div>
			<div class="boxContent toolSection">
				<div class="sectionTitle">
					<h4>&#160;<strong><?php echo $msgstr["mantenimiento"]?></strong></h4>
				</div>
				<div class="sectionButtons">
<?php
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"])  or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
	isset($_SESSION["permiso"]["CENTRAL_UNLOCKDB"]) or
	isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDB"])
    ){
?>
					<a href='javascript:EnviarForma("unlockbd","<?php echo $msgstr["mnt_desb"]?>")'><?php echo $msgstr["mnt_desb"]?></a><br>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"])  or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
	isset($_SESSION["permiso"]["CENTRAL_LISTBKREC"]) or
	isset($_SESSION["permiso"][$db."_CENTRAL_LISTBKREC"])
    ){
?>
					<a href='javascript:EnviarForma("listar","<?php echo $msgstr["mnt_rlb"]?>")'><?php echo $msgstr["mnt_rlb"]?></a><br>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"])  or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
	isset($_SESSION["permiso"]["CENTRAL_UNLOCKDBREC"]) or
	isset($_SESSION["permiso"][$db."_CENTRAL_UNLOCKDBREC"])
    ){
?>
					<a href='javascript:EnviarForma("unlock","<?php echo $msgstr["mnt_dr"]?>")'><?php echo $msgstr["mnt_dr"]?></a><br>
<?php }

if (isset($_SESSION["permiso"]["CENTRAL_DBUTILS"])  or
    isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
	isset($_SESSION["permiso"]["CENTRAL_FULLINV"]) or
	isset($_SESSION["permiso"][$db."_CENTRAL_FULLINV"])
    ){
?>
					<a href='javascript:EnviarForma("fullinv","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"]. " <font color=red>(WXIS)</font>"?></a><br>
					<a href='javascript:EnviarForma("fullinvMX","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"]. " <font color=red>(MX)</font>"?></a><br>
<?php
}

if (isset($_SESSION["permiso"]["CENTRAL_GLOBC"]) or
    isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"]["CENTRAL_ALL"])     or
    isset($_SESSION["permiso"][$db."_CENTRAL_GLOBC"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){			echo "
					<a href='javascript:EnviarForma(\"globalc\",\"Global changes\")'>". $msgstr["mnt_globalc"]."</a><br>";

}
?>
           			<a href=../documentacion/ayuda.php?help=<?php echo $lang?>/mantenimiento.html target=_blank><img src=img/barHelp.png border=0 align=absmiddle></a>&nbsp &nbsp;
       				<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/mantenimiento.html target=_blank>edit help file</a>"?>
				</div>
				<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
				<div class="bbLeft">&#160;</div>
				<div class="bbRight">&#160;</div>
			</div>
		</div>
<?php }?>
	</div>

<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
<?php
if (isset($arrHttp["seleccionados"])){	echo "<input type=hidden name=seleccion value=".$arrHttp["seleccionados"].">\n";}
?>
</form>
</div>
<?php include("../common/footer.php"); ?>
</body>
</html>
