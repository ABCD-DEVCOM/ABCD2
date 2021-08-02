<?php
/* Modifications
2021-03-29 fho4abcd Replaced helper code fragment by included file
2021-03-29 fho4abcd Improved html & code:Removed ghost code, correct display of « »
2021-04-18 fho4abcd Improved backbutton:send also &inframe and if necessary &backtoscript
2021-08-02 fho4abcd Remove $inframe. Make standalone call possible
*/
/*
** Shows the content of a .iso file or a .mst file by mx
** Important (optional) html variables for this purpose:
** - $arrHtpp["storein"]  : Path,  relative to $db_path, of the folder with the file to list. 
** - $arrHtpp["copyname"] : The name of the file to list.
** - $arrHtpp["charset"]  : The characterset to be used
** If these variables are not set the script displays explore/selection menus
** The effect is three situations:
** -1 storein and copyname are not set: the user may select any mst or iso file
** -2 storein is set: The user may select an mst or iso file in the given folder
** -3 storein and copy name are both set: the user cannot select anything
**
** The determination of the characterset to be used by this reader is not simple:
** - ISO-2709 files can be coded in ansi or utf8. No indicator is present which is used
**   Files MAY have such an indicator, known as BOM or signature mark
**   This indicator is normally hidden but some readers my show it. Value EF BB BF
**   MX does not add or process this indicator (best guess from behavior)
** This result in following algorithm:
** -a config.php sets the default $meta_encoding.
**    config.php sets also $charset of the current database.
**    The user may select another mst file, so $charset info is ignored.
** -b In case of an mst the characterset will be found in dr_path.def
** -c In case of an ISO the set CAN be given by the caller (when launched for the export menu)
** -d If no informtion is found the default meta_encoding will be used.
**
** ISO files are not dependent on the ABCD/ISIS implementation. All exe's (should be) valid.
** MST files are dependent on the implementation. Actual .exe will be determined by actual dr_path value
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
** Old code might not send specific info.
** Set defaults for the return script and frame info
*/
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];

include("../common/header.php");

//==================== Functions =============================
Function Explorar(){
global $msgstr;
	echo "<form name=upload method=post onsubmit=\"EnviarFormaUpload();return false;\">";
	foreach ($_REQUEST as $var=>$value){
		echo "<input type=hidden name=$var value=\"$value\">\n";
	}
	echo "
	<table><tr><td valign=top>
	";
	echo $msgstr["mx_folder"];
	echo "</td><td>
<input type=text name=storein size=30 onclick=javascript:blur()> <a href=javascript:Explorar()>";
	echo $msgstr["explore"];
	echo "</a><br>";
	echo "<p><input type=submit value=".$msgstr["procesar"].">\n
	<td></tr></table>\n
	</form>";
    die;
}

/*--------------------------------------------------------------*/
function ShowDatabases($storein,$db_path){
global $msgstr,$arrHttp;
	$Dir=$db_path.$storein;
	$handle = opendir($Dir);
	$ix=0;
	echo "<table bgcolor=#cccccc border=0 cellpadding=8>";
	while (false !== ($file = readdir($handle))) {
	   	if ($file != "." && $file != "..") {
	   		$f=$file;
	   		$file=$Dir."/".$file;
	   		if(is_file($file)){
	   			if ( pathinfo ( strtolower($file) , PATHINFO_EXTENSION)=="iso" or  pathinfo ( strtolower($file) , PATHINFO_EXTENSION)=="mst"){
		   			$ix=$ix+1;
		            $the_array["name"]=$file;
		            $dateFormat = "D d M Y g:i A";
					$ctime = filectime($file);
	                echo "<tr><td bgcolor=white><input type=radio name=db_sel value='".$f."'> $f</td>";
	                echo "<td bgcolor=white>".date($dateFormat, $ctime) . "</td>";
	                echo "<td bgcolor=white>".number_format(filesize($file))."</td></tr>";
	             }
	   		}
		}
	}
	echo "</table>";
	echo "<input type=hidden name=db_sel>\n";
	echo "<input type=hidden name=copyname>\n";
	if ($ix==0){
		echo "<h4>".$msgstr["mx_nodb"]."</h4>";
		die;
	}
	closedir($handle);
	echo "<p><input type=submit value=".$msgstr["procesar"].">\n";
	echo "</form></body></html>";
	die;
}
//----------------------- End functions --------------------------------------------------
?>
<body>

