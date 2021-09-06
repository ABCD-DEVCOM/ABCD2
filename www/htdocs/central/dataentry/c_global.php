<?php
/* Modifications
20210312 fho4abcd Replaced helper code fragment by included file
20210312 fho4abcd html move body + sanitize html
20210623 fho4abcd Rewrite:pop-up to second screen, remove historical remains, code readability.
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include("../common/header.php");
/*
** Set defaults for the return script,frame info and more
*/
$backtoscript="../dataentry/administrar.php"; // The default return script
$confirmcount   =0;
$errors         =0;
$base           =$arrHttp["base"];
$cipar          =$arrHttp["base"]."par";
$fromval="";
$toval="";
$expresionval="";
if (isset($arrHttp["confirmcount"]))$confirmcount=$arrHttp["confirmcount"];
if (isset($arrHttp["from"]))        $fromval=Trim($arrHttp["from"]);
if (isset($arrHttp["to"]))          $toval=Trim($arrHttp["to"]);
if (isset($arrHttp["Expresion"]))   $expresionval=Trim($arrHttp["Expresion"]);


// Read the fdt
include("leer_fdt.php");

$Fdt_unsorted=LeerFdt($base);
$Fdt=array();
foreach ($Fdt_unsorted as $value){
	$f=explode('|',$value);
	$Fdt[$f[2]]=$value;
}
ksort($Fdt);

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}
?>
<body>
<script language="JavaScript" type="text/javascript" src="js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src=js/windowdhtml.js></script>
<script language="JavaScript">
function Confirmar(){
	document.forma1.confirmcount.value++;
	document.getElementById('preloader').style.visibility='visible'
	document.forma1.submit()
}
function Cancel(){
	document.getElementById('preloader').style.visibility='visible'
	document.checked.submit()
}
function Execute(){
	document.getElementById('preloader').style.visibility='visible'
    document.checked.action='c_global_ex.php'
	document.checked.submit()
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
	ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1) ix=0
	Formato=top.menu.document.forma1.formato.options[ix].value
	FormatoActual="&Formato="+Formato
	Opcion="rango"
  	Url="buscar.php?Opcion=formab&prologo=prologoact&Tabla=Expresion&Target=s&base="+base+"&cipar="+cipar+FormatoActual
  	msgwin=window.open(Url,"CGLOBAL","menu=no, scrollbars=yes, resizable=yes")
  	msgwin.focus()
}

