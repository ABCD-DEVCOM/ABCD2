<?php
/* Modifications
2021-04-20 fho4abcd Created from readiso_mx and reduce functionality to iso files
*/
/*
** Shows the content of an .iso file o file by mx
** Intended to visually judge if a file is correcly exported or that a file can be importedt
** This function relies (as many functions) on a selected database: config.php sets the basic context.
** Required html variables for this purpose:
** - $arrHtpp["storein"]  : Path,  relative to $db_path, of the folder with the file to list. 
** - $arrHtpp["copyname"] : The name of the file to list.
**
** - ISO-2709 files can be coded in ansi or utf8. No indicator is present which is used
**   Files MAY have such an indicator, known as BOM or signature mark
**   This indicator is normally hidden but some readers my show it. Value EF BB BF
**   MX does not add or process this indicator (best guess from behavior)
** This result in following algorithm:
** -a config.php sets the default $meta_encoding.
**    config.php sets also $charset of the current database.
** -b The characterset of the caller is used by default.
** -c The may may select an alternative from a menu to judge te effect
**
** ISO files are not dependent on the ABCD/ISIS implementation. All exe's (should be) valid.
** The code uses the exe of the seleected set. Just to reassure the operator.
**
** mx does not honour the "from" clause for iso files.(Bug?)
** The code reads always all (to "to") records and skips the display up to the "from" record.
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
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
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$backtoscript="../dataentry/administrar.php"; // The default return script
$inframe=1;                                   // The default runs in a frame
$charset_db=$charset;                         // Save the database characterset
$charset_menu_val=$charset;                   // The default is the characterset of the selected database
if ( isset($arrHttp["backtoscript"]))     $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))          $inframe=$arrHttp["inframe"];
if ( isset($arrHttp["charset_menu_val"])) $charset_menu_val=$arrHttp["charset_menu_val"];
$charset = $charset_menu_val;                 // Set possible alternative characterset
include("../common/header.php");              // THIS SETS THE DISPLAYED CHARACTERSET

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function doNext(selectvalue){
    document.continuar.charset_menu_val.value=selectvalue
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit()
}
function doReload(selectvalue, fromval, toval){
    document.continuar.fromiso.value=fromval
    document.continuar.toiso.value=toval
    document.continuar.charset_menu_val.value=selectvalue
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit();
}
</script>
<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo "...".$msgstr["show"]." ".$msgstr["cnv_iso"]?>
	</div>
	<div class="actions">
<?php
        $backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;
        if (isset($arrHttp["backtoscript_org"])) $backtourl.="&backtoscript=".$arrHttp["backtoscript_org"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
$ichecked="";
$uchecked="";
if ( $charset_menu_val=="UTF-8")
    $uchecked="selected";
else
    $ichecked="selected";
if (!isset($arrHttp["fromiso"]))
	$arrHttp["fromiso"]=1;
if (!isset($arrHttp["toiso"]))
	$arrHttp["toiso"]=20;
$fromiso=$arrHttp["fromiso"];
$toiso=$arrHttp["toiso"];
$count_read= 0;
$count_invisible=$arrHttp["fromiso"]-1;
$count=$arrHttp["toiso"]-$arrHttp["fromiso"];
$arrHttp["fromiso"]=$arrHttp["toiso"]+1;
$arrHttp["toiso"]=$arrHttp["fromiso"]+$count;
?>
<div class="middle form">
<div class="formContent">
    <a name="top"></a>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <div align=center><h3><?php echo $msgstr["show"]." ".$msgstr["cnv_iso"] ?></h3>
    <form name=continuar action=mx_show_iso.php method=post>
        <table style=text-align:right cellspacing=1 cellpadding=4>
        <tr  style=text-align:center>
            <th colspan=2 bgcolor=#e7e7e7><?php echo $msgstr["code"]?></th>
            <th colspan=7 bgcolor=#e5e5e5><?php echo $msgstr["cnv_iso"]." ".$msgstr["r_recsel"];?></th>
        </tr>
        <tr><td><?php echo $msgstr["database"];?></td>
            <td><?php echo $charset_db;?></td>
            <td><?php echo $msgstr["selected_records"];?></td>
            <td><?php echo $msgstr["cg_from"].":";?></td>
            <td><?php echo $fromiso;?></td>
            <td><?php echo $msgstr["cg_to"].":";?></td>
            <td><?php echo $toiso;?></td>
            <td></td>
        </tr>
        <tr><td><?php echo $msgstr["show"]." ".$msgstr["file"]." in";?></td>
            <td><select name=selcharset  id="selcharset" onchange="doReload(this.value,<?php echo $fromiso?>,<?php echo $toiso?>)">
                    <option value='ISO-8859-1' <?php echo $ichecked;?> >ISO-8859-1</option>
                    <option value='UTF-8' <?php echo $uchecked;?> >UTF-8</option>
                </select>
            </td>
            <td><?php echo $msgstr["r_recsel"];?></td>
            <td><?php echo $msgstr["cg_from"].":";?></td>
            <td><input type=text name=fromiso size=5 style="text-align:right;" value=<?php echo $arrHttp["fromiso"];?>></td>
            <td><?php echo $msgstr["cg_to"].":";?></td>
            <td><input type=text name=toiso size=5 style="text-align:right;" value=<?php echo $arrHttp["toiso"];?>></td>
            <td><input type=button value=<?php echo $msgstr["ejecutar"];?> onclick="doNext('<?php echo $charset_menu_val;?>')"></td>
        </tr>
        </table>
        <input type=hidden name="charset_menu_val" value="">
        <br>
<?php
        foreach ($_REQUEST as $var=>$value){
            if (trim($value)!="" and $var!="charset_menu_val" and $var!="fromiso" and $var!="toiso")
                echo "<input type=hidden name=$var value=\"$value\">\n";
        }
?>
        </form></div>
<?php
// $db is the full path of the file (iso/mst) to list
$db=$db_path.$arrHttp["storein"]."/".$arrHttp["copyname"];

// set excutable dependent on displayed characterset
// See config php
if ($charset=="UTF-8") {
    $cisis_path=$cgibin_path."utf8";
}else {
    $cisis_path=$cgibin_path."ansi";
}
if ($cisis_ver!="") $cisis_path.="/".$cisis_ver."/";   // path to directory with correct CISIS-executables
else 	            $cisis_path.="/";
$mx_path=$cisis_path.$mx_exec;             // path to mx-executable

// Prepare the command
// Note that "from"is not present: mx does not honour this option for ISO files
$command=$mx_path." iso=$db   to=$toiso  2>&1";

// Read the content of the iso file
exec($command,$contenido,$res);
echo "<div><font face='courier new' color=blue>Command line: $command<br>";
echo "Execution status: $res </font></div></br>";

/* Display the content line by line
** The output consist of formatted lines. 2 formats
** 1:for each mfn      : "mfn= ,number>" (first), "..mfn= number" (subsequent)
** 2:for each attribute: "<number> <marker><content><marker>
** - The <content> may consist of several lines
** - The leading and trailing marker are from characterset CP437 (why?)
** - These markers (« ») are not correctly displayed in the browser ( ? in black diamond)
**                       are not correctly displayed in a command window (a very strange character)
**   Integer value of displayed left and right marker in by UTF-8 mx is 194 (reverse engineered)
**   Integer value of displayed left and right marker in by ANSI mx is 174/175 (reverse engineered)
**   Next marker code will produce more readable output
**   Marker « = dec 171,hex AB/html &#171; or &laquo; / Unicode \u00AB
**   Marker » = dec 187,hex BB/html &#187; or &raquo; / Unicode \u00BB
**   Best solution is transfer them in html (ensures correct display)
*/
foreach ($contenido as $value) {
    if ( strcmp($charset, "UTF-8")==0 ) {
        if ( ord(substr($value,-1))==194) $value=substr($value,0,-1)."&raquo;";
        $spacepos=strpos($value," ".chr(194));
    } else {
        if ( ord(substr($value,-1))==175) $value=substr($value,0,-1)."&raquo;";
        $spacepos=strpos($value," ".chr(174));
    }
    if ( $spacepos!==false) {
        $value=substr_replace($value," &laquo;",$spacepos,2);
    }
    if ($res==0) { 
        if ( substr($value,0,6)==="..mfn="){
            $count_read++;
            if ($count_read>=$count_invisible) echo "<hr>";
        }
        if ($count_read>=$count_invisible) echo $value."<br>";
    }
    if ($res!=0) echo "<font color=red>".$value."<br></font>";
}
?>
<br>
<a href="#top"><?php echo $msgstr["up"] ?> <img src='/central/dataentry/img/up2.gif'></a>
</div>
</div>
<?php

include("../common/footer.php");
?>

</body>
</html>