<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function Explorar(){
	msgwin=window.open("../dataentry/dirs_explorer.php?desde=dbcp&Opcion=explorar&base=<?php echo $db_path?>&mx=s&tag=document.forma1.dbfolder","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
    msgwin.focus()
}


function Limpiar(){
	fld=Trim(document.upload.storein.value)
	if (fld.substr(0,1)=="/"){
		fld=fld.substring(1)
		document.upload.storein.value=fld
	}
}

function EnviarFormaUpload(){
	Limpiar()
	if (Trim(document.upload.storein.value)==""){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["folder_name"]?>")
		return
	}
	document.upload.submit();
}

function EnviarFormaMX(){
	selected_db=""
	for (i=0;i<document.continuar.db_sel.length-1;i++){
		if(document.continuar.db_sel[i].checked){
			document.continuar.copyname.value=document.continuar.db_sel[i].value
			selected_db="OK"
		}
	}
	if (selected_db=="OK")
		document.continuar.submit()
	else
		alert("<?php echo $msgstr["mx_select"]?>")
}
</script>
<?php
// Show institutional info
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["mx_dbread"]?>
	</div>
	<div class="actions">
<?php
        if (!isset($arrHttp["base"]))$arrHttp["base"]="_no db set_";
        $backtourl=$backtoscript."?base=".$arrHttp["base"];
        if (isset($arrHttp["backtoscript_org"])) $backtourl.="&backtoscript=".$arrHttp["backtoscript_org"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">
    <div align=center><h3><?php echo $msgstr["mx_dbread"] ?></h3></div>
<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
// The character set from the config_file cannot be trusted (may be another database)
// When launched from an export the characterset and storein and copyname are given by the caller
$charset_to_use="";
if ( isset($arrHttp["charset"])) $charset_to_use=$arrHttp["charset"];

// $storein is the folder where the database or iso files will be searched
// $copyname is the name of the file
if (!isset($arrHttp["storein"])){
	Explorar();
}else{
	echo "<form name=continuar action=mx_dbread.php method=post onsubmit=\"EnviarFormaMX();return false;\">";
	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!="")
			echo "<input type=hidden name=$var value=\"$value\">\n";
	}
	if (isset($arrHttp["storein"]) and !isset($arrHttp["copyname"]) ){
		ShowDatabases($arrHttp["storein"],$db_path);
        echo "</form></body></html>";
		die;
	}

}
// At this point the foldername (storein) and filename (copyname) are set.
// Read a possible dr_path.def to get an encoding and isis version (for mst files)
// Note that iso files in the data folder will be classified as the mst file
$charset_db=$meta_encoding; // The default if no dr_path value found (or in wrk folder)
$cisis_ver_db=$def["CISIS_VERSION"];   // The default if no dr_path value found (or in wrk folder)
$toRead=explode("/",$_REQUEST["storein"]);
$toRead=$toRead[0];
if (file_exists($db_path.$toRead."/dr_path.def")){
	$fp=file($db_path.$toRead."/dr_path.def");
	foreach ($fp as $value){
		$v=explode("=",$value);
		if ($v[0]=="UNICODE"){
			if ($v[1]==0)
				$charset_db="ISO-8859-1";
			else
				$charset_db="UTF-8";
		}
		if ($v[0]=="CISIS_VERSION")  $cisis_ver_db=trim($v[1]);
	}
}

// Determine the characterset to be used. The helper $unicode can be set now too
if ( $charset_to_use=="") $charset_to_use=$charset_db; // charset_db is normally always set now
if ( $charset_to_use=="") $charset_to_use=$meta_encoding; // The last best guess
$unicode="ansi";
if ( $charset_to_use=="UTF-8" ) $unicode="utf8";