</script>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cg_titulo"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php 
        $backtourl=$backtoscript."?base=".$arrHttp["base"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $ayuda="cglobal.html"; include "../common/inc_div-helper.php"; ?>
<div class="middle form">
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
<div class="formContent">
<div align=center>
<?php
if ($confirmcount==0) {
    /*
    ** First screen with all parameters
    ** Note that the first sreen is also shown to modify the value after check with second screen
    */
    // defaults for radio buttons
    $rad_agregar="";
    $rad_modificar="";
    $rad_eliminar="";
    $rad_agregarocc="";
    $rad_modificarocc="";
    $rad_eliminarocc="";
    $rad_dividir="";
    $rad_mover="";
    if ( isset($arrHttp["tipoc"])) {
        if ($arrHttp["tipoc"] == "agregar" )      $rad_agregar="checked";
        if ($arrHttp["tipoc"] == "modificar" )    $rad_modificar="checked";
        if ($arrHttp["tipoc"] == "eliminar" )     $rad_eliminar="checked";
        if ($arrHttp["tipoc"] == "agregarocc" )   $rad_agregarocc="checked";
        if ($arrHttp["tipoc"] == "modificarocc" ) $rad_modificarocc="checked";
        if ($arrHttp["tipoc"] == "eliminarocc" )  $rad_eliminarocc="checked";
        if ($arrHttp["tipoc"] == "dividir" )      $rad_dividir="checked";
        if ($arrHttp["tipoc"] == "mover" )        $rad_mover="checked";
    }
    $rad_frase="checked"; //default
    $rad_cadena="";
    if ( isset($arrHttp["tipoa"])) {
        $rad_frase="";
        if ($arrHttp["tipoa"] == "frase" )  $rad_frase="checked";
        if ($arrHttp["tipoa"] == "cadena" ) $rad_cadena="checked";
    }
    $rad_antes=""; 
    $rad_despues="";
    if ( isset($arrHttp["posicion"])) {
        if ($arrHttp["posicion"] == "antes" )  $rad_antes="checked";
        if ($arrHttp["posicion"] == "despues" )$rad_despues="checked";
    }
    include ("../common/inc_get-dbinfo.php");// sets MAXMFN
    ?>
    <form name=forma1 method=post >
    <input type=hidden name=confirmcount value=0>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
    <input type=hidden name=MaxMfn value=<?php echo $arrHttp["MAXMFN"]?>>
    <input type=hidden name=Opcion value=<?php echo $Opcion?>>

    <table cellpadding=3 cellspacing=5 border=0 width=600>
        <tr>
            <td align=center bgcolor=#cccccc colspan=3><?php echo $msgstr["r_recsel"]?> <a href='../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#SEL' target=_blank><img src=img/barHelp.png border=0 height=12></a></td>
        </tr>
        <tr>
            <td align=left><?php echo $msgstr["cg_rango"]?> </td>
            <td align=left><?php echo $msgstr["cg_from"]?>: <input type=text name=from size=10 value='<?php echo $fromval?>'></td>
            <td align=left><?php echo $msgstr["cg_to"]?>: <input type=text name=to size=10 value='<?php echo $toval?>'>
            <?php echo " ( ".$msgstr["cg_maxmfn"].": ".$arrHttp["MAXMFN"].")";?></td>
        </tr>
        <tr>
            <td colspan=3><hr></td>
        </tr>
        <tr>
            <td  align=left valign=top><a href=javascript:Buscar()><img src=img/barSearch.png height=24 align=middle ><?php echo $msgstr["cg_search"]?> </a></td>
            <td colspan=2 align=left>
                <?php echo $msgstr["expresion"]?><br>
                <textarea rows=1 cols=80 name=Expresion><?php if (isset($arrHttp["Expresion"]))echo $Expresion;?></textarea>
            </td>
        </tr>
        <tr>
            <td valign=top align=right><br><?php echo $msgstr["cg_selfield"]?></td>
            <td align=left colspan=2><br>
                <select name=global_C><option></option>
                    <?php foreach ($Fdt as $linea){
                            $t=explode('|',$linea);
                            $tval=$t[1].'|'.$t[5].'|'.$t[6].'|'.$t[0];
                            $tname=$t[2]." (".$t[1].")";
                            if ($t[5]!="") $tname.=" (".$t[5].")";
                            $tselected="";
                            if (isset($arrHttp["global_C"]) && $arrHttp["global_C"]==$tval) $tselected="selected";
                    ?>
                    <option value='<?php echo $tval?>' <?php echo $tselected;?>> <?php echo $tname;?></option>
                    <?php
                        }
                    ?>
                </select>
                <a href='../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#CAMPO' target=_blank><img src=img/barHelp.png border=0 height=15></a>
            </td>
        </tr>
        <tr>
            <td colspan=3>&nbsp;</td>
        </tr>
        <tr>
            <td colspan=3 align=center bgcolor=#cccccc>
                <?php echo $msgstr["cg_tipoc"]?>&nbsp;
                <a href='../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#TIPO_CAMBIO' target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
                <table>
                    <tr>
                        <td><input type=radio name=tipoc value="agregar" <?php echo $rad_agregar;?>><?php echo $msgstr["cg_add"]?></td>
                        <td><input type=radio name=tipoc value="modificar" <?php echo $rad_modificar;?>><?php echo $msgstr["cg_modify"]?></td>
                        <td><input type=radio name=tipoc value="eliminar" <?php echo $rad_eliminar;?>><?php echo $msgstr["cg_delete"]?></td>
                    </tr><tr>
                        <td><input type=radio name=tipoc value="agregarocc" <?php echo $rad_agregarocc;?>><?php echo $msgstr["cg_addocc"]?></td>
                        <td><input type=radio name=tipoc value="modificarocc" <?php echo $rad_modificarocc;?>><?php echo $msgstr["cg_modifyocc"]?></td>
                        <td><input type=radio name=tipoc value="eliminarocc" <?php echo $rad_eliminarocc;?>><?php echo $msgstr["cg_deleteocc"]?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><?php echo "<font color=darkred>".$msgstr["cg_modify"]." / " .$msgstr["cg_modifyocc"]."</font>"?></td>
            <td><?php echo $msgstr["cg_scope"].": ";?><input type=radio name=tipoa value="frase" <?php echo $rad_frase;?>><?php echo $msgstr["cg_field"]?></td>
            <td><?php echo $msgstr["cg_scope"].": ";?><input type=radio name=tipoa value="cadena" <?php echo $rad_cadena;?>><?php echo $msgstr["cg_part"]?></td>
        </tr>
        <tr>
            <td colspan=3 align=left width=100%>
                <table>
                    <tr>
                        <td valign=top bgcolor=#cccccc><?php echo $msgstr["cg_valactual"]?>  <a href='../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#VALOR' target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
                        <input type=text name=actual size=100 value='<?php if (isset($arrHttp["actual"]))echo $arrHttp["actual"];?>'>
                        </td>
                    </tr><tr>
                        <td><?php echo $msgstr["cg_nuevoval"]?>:  <a href='../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/cglobal.html#NUEVO_VALOR' target=_blank><img src=img/barHelp.png border=0 height=12></a><br>
                        <input type=text name=nuevo size=100 value='<?php if (isset($arrHttp["nuevo"]))echo $arrHttp["nuevo"];?>'>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan=3 align=center bgcolor=#cccccc>
                <?php echo $msgstr["cg_tipoc"]?><br>
                <input type=radio name=tipoc value="mover" <?php echo $rad_mover;?>><?php echo $msgstr["cg_move"]?>&nbsp;
                <input type=radio name=tipoc value="dividir" <?php echo $rad_dividir;?>><?php echo $msgstr["cg_split"]?>&nbsp;
                <a href='../documentacion/ayuda.php?help=<?php echo$_SESSION["lang"]?>/cglobal.html#DIVIDIR' target=_blank><img src=img/barHelp.png border=0 height=12></a>&nbsp; &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan=3 >
                <table border=0 align=center>
                   <tr>
                        <td align=left><?php echo $msgstr["cg_moveto"]?></td>
                        <td align=left>
                            <select name=nuevotag>
                                <option value=""><?php echo $msgstr["cg_splitdel"]?></option>
<?php foreach ($Fdt as $linea){
        $t=explode('|',$linea);
        $tval=$t[1]."|".trim(substr($linea,46,2))."|".trim(substr($linea,59));
        $tname=$t[2]." (".$t[1].")";
        $tselected="";
        if (isset($arrHttp["nuevotag"]) && $arrHttp["nuevotag"]==$tval) $tselected="selected";
 ?>
                                <option value='<?php echo $tval?>' <?php echo $tselected;?>> <?php echo $tname;?></option>
<?php
    }
?>
                            </select>
                        </td>
                    </tr>
                     <tr>
                        <td><?php echo $msgstr["cg_found"]?></td>
                        <td>
                            <input type=radio name=posicion value=antes <?php echo $rad_antes;?>><?php echo $msgstr["cg_before"]?>&nbsp;
                            <input type=radio name=posicion value=despues <?php echo $rad_despues;?>><?php echo $msgstr["cg_after"]?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align=left><?php echo $msgstr["cg_delimiter"]?></td>
                        <td align=left><input type=text name=separar value='<?php if (isset($arrHttp["separar"]))echo $arrHttp["separar"];?>'></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan=3 bgcolor=#cccccc>&nbsp;</td>
    </table>
    <p>
        <input type=button value=<?php echo $msgstr["cg_execute"]?> onClick=Confirmar()>
        &nbsp; &nbsp; &nbsp;
        <input type=reset value=<?php echo $msgstr["cg_borrar"]?>>
    </p>
    </form>
<?php
} else if ($confirmcount==1) {
    /*
    ** Second screen checks the values of the first screen and shows confirmation info
    ** In case of errors the only button is to go back to the first screen
    ** If no errors occurred the execution is possible
    */
    echo "<h3>".$msgstr["cg_titulo"]."</h3>";
    // some defaults
    if ( !isset($arrHttp["actual"])) $arrHttp["actual"]="";
    if ( !isset($arrHttp["nuevo"]))  $arrHttp["nuevo"]="";
    if ( !isset($arrHttp["separar"]))$arrHttp["separar"]="";
    // error message if invalid or duplicate selection is done
    if ( $expresionval=="" ) {
        if ( ($fromval=="" && $toval=="") || ($fromval!="" && $toval=="") || ($fromval=="" && $toval!="") ) {
            echo ("<strong style='color:red'>".$msgstr["cg_selrecords"]."</strong><br>");
            $errors++;
        }
    } else {
        if ( $fromval!="" || $toval!="" ) {
            echo ("<strong style='color:red'>".$msgstr["cg_selrecords"]."</strong><br>");
            $errors++;
        }
    }
    // error message if range is not integer or > maxmfn
    if ( $fromval!="" && $toval!="") {
        if ( !is_numeric($fromval) || !is_numeric($toval)) {
            echo ("<strong style='color:red'>".$msgstr["cg_rangoinval"]."</strong><br>");
            $errors++;
        } else if ( intval($toval)<intval($fromval)) {
            echo ("<strong style='color:red'>".$msgstr["cg_rangoinval"]."</strong><br>");
            $errors++;
        } else if (intval($toval) > intval($arrHttp["MaxMfn"])) {
            echo ("<strong style='color:red'>".$msgstr["cg_rangoinval"]."</strong><br>");
            $errors++;
        }
    }
    // error message if source field is missing
    if ( !isset($arrHttp["global_C"]) || $arrHttp["global_C"]=="" ) {
		echo ("<strong style='color:red'>".$msgstr["cg_sel"]."</strong><br>");
        $arrHttp["global_C"]="";
		$errors++;;
    }
    // error message if global change type is missing
    if ( !isset($arrHttp["tipoc"])) {
		echo ("<strong style='color:red'>".$msgstr["cg_tipoc"]."</strong><br>");
        $arrHttp["tipoc"]="";
		$errors++;;
    }
    // error message if change Split Field has no information how to do that
    if ($arrHttp["tipoc"]=="dividir") {
        if ( !isset($arrHttp["posicion"]) ) {
            echo ("<strong style='color:red'>".$msgstr["cg_posicion"]."</strong><br>");
            $arrHttp["posicion"]="";
            $errors++;
        }
        if ( $arrHttp["separar"]=="" ) {
            echo ("<strong style='color:red'>".$msgstr["cg_separador"]."</strong><br>");
            $arrHttp["separar"]="";
            $errors++;
        }
    }
    // error message if addition does not specify a target
    if ( ($arrHttp["tipoc"]=="agregar" || $arrHttp["tipoc"]=="agregarocc") && $arrHttp["nuevo"]=="" ) {
		echo ("<strong style='color:red'>".$msgstr["cg_selcontenido"]."</strong> (<i>".$msgstr["cg_nuevoval"]."</i>)<br>");
		$errors++;;
    }
    // Warning if all occurrences are deleted
    if ($arrHttp["tipoc"]=="eliminarocc") {
        if ( $arrHttp["actual"]=="" ) {
            echo ("<strong style='color:blue'>".$msgstr["cg_delallocc"]."</strong><br>");
        }
    }
    // Determine the readable selected field name and the target field name
    $tname_target=$msgstr["cg_splitdel"];
    $tname_current="";
    foreach ($Fdt as $linea){
            $t=explode('|',$linea);
            $tval=$t[1].'|'.$t[5].'|'.$t[6].'|'.$t[0];
            $tname=$t[2]." (".$t[1].")";
            if ($t[5]!="") $tname.=" (".$t[5].")";
            if ($arrHttp["global_C"]==$tval) $tname_current=$tname;
            $tvaltarget=$t[1]."|".trim(substr($linea,46,2))."|".trim(substr($linea,59));
            $tnametarget=$t[2]." (".$t[1].")";
            if ( isset($arrHttp["nuevotag"]) ) {
                if ($arrHttp["nuevotag"]==$tvaltarget) $tname_target=$tnametarget;
            }
    }
    // Determine the readable text of the change type
    $change_type="";
    switch ($arrHttp["tipoc"]){
	  	case "agregar":
	  		$change_type=$msgstr["cg_add"];
	  		break;
	  	case "agregarocc":
	  		$change_type=$msgstr["cg_addocc"];
	  		break;
	  	case "modificar":
	  		$change_type=$msgstr["cg_modify"];
	  		break;
	  	case "modificarocc":
	  		$change_type=$msgstr["cg_modifyocc"];
	  		break;
	  	case "dividir":
	  		$change_type=$msgstr["cg_split"];
	  		break;
	 	case "mover":
	  		$change_type=$msgstr["cg_move"];
	  		;
	  	case "eliminar":
	  		$change_type=$msgstr["cg_delete"];
	  		break;
	 	case "eliminarocc":
	 		$change_type=$msgstr["cg_deleteocc"];
	 		break;
    }
    // determine the subtext of the primary change type information
    $prim1="";
    $prim2="";
    if ($arrHttp["tipoc"]!="mover" && $arrHttp["tipoc"]!="dividir") {
        $prim1=$msgstr["cg_scope"];
        if ( $arrHttp["tipoa"]== "frase") $prim2=$msgstr["cg_field"];
        if ( $arrHttp["tipoa"]== "cadena")$prim2=$msgstr["cg_part"];
    }
    if ($arrHttp["tipoc"]=="mover" || $arrHttp["tipoc"]=="dividir") {
        $prim1=$msgstr["cg_moveto"];
        $prim2=$tname_target;
    }
    ?>
    <br>
    <table cellpadding=3 cellspacing=0  style='text-align:left'>
    <tr>   <!--row with info about record selection -->
        <td style='background-color:#cccccc;'><b><?php echo $msgstr["r_recsel"];?></b></td>
         <?php if ($fromval!="") { ?>
            <td><?php echo $msgstr["cg_rango"]?></td>
            <td><?php echo $msgstr["cg_from"].": ". $fromval;?></td>
            <td><?php echo $msgstr["cg_to"].": ". $toval;?></td>
         <?php } else {?>
            <td><?php echo $msgstr["expresion"]?></td>
            <td><?php echo $expresionval;?></td>
            <td></td>
         <?php } ?>
    </tr><tr>  <!-- row with info about selected field -->
        <td style='background-color:#cccccc;'><b><?php echo $msgstr["cg_selfield"];?></b></td>
        <td><?php echo $tname_current;?></td>
        <td></td>
        <td></td>
    </tr><tr>  <!-- row with primary info about change type -->
        <td style='background-color:#cccccc;'><b><?php echo $msgstr["cg_tipocs"];?></b?</td>
        <td><?php echo $change_type;?></td>
        <td><?php echo $prim1.": ". $prim2?></td>
        <td></td>
    </tr>
    <?php // the  secondary info about the change requires php
    if ($arrHttp["tipoc"]!="mover" && $arrHttp["tipoc"]!="dividir") {
        ?>
         <tr>  <!-- rows with secondary info about change type -->
            <td style='background-color:#cccccc;'></td>
            <td colspan=2><i><?php echo $msgstr["cg_valactual"]?></i></td>
            <td>&rarr;<?php echo $arrHttp["actual"];?>&larr;</td>
         </tr><tr>
            <td style='background-color:#cccccc;'></td>
            <td colspan=2><i><?php echo $msgstr["cg_nuevoval"]?></i></td>
            <td>&rarr;<?php echo $arrHttp["nuevo"];?>&larr;</td>
         </tr>
       <?php
    } else if ($arrHttp["tipoc"]=="dividir" ) {
        $second="";
        if ( $arrHttp["posicion"]=="antes") $second=$msgstr["cg_before"];
        if ( $arrHttp["posicion"]=="despues") $second=$msgstr["cg_after"];
        ?>
         <tr>  <!-- row with secondary info about change type -->
            <td style='background-color:#cccccc;'></td>
            <td><i><?php echo $msgstr["cg_found"]?></i></td>
            <td><?php echo $second;?></td>
            <td>&rarr;<?php echo $arrHttp["separar"];?>&larr;</td>
         </tr>
        <?php
    }
    ?>
    </table>
    <form name=checked  method=post >
        <?php
        foreach ($_REQUEST as $var=>$value){
            if ( $var!= "confirmcount" ){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
        ?>
        <p> <?php if ( $errors==0 ) {?>
                <input type=button value='<?php echo $msgstr["procesar"];?>' onclick=Execute()>
            <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type=button value='<?php echo $msgstr["cancelar"];?>' onclick=Cancel()>
        </p>
    </form>
    <?php
}
?>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>

</body>
</html>

