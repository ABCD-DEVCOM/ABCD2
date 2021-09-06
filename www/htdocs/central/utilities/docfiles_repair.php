<?php
/* Modifications
20210903 fho4abcd Created
**
** This file contains functionality for the mitigation of
** - Field url: v98 contains no url but only a filename
** - Field htmlSrcURL: v95 contains no url but is empty
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../lang/importdoc.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$backtoscript="../dataentry/incio_main.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$repdoc_cnfcnt=1;
if ( isset($arrHttp["backtoscript"]))  $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))       $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["repdoc_cnfcnt"])) $repdoc_cnfcnt=$arrHttp["repdoc_cnfcnt"];
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function BorrarExpresion(){
	document.forma1.Expresion.value=''
}
function BorrarRango(){
	document.forma1.Mfn.value=''
	document.forma1.to.value=''
}
function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
	FormatoActual="&Formato="+base
  	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar+FormatoActual
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=850,height=400")
	msgwin.focus()
}
function Execute(){
	document.forma1.repdoc_cnfcnt.value=2
	document.forma1.submit()
}
function Cancel(){
	document.forma1.action='<?php echo $backtoscript;?>'
	document.forma1.submit()
}

</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php   echo $msgstr["mantenimiento"].": ".$msgstr["dd_repair"];
?>
	</div>
	<div class="actions">
<?php
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
include ("../common/inc_get-dbinfo.php");// sets MAXMFN
// Set collection related parameters and create folders if not present
include "../utilities/inc_coll_chk_init.php";
// Include configuration functions
include "inc_coll_read_cfg.php";
/* =======================================================================
/* ----- First screen: Request options -*/
if ($repdoc_cnfcnt==1) {
?>
<div class="middle form">
<div class="formContent">
<div align=center>
<br>
<form name=forma1 method=post>
    <input type=hidden name=repdoc_cnfcnt>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
    <input type=hidden name=maxmfn value=<?php echo $arrHttp["MAXMFN"]?>>
    <input type=hidden name=backtoscript value="<?php echo $backtoscript?>">
    <input type=hidden name=inframe value=<?php echo $inframe?>>
    <input type=hidden name=Accion>
    <?php
    $actualField=array();
    $retval= read_dd_cfg("operate", $metadataConfigFull, $metadataMapCnt,$actualField );
    if ($retval!=0) die;
    for ($i=0;$i<$metadataMapCnt;$i++) {
        echo "<input type=hidden name=".$actualField[$i]["term"]." value='".$actualField[$i]["field"]."'>\n";
    }
    ?>
<table cellpadding=5 border=0 background=../dataentry/img/fondo0.jpg >
	<tr>
		<td colspan=2 align=center  bgcolor=#cccccc><?php echo $msgstr["r_recsel"]?></td>
	<tr>
		<td align=center colspan=2><?php echo $msgstr["r_mfnr"]?><br></td>
	<tr>
		<td width=50% align=right>
            <?php echo $msgstr["r_desde"]?>:&nbsp;<input type=text name=Mfn size=10 value=1 >&nbsp; &nbsp;
        </td>
		<td width=50%>
            <?php echo $msgstr["r_hasta"]?>:&nbsp;<input type=text name=to size=10 value=<?php echo $arrHttp["MAXMFN"]; ?>>
		    <?php echo $msgstr["maxmfn"]?>:&nbsp;<?php echo $arrHttp["MAXMFN"] ?>&nbsp;<a href=javascript:BorrarRango() class=boton><?php echo $msgstr["borrar"]?></a>
        </td>
		<?php
			if (isset($arrHttp["seleccionados"])){
				echo "<tr>
				<td colspan=2><strong>".$msgstr["selected_records"]."</strong>: &nbsp;";
				$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
				$sel=str_replace("_","",$sel);
				echo "<input type=text name=seleccionados size=80 value=$sel>\n";
				echo "</td></tr>";
			}else{ // next line required to suppress javascript errors
				echo "<tr><td colspan=2><input type=hidden name=seleccionados>\n</td></tr>";
			}
		?>
	<tr>
		<td colspan=2><hr></td>
	<tr>
		<td align=center colspan=2><?php echo $msgstr["r_busqueda"]?></td>
    </tr>
	<tr>
    <td colspan=2>
        <table>
            <tr><td>
                    <a href=javascript:Buscar()><img src=../dataentry/img/barSearch.png height=24 border=0 title="<?php echo $msgstr["m_indice"]?>"></a>&nbsp;&nbsp;
                </td>
                <td>
                    <input type=text name=Expresion size=90>
                </td>
                <td>
                    &nbsp;&nbsp;<a href=javascript:BorrarExpresion()><?php echo $msgstr["borrar"]?></a></td>
            </tr>
        </table>
    </td>
    </tr>
    <tr>
		<td colspan=2 align=center  bgcolor=#cccccc><?php echo $msgstr["dd_rep_options"]?></td>
	</tr>
</table>
<table>
<tr>
    <td><input type=checkbox id=rep_htmlsrcurl name="rep_htmlsrcurl" value=1 checked></td>
    <td><?php echo $msgstr["dd_rep_content"].":  ".$msgstr["dd_term_htmlSrcURL"];?></td>
</tr>
<tr>
    <td><input type=checkbox id=rep_docurl name="rep_docurl" value=1 checked></td>
    <td><?php echo $msgstr["dd_rep_content"].":  ".$msgstr["dd_term_url"];?></td>
</tr>
<tr>
    <td colspan=2 style='text-align:center'>
        <input type=button name=continuar value="<?php echo $msgstr["procesar"]?>" onclick=Execute()>
        &nbsp; &nbsp;
        <input type=button name=cancelar value="<?php echo $msgstr["cancelar"] ?>" onclick=Cancel()>
    </td>
</tr>
</table>

<?php
/* =======================================================================
/* ----- Second screen: execute function and show result -*/
}
else if ($repdoc_cnfcnt==2) {
?>
<div class="middle form">
    <div align=center><h3><?php echo $msgstr["dd_rep_execresults"] ?></h3>
<?php
if ( isset($arrHttp["Mfn"])) $fromMfn=$arrHttp["Mfn"];
if ( isset($arrHttp["to"]))  $toMfn=$arrHttp["to"];
var_dump($fromMfn);var_dump($fromMfn);
echo "<div> Under construction</div>";
}
?>
</div>
</div>
<?php
include "../common/footer.php";
?>
</body>
</html>