// Determine the corresponding executable
// For reading mst files the cisis_version is also required, if different from 16-60
$cisis_path=$cgibin_path.$unicode;
if ($cisis_ver_db!="" and $cisis_ver_db!="16-60") { $cisis_path.="/".$cisis_ver_db."/";}
else { 	$cisis_path.="/";}
$mx_path=$cisis_path.$mx_exec;             // path to mx-executable

if (!isset($arrHttp["from"]))
	$arrHttp["from"]=1;
if (!isset($arrHttp["to"]))
	$arrHttp["to"]=20;
$from=$arrHttp["from"];
$to=$arrHttp["to"];

// $db is the full path of the file (iso/mst) to list
$db=$db_path.$arrHttp["storein"]."/".$arrHttp["copyname"];

// For an .iso display only a header, for a .mst display the control record
// In both cases the list command is prepared
if (pathinfo ( strtolower($arrHttp["copyname"]) , PATHINFO_EXTENSION)=="iso"){
    // command to list an iso file
	$command=$mx_path." iso=$db from=$from to=$to 2>&1";
	echo "<h4>".$msgstr["readiso_mx"]."</h4>";
}else{
    // command to list an mst file.
    // "+control" adds MST control record, identified as MFN=0
	$command=$mx_path." $db +control 2>&1";
    // list and show the control records
    echo "<p><font color=blue> Database control record</font></p>";
	exec($command,$contenido,$res);
	foreach ($contenido as $value) {
        if ($res==0) echo str_replace(" ","&nbsp;",$value)."<br>";
        if ($res!=0) echo "<font color=red>".str_replace(" ","&nbsp;",$value)."<br></font>";
    }
	unset($contenido);
    // command to list the rest of the mst file
	$command=$mx_path." $db from=$from to=$to 2>&1";
}

// Read the content of the iso/mst file
exec($command,$contenido,$res);
echo "<p><font face='courier new' color=blue>Command line: $command<br>";
echo "Characterset: $charset_to_use<br>";
echo "Execution status: $res </font></p>";
/* Display the content line by line
** The output consist of formatted lines. 2 formats
** 1:for each mfn      : "mfn= ,number>"
** 2:for each attribute: "<number> <marker><content><marker>
** - The <content> may consist of several lines
** - The leading and trailing marker are from characterset CP437 (why?)
** - These markers (« ») are not correctly displayed in the browser ( ? in black diamond)
**                       are not correctly displayed in a command window (a very strange character)
**   Integer value of displayed left and right marker in UTF-8 is 194 (reverse engineered)
**   Integer value of displayed left and right marker in ANSI  is 174/175 (reverse engineered)
**   Next marker code will produce more readable output
**   Marker « = dec 171,hex AB/html &#171; or &laquo; / Unicode \u00AB
**   Marker » = dec 187,hex BB/html &#187; or &raquo; / Unicode \u00BB
**   Best solution is transfer them in html (ensures correct display)
*/
foreach ($contenido as $value) {
    if ( $charset_to_use=="UTF-8" ) {
        if ( ord(substr($value,-1))==194) $value=substr($value,0,-1)."&raquo;";
        $spacepos=strpos($value," ".chr(194));
    } else {
        if ( ord(substr($value,-1))==175) $value=substr($value,0,-1)."&raquo;";
        $spacepos=strpos($value," ".chr(174));
    }
    if ( $spacepos!==false) {
        $value=substr_replace($value," &laquo;",$spacepos,2);
    }
    if ($res==0) echo $value."<br>";
    if ($res!=0) echo "<font color=red>".$value."<br></font>";
}
echo "</font>";
echo "<p>";
echo $msgstr["cg_rango"].": ".$msgstr["cg_from"];
$count=$arrHttp["to"]-$arrHttp["from"]+1;
$arrHttp["to"]=$arrHttp["to"]+1;
echo " <input type=text name=from size=5 value=".$arrHttp["to"].">&nbsp; &nbsp;";
echo $msgstr["cg_to"];
$arrHttp["to"]=$arrHttp["to"]+$count-1;
echo " <input type=text name=to size=5 value=".$arrHttp["to"].">&nbsp; &nbsp;";
echo "<input type=submit value=\"".$msgstr["continuar"]."\">";
?>
</form>
</div>
</div>
<?php

include("../common/footer.php");
?>

</body>
</html>
