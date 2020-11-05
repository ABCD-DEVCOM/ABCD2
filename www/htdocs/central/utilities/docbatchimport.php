<?php
/**
 * @program:   ABCD - ABCD-Central-Utility - http://abcd.netcat.be/
 * @copyright:  Copyright (C) 2015 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      docbatchimport.php
 * @desc:      Script to automaticly extract the metadata from the documents and create full text indexed DB
 * @author:    Marcos Mirabal - marcos.clary@gmail.com with additional input from EdS
 * @since:     20141203
 * @version:   2.8.3
 * @updated:   20200920
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
set_time_limit(0);
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../common/header.php");
if (isset($arrHttp["base"])) $base_ant=$arrHttp["base"];
$tikapath=$cgibin_path;
$converter_path=$mx_path;
$OS=strtoupper(PHP_OS);
$maxfilesize=26214400;//25 MB
$filesCounter=0;

$inipath = php_ini_loaded_file();
if ($inipath) {
    $fp=file($inipath);

foreach($fp as $avalue)
{
	$pos = strpos($avalue, "upload_max_filesize");
	if ($pos !== false)
	 {
		$cadmax=explode("=",$avalue);
		$maxfilesize="";
		$var=$cadmax[1];
		for($i=0;$i<strlen($var);$i++)
		  for($j=0;$j<=9;$j++)
			{				
				$local=(string)$j;				
				if ($var[$i]==$local) $maxfilesize.=$var[$i];
			}
	 }	 
}
} 

$maxfilesize=((int)$maxfilesize)*1048576;
//Get the path of the collection folder
$def = parse_ini_file($db_path.$base_ant."/dr_path.def");
//echo "collection-directory=".$db_path.$base_ant."/dr_path.def". "|||". $def['COLLECTION'] ; die;
echo "<body onunload=win.close()>\n";

if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";	
}
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".$msgstr["docbatchimport_mx"].": " . $base_ant."
			</div>
			<div class=\"actions\">";
if (isset($arrHttp["encabezado"])){
echo "<a href=\"menu_extra.php?base=".$base_ant."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
	<script language="javascript">
    
var seconds = 1;
function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById('countdown').innerHTML = "Please wait " + remainingSeconds+" seconds while tika server starts.";
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = '<input type=submit name=submit value="<?php echo $msgstr["update"];?>">';
    } else {
        seconds--;
    }
}
 
var countdownTimer = setInterval('secondPassed()', 1000);

 </script>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_docbatchimport.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_docbatchimport.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: docbatchimport.php</font>";
?>
</div>		
<div class="middle form">
	<div class="formContent">
<form action="" method="post" name="form1" target="_self" id="form1">
<?php
echo "<p>".$msgstr["docbatchimport_tx"]."</p>";  
echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";  
  ?>
<div id="formarea" style="display:block"> 
<?php
echo '<b><label style="color:red">'.$msgstr["warning"].'</label></b></br>'; 
echo $msgstr["docbatchimport_tw"]."</br>";
echo $msgstr["docbatchimport_filesize"]." ".($maxfilesize/1048576)." MB";
 ?>
            <font color=green>
            <HR align=left width="80%">
            FIELDS MAPPING  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Match your fields with your metadata format. Default is (basic) Dublin Core.
            </font>

<table width="80%" border="0">
  <!--tr>
     <td width="10">&nbsp;</td>
    <td colspan="10" style="font-size:14px"><i>Match your fields with your metadata format. Default is (basic) Dublin Core.</i></td-->
	  <tr>
    <td width="10">&nbsp;</td>
    <td width="59" align="left" style="font-size:14px"><label>DC:Title</label></td>
    <td width="60" align="left" style="font-size:14px"><input type="text" name="title" size="2" value="v1"/></td>
    <td width="71" align="left" style="font-size:14px"><label>DC:Creator</label></td>
    <td width="71" align="left" style="font-size:14px"><input type="text" name="creator" size="2" value="v2"/></td>
    <td width="71" align="left" style="font-size:14px"><label>DC:Subject</label></td>
    <td width="72" align="left" style="font-size:14px"><input type="text" name="subject" size="2" value="v3"/></td>
    <td width="79" align="left" style="font-size:14px"><label>DC:Description</label></td>
    <td width="80" align="left" style="font-size:14px"><input type="text" name="description" size="2" value="v4"/></td>
    <td width="70" align="left" style="font-size:14px"><label>DC:Publisher</label></td>
    <td width="71" align="left" style="font-size:14px"><input type="text" name="publisher" size="2" value="v5"/></td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
	  <tr>
	  <td width="10">&nbsp;</td>
	 <td width="59" align="left" style="font-size:14px"><label>DC:Date</label></td>
     <td width="60" align="left" style="font-size:14px"><input type="text" name="date" size="2" value="v7"/></td>
     <td width="71" align="left" style="font-size:14px"><label>DC:Type</label></td>
     <td width="71" align="left" style="font-size:14px"><input type="text" name="type" size="2" value="v8"/></td>
     <td width="71" align="left" style="font-size:14px"><label>DC:Format</label></td>
     <td width="72" align="left" style="font-size:14px"><input type="text" name="format" size="2" value="v9"/></td>
     <td width="79" align="left" style="font-size:14px"><label>DC:Source</label></td>
     <td width="80" align="left" style="font-size:14px"><input type="text" name="source" size="2" value="v11"/></td>
     <td width="70" align="left" style="font-size:14px"><label>DC:URL</label></td>
     <td width="71" align="left" style="font-size:14px"><input type="text" name="url" size="2" value="v98"/></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
            <td align="left" style="font-size:14px"><label>Sections</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="sections" size="2" value="v97"/></td>
	    <td align="left" style="font-size:14px"><label>DocText</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="doctext" size="2" /></td>	    
	    <td align="left" style="font-size:14px"><label>Identifier</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="id" size="2" value="v111"/></td>
	    <td align="left" style="font-size:14px"><label>Date Added</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="dated" size="2" value="v112"/></td>
	    <td align="left" style="font-size:14px"><label>Doc Source</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="docsource" size="2" value="v96"/></td>
	    </tr>
            </table>
            <font color=green>
            <HR align=left width="80%">
            <i>OPTIONS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(to be left empty if not sure, check manual)  </i>
            </font>
     <table width=80%>
       <tr>
	    <td>&nbsp;</td>
            <td align="left" style="font-size:14px" width=10%><label>Tagslevel</label></td>
	    <td align="left" style="font-size:14px" width=10%><input type="text" name="level" size="1" value="0"/></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <td align="left" style="font-size:14px" width=10%><label>Filenames charset to convert</label></td>
	    <td align="left" style="font-size:14px" width=10%><input type="text" name="charsetcv" size="4" value="0"/></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <td align="left" style="font-size:14px" width=10%><label>Granularity</label></td>
	    <td align="left" style="font-size:14px" width=10%><input type="text" name="granularity" size="2" value=" "/></td>
            <td align="left" style="font-size:14px" width=10%><label>Reset filename</label></td>
            <td align="left" style="font-size:14px" width=10%><input type="checkbox" id="resetfilename" name="resetfilename"></td>

<!--            <td align="left" style="font-size:14px" width=10% ><label>Reset filename</label></td>
	    <td align="left" style="font-size:14px" width=10% > <select name="resetfilename" id="resetfilename">
                        <option value="y">yes</option>
                        <option selected value="n">no</option>
                        </select>
-->            </td>
            <td align="left" style="font-size:14px" width=10% ><label>Text format</label></td>
	    <td align="left" style="font-size:14px" width=10% > <select name="textmode" id="textmode">
                        <option value="m">Metadata only</option>
                        <option value="t">Text only</option>
                        <option selected value="h">HTML</option>
                        <option value="x">XHTML</option>
                        </select>
            </td>
       </tr>
	<tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
    </tr>
</table> 
            <HR align=left width="80%">

<table width="750px" border="0">
  <tr>
     <td width="10">&nbsp;</td>
    <td><?php 
//	if (strpos($OS,"WIN")=== false) 
//{
//Linux
//echo '<span id="countdown" class="timer" style="font-size:14px"></span>';
//}
//else 
//echo "<input type=submit name=submit value=".$msgstr["update"].">";

  if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";


if (isset($def["COLLECTION"]))
	{
        $truepathcol=trim($def["COLLECTION"]);
    }
else echo "Collection path not set in dr_path.def !";

if (is_writable($truepathcol))
{
 if (is_writable($truepathcol."ABCDImportRepo"))
 {
     echo '<input type=submit name=submit value="START PROCESS">';
 }
 else   // ImportRepo not writable
 echo '</br></br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:red">Fatal Error</label></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspThe '.$truepathcol.'ABCDImportRepo folder does not exist or has no write-access';
}
else             // truepathcol not writable
 echo '</br></br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:red">Fatal Error</label></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspThe collection folder '.$truepathcol.' does not exist or is write-protected';





 
 ?>
 </td>
 </tr>
</table> 
</div>
</form>
</div>
<?php
if (isset($_POST["submit"]) and $_POST["submit"])
{
$procstartedat=date("Y-m-d H:i:s");
$procstartedatN=date("Ymd H:i:s");
?>
<script languaje=javascript>
document.getElementById("formarea").style.display='none';
</script>
<?php 
//echo '<div id="loader" style="display:block" align="center"><img src="../dataentry/img/preloader.gif" width="128" height="128" alt=""/></div></br></br>';

$totalfilestoimport = 0;
if (!is_dir($truepathcol."ABCDSourceRepo/")) createPath($truepathcol."ABCDSourceRepo/");

function scanDirectories($rootDir, $allData=array()) {
     // set filenames invisible if you want
     $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd");
     // run through content of root directory
     $dirContent = scandir($rootDir);
     foreach($dirContent as $key => $content) {
         // filter all files not accessible
         $path = $rootDir.'/'.$content;
         if(!in_array($content, $invisibleFileNames)) {
             // if content is file & readable, add to array
             if(is_file($path) && is_readable($path)) {
                 // save file name with path
                 $allData[] = $path;
             // if content is a directory and readable, add path and name
             }elseif(is_dir($path) && is_readable($path)) {
                 // recursive callback to open new directory
                 $allData = scanDirectories($path, $allData);
             }
         }
     }
     return $allData;
 }
 
$totalfilestoimport=count(scanDirectories($truepathcol."ABCDImportRepo")); 
echo '<table width="850">
  <tr>
    <td style="font-size:12px" width="70" height="30">&nbsp;</td>
    <td style="font-size:12px" height="30"><!-- Progress bar holder -->
<div id="progress" style="width:800px;border:1px solid #ccc;">&nbsp;</div></td>
  </tr>
  <tr>
    <td style="font-size:12px" width="70" height="30">&nbsp;</td>
    <td style="font-size:12px" height="30"><!-- Progress information -->
<div id="information" style="width">'.$totalfilestoimport.' files to be imported.</div></td>
  </tr>
</table>
<br>';
		  
flush();
$doctotal=0;
$docerror=0;
$total=mt_rand(1, 1000);
//$sep="";
function ProximoNumero($base){
global $db_path,$max_cn_length;
	$archivo=$db_path.$base."/data/control_number.cn";
	if (!file_exists($archivo)){
		$fp=fopen($archivo,"w");
		$res=fwrite($fp,"");
		fclose($fp);
	}
	$perms=fileperms($archivo);
	if (is_writable($archivo)){
	//se protege el archivo con el número secuencial
		chmod($archivo,0555);
	// se lee el último número asignado y se le agrega 1
		$fp=file($archivo);
		$cn=implode("",$fp);
		$cn=$cn+1;
	// se remueve el archivo .bak y se renombre el archivo .cn a .bak
		if (file_exists($db_path.$base."/data/control_number.bak"))
			unlink($db_path.$base."/data/control_number.bak");
		$res=rename($archivo,$db_path.$base."/data/control_number.bak");
		chmod($db_path.$base."/data/control_number.bak",0777);
		$fp=fopen($archivo,"w");
	    fwrite($fp,$cn);
	    fclose($fp);
	    chmod($archivo,0777);
	    if (isset($max_cn_length)) $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
	    return $cn;
	}
}

function showFiles($path) { 

// asignamos a $directorio el objeto dir creado con la ruta 
$directorio = dir($path); 
// recorremos todos los archivos y carpetas
while ($archivo = $directorio -> read()) 
{ 
if($archivo!="." && $archivo!="..") 
{ 
if(is_dir($path.$archivo)) 
{ 
// Mostramos el nombre de la carpeta y los archivo contenidos 
// en la misma 
echo get_infoFile($path,$archivo);
// llamamos nuevamente a la función con la nueva carpeta 
showFiles($path.$archivo."/");
}
else
{
// Mostramos el archivo 
echo get_infoFile($path,$archivo);
} 
} 
} 
$directorio -> close(); 
}


function get_infoFile($path,$archivo)
{ 
global $total,$tikapath,$converter_path,$db_path,$base_ant,$cisis_ver,$Wxis,$doctotal,$img_path,$OS,$procstartedatN,$docerror,$maxfilesize,$truepathcol,$charsetcv,$level,$fieldspart,$filesCounter,$totalfilestoimport;
if(!is_dir($path.$archivo)){
//Get the file info
$originalFileName=$archivo;
$info = pathinfo($path.$archivo);
$ext = ".".$info['extension'];
$sep="__";
$htmlfile="";
$htmlfilesize="0";
$htmlfilesizestr="";
$firstpar="";
$cadena="";
$filesCounter=$filesCounter+1;

//Get the fields tags
$level=intval($_POST["level"])*100;  // define level of tags
$vid=           intval(RemoveV($_POST["id"]))+$level;
$vtitle=        intval(RemoveV($_POST["title"]))+$level;
$vcreator=      intval(RemoveV($_POST["creator"]))+$level;
$vsubject=      intval(RemoveV($_POST["subject"]))+$level;
$vdescription=  intval(RemoveV($_POST["description"]))+$level;
$vpublisher=    intval(RemoveV($_POST["publisher"]))+$level;
$vdate=         intval(RemoveV($_POST["date"]))+$level;
$vtype=         intval(RemoveV($_POST["type"]))+$level;
$vformat=       intval(RemoveV($_POST["format"]))+$level;
$vsource=       intval(RemoveV($_POST["source"]))+$level;
$vsections=     intval(RemoveV($_POST["sections"]))+$level;
$vurl=          intval(RemoveV($_POST["url"]))+$level;
$vdoctext=      intval(RemoveV($_POST["doctext"]))+$level;
$vdated=        intval(RemoveV($_POST["dated"]))+$level;
$vdocsource=RemoveV($_POST["docsource"]);
$vhtmlfilesize=intval("997");   //hardcoded, can be moved to interface to make it defined by user
if (isset($vdocsource)) $vdocsource=intval(RemoveV($_POST["docsource"]))+$level;
$charsetcv = $_POST["charsetcv"];
$granularity = $_POST["granularity"];
$textmode = $_POST["textmode"];
//Set resetfilename to false by default.
$resetfilename = 0; 
//If the POST variable "resetfilename" exists.
if(isset($_POST['resetfilename'])){
    //Checkbox has been ticked.
    $resetfilename = 1;
}

// clean up file name to make it easy to process
///$newdocname= preg_replace("/[^a-z0-9._]/", "",str_replace(" ", "_", str_replace("%20", "_", strtolower($archivo)))); 
///$newdocname=str_replace(".".$ext,"",$newdocname);
if (strval($charsetcv)>0) {
   if ($unicode=0) $tocharset = "windows-8859-1"; else $tocharset = "utf-8//TRANSLIT//IGNORE";
   $fromcharset="windows-".$charsetcv;
   $newdocname=iconv($fromcharset, $tocharset, $archivo) ;        //actual conversion of filename
}     else {$newdocname=$archivo;}
$newdocname=str_replace('\'','_', $newdocname);
$newdocname=str_replace("%20","_", $newdocname);
$newdocname=str_replace($ext,$sep.$total,$newdocname);        // remove extension and add sep and number
$newdocname_Len=strlen($newdocname);

// next line to remove, if selected, trailing numbers in filename, e.g. added by previous runs of this script
if ($resetfilename==0) {
 for ($ii=$newdocname_Len-1; (is_numeric(substr($newdocname,$ii,1)) OR substr($newdocname,$ii,1)=='_');$ii--);
$newdocname=substr($newdocname,0,$ii+1);
}
if (filesize($path.$archivo)<$maxfilesize)
{//If File is less than 25 MB
//build the text to display
//$cadena='&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:blue">Processing</label> <label style="font-style:italic">'.$archivo.'</label> of <label style="font-weight:bold">'.number_format(filesize($path.$archivo)/1024,2,",",".").'Kb</label>. Renaming to <label style="font-weight:bold;color:blue">'.$newdocname.$ext."</label> .Creating record...";ob_flush();flush();
$cadena="&nbsp;&nbsp;&nbsp;&nbsp;#".$filesCounter.'&nbsp;&nbsp;<label style="color:blue">Processing</label> <label style="font-style:italic">';
$cadena.=$archivo.'</label> of <label style="font-weight:bold">'.number_format(filesize($path.$archivo)/1024,2,",",".").'Kb</label>';
//rename the file before proccessing
$temppath=substr($path,strpos($path,'ABCDImportRepo'));
$fixpath=substr($temppath,(strpos($temppath,'/')+1));      //if subfolders in ABCDImportRepo : create them in collection
createPath($truepathcol.$fixpath);
$newdocname=str_replace(" ","",$newdocname);
rename($path.$archivo, $truepathcol.$fixpath.$newdocname.$ext);
$finalfilenamed=$truepathcol.$fixpath.$newdocname.$ext;

$unicodename=0;
if(preg_match('/[^\x20-\x7e]/', $newdocname)) $unicodename=1;
//for($i=0;$i<strlen($newdocname);$i++) {if(ord($newdocname[$i])>127) $unicodename=1;}
//$asciifilename=$truepathcol.$fixpath.iconv('UTF-8', 'ASCII//TRANSLIT',$newdocname).$ext.'"' ;
if ($unicodename==1){
$asciifilename=base64_encode($newdocname).$ext ;
rename($truepathcol.$fixpath.$newdocname.$ext, $truepathcol.$fixpath.$asciifilename);
$finalfilenamed=$truepathcol.$fixpath.$asciifilename;
//$copycmd2="cp ".'"'.$truepathcol.$fixpath.$newdocname.$ext.'" "'.$truepathcol.$fixpath.$asciifilename.'"';
//exec($copycmd2);
}
//Extract the HTML
$htmlfile='"'.$db_path."wrk/".$newdocname.'.html"';
$fixfilename=$finalfilenamed;
//rename($path.$archivo, $truepathcol.$fixpath.$asciifilename);
//$copycmd="cp ".'"'.$path.$archivo.'"'." ".$fixfilename; // this line copies the original PDF to the wrk-directory
//exec($copycmd);

if (strpos($OS,"WIN")=== false)
{
//Linux
//$tikacommand='curl -T '.$truepathcol.$fixpath.$newdocname.$sep.$total.$ext.' http://127.0.0.1:9998/tika --header "Accept: text/html" >'.$db_path."wrk/".$newdocname.$sep.$total.'.html';
//$tikacommand='java -jar '.$tikapath.'tika.jar -h '.$truepathcol.$fixpath.$newdocname.$sep.$total.$ext.' >'.$db_path."wrk/".$newdocname.$sep.$total.'.html';
//$tikacommand='java -jar '.$tikapath.'tika.jar -h '.'"'.$truepathcol.$fixpath.$newdocname.$ext.'"'.' >'.$htmlfile;
$tikacommand='java -jar '.$tikapath.'tika.jar -r -'.$textmode. ' '.$fixfilename.' >'.$htmlfile;
//echo "TIKACMD=$tikacommand<BR>";die;
exec($tikacommand,$outcm,$banderacm);
//unlink($fixfilename);
//$htmlfilesize = strval(filesize($fixfilename));
}
else
{
//Windows
//$tikacommand='java -jar '.$tikapath.'tika.jar -h '.$truepathcol.$fixpath.$newdocname.$sep.$total.$ext.' >'.$htmlfile;
$tikacommand='java -jar '.$tikapath.'tika.jar -r -'.$textmode. ' '.$fixfilename.' >'.$htmlfile;
exec($tikacommand,$outcm,$banderacm);
}

$creator=$format=$subject=$title=$created=$publisher=$description="";
$fp=file($db_path."wrk/".$newdocname.'.html');

foreach ($fp as $value){
if ($value!="") 
{
//Get the metadata
$pos=strpos($value,'"/>')-strlen($value);
if (substr($value,0,23)=='<meta name="dc:creator"') {$creator=trim(substr($value,33,$pos));$firstpar.=$creator."<BR>";}
if (substr($value,0,22)=='<meta name="dc:format"') $format=trim(substr($value,32,$pos));
if (substr($value,0,23)=='<meta name="dc:subject"') $subject=trim(substr($value,33,$pos));
if (substr($value,0,21)=='<meta name="dc:title"') { $title=trim(substr($value,31,$pos));$firstpar.=$title;}
if (substr($value,0,28)=='<meta name="dcterms:created"') $created=trim(substr($value,38,$pos));
if (substr($value,0,25)=='<meta name="dc:publisher"') $publisher=trim(substr($value,35,$pos));
if (substr($value,0,27)=='<meta name="dc:description"') { $description=trim(substr($value,37,$pos));
$title=str_replace('\'','_',$title);   //  echo "title=$title<BR>";die;
$title=str_replace('\"','_',$title);
$description=str_replace('\"',' ',$description);
$description=str_replace('\'',' ',$description);            }
//echo "description=$description<BR>";                     }
//if (substr($value,0,6)!='<meta ') $str.= $value;     // $str is no longer used, lines are written in split_sourcefile function
}
}
//Get the ID
$currentID=ProximoNumero($base_ant);
//Create the fields proc
$fieldspart="\"proc='";
$vspath=$base_ant;

$docsourcepath=$truepathcol."ABCDSourceRepo/$newdocname.html";

if (($currentID!="") and ($vid!="")) $fieldspart.="<$vid>".$currentID."</".$vid.">";
if (($title!="") and ($vtitle!="")) $fieldspart.="<".$vtitle.">".$title."</".$vtitle.">";    // this one not working in v1 ???
if (($creator!="") and ($vcreator!="")) $fieldspart.="<".$vcreator.">".$creator."</".$vcreator.">";
if (($subject!="") and ($vsubject!="")) $fieldspart.="<".$vsubject.">".$subject."</".$vsubject.">";
if (($description!="") and ($vdescription!="")) $fieldspart.="<".$vdescription.">".$description."</".$vdescription.">";
if (($publisher!="") and ($vpublisher!="")) $fieldspart.="<".$vpublisher.">".$publisher."</".$vpublisher.">";
if (($created!="") and ($vdate!="")) $fieldspart.="<".$vdate.">".$created."</".$vdate.">";
if (($ext!="") and ($vtype!="")) $fieldspart.="<".$vtype.">".str_replace(".","",$ext)."</".$vtype.">";
if (($format!="") and ($vformat!="")) $fieldspart.="<".$vformat.">".$format."</".$vformat.">";
if (($archivo!="") and ($vsource!="")) $fieldspart.="<".$vsource.">".$archivo."</".$vsource.">";
if ($vsections!="") $fieldspart.="<".$vsections.">".$fixpath."</".$vsections.">";
if ($vurl!="") $fieldspart.="<".$vurl.">".$fixpath.$newdocname.$ext."</".$vurl.">";
//if ($vurl!="") $fieldspart.="<9978>".$fixpath.iconv('UTF-8', 'ASCII//TRANSLIT',$asciifilename.$ext)."</9978>";
if (($vurl!="") and ($unicodename==1)) $fieldspart.="<998>".$fixpath.$asciifilename."</998>";
$fieldspart.="<112>".$procstartedatN."</112>";
$htmlfile=str_replace('"','',$htmlfile);


           // NEW : split sourcefile by maxsize and granularity
$lastpartno=1;
if ($cisis_ver='bigisis'  OR $cisis_ver='ffi') $maxsize=1000000; else $maxsize=32000;
//=========== NEW EdS
if ($textmode <> 'm') { //only if not metadata-only
echo "Fulltext processing<BR>";
$lastpartno = split_sourcefile($htmlfile,$maxsize,$granularity,$textmode,$firstpar);            // SPLIT_SOURCEFILE
} else {
echo "Metadata only<BR>";
$lastpartno = 1;
}
//===========
$fieldspart1=$fieldspart;                           //fieldspart before adding v96 different docsourcepath values for each part

for ($ipart=1; $ipart<$lastpartno+1; $ipart++) {               // loop over all split sourcefiles
 //if ($ipart=1) $stripart = "" else
 if ($ipart>1) $stripart="_".$ipart.".html"; else $stripart=".html";          // no numbering if not split
 $docsourcepath=$truepathcol."ABCDSourceRepo/$newdocname$stripart";
 if (($vdocsource!="") and ($vurl!="")) $fieldspart=$fieldspart1."<".$vdocsource.">".$docsourcepath."</".$vdocsource.">";
  $htmlfilesize = filesize($docsourcepath);
  $htmlfilesizestr = strval($htmlfilesize);
if ($htmlfilesize>0) $fieldspart.="<$vhtmlfilesize>$htmlfilesizestr</$vhtmlfilesize>";
$fieldspart.="'\"";
//Save the file and import the content into a record if allowed
$gloadproc="";
if (($vdoctext!="") and ($str!=""))           // doctext to be saved inside record
{
$gloadproc="\"proc='Gload/".$vdoctext."=".$db_path."wrk/DocImportFullTxTv99.txt"."'\" /nonl";
//Save the text into a file
@ $fp = fopen($db_path."wrk/DocImportFullTxTv99.txt", "w");
fwrite($fp,$str);
fclose($fp); 
$mx = $converter_path." null ".$gloadproc." ".$fieldspart." append=".$db_path.$base_ant."/data/".$base_ant." count=1 now -all";
exec($mx,$outmx,$banderamx);
}
else  // doctext not to be saved inside record
{
///Save the text into a file
///createPath($truepathcol."ABCDSourceRepo/");
///@ $fp = fopen($docsourcepath, "w");
///fwrite($fp,$str);                                // no longer contents to be written here as it is done in split_sourcefile function
//echo "fp=$fp  str=$str<BR>";die;
//fclose($fp);

$mx = $converter_path." null ".$fieldspart." append=".$db_path.$base_ant."/data/".$base_ant." count=1 now -all";
//echo "mx-command=$mx<BR>";die;
exec($mx,$outmx,$banderamx);
} 
}   // end loop over partnos.
//unlink($fixfilename);
@unlink($db_path."wrk/TikaTemp.txt");
@unlink($db_path."wrk/DocImportFullTxTv99.txt");
@unlink($db_path."wrk/".$newdocname.$sep.$total.'.html');
@unlink($db_path."wrk/".$newdocname.'.html');
$total++;
$doctotal++;
$cadena.=' <label style="font-weight:bold"> with '.$lastpartno.' record(s) created. Done</label></br>'; flush();
}//End of If File is less than 25 MB 
else
{
$cadena='&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:red">NOT Processed</label> <label style="font-style:italic">'.$archivo.'</label> of <label style="font-weight:bold">'.number_format(filesize($path.$archivo)/1024,2,",",".").'Kb</label>. <label style="font-weight:bold;color:red">File size limit exceded</label></br>';flush(); 
$docerror++;
//Move the file to the error folder
$temppath=substr($path,strpos($path,'ABCDImportRepo'));
$fixpath=substr($temppath,(strpos($temppath,'/')+1));
createPath($truepathcol."ImportError/");
createPath($truepathcol."ImportError/".$fixpath);
rename($path.$archivo, $truepathcol."ImportError/".$fixpath.$newdocname.$sep.$total.$ext);
}

//Update the loading gift
$percent = intval($filesCounter/$totalfilestoimport * 100)."%";
 echo '<script language="javascript">
  document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#364c6c;\"><div style=\"color:#fff;\" align=\"center\">'.$percent.'</div></div>";
  document.getElementById("information").innerHTML="'.$filesCounter.' file(s) processed of '.$totalfilestoimport.' files";
  </script>';
return $cadena;	
}
}

function RemoveV($field)
{
$field=trim($field);
if (isset($field[0])) {
 if (($field[0]=='v') or ($field[0]=='V')) return str_replace( 'v','',strtolower($field));
 return $field;
 }
}
function time_diff($s) { 
    $m = 0; $hr = 0; $d = 0; $td = "now";
    if ($s > 59) { 
        $m = (int)($s/60); 
        $s = $s-($m*60); // sec left over 
        $td = "$m minute";
		if ($m > 1) $td .= "s";
		$td.=" $s second";
		if ($s > 1) $td .= "s";				
    } 
    if ($m > 59) { 
        $hr = (int)($m / 60); 
        $m = $m - ($hr*60); // min left over 
        $td = "$hr hour"; 
        if ($hr > 1) $td .= "s";
        if ($m > 0) $td .= ", $m minute";
		if ($m > 1) $td .= "s";
		$td.=" $s second";
		if ($s > 1) $td .= "s";
    } 
    if ($hr > 23) { 
        $d = (int) ($hr / 24); 
        $hr = $hr-($d*24); // hr left over 
        $td = "$d day"; 
        if ($d > 1) $td .= "s";
        if ($hr > 0) $td .= ", $hr hour";
        if ($hr > 1) $td .= "s";
		if ($m > 0) $td .= ", $m minute";
		if ($m > 1) $td .= "s";
		$td.=" $s second";
		if ($s > 1) $td .= "s";
        
    } 
    return $td; 
} 
//Comprobamos si la carpeta de la coleccion existe
//if ((is_dir($truepathcol)) &&
if (is_writable(substr($truepathcol,0,-1)))
{
//Comprobamos si la carpeta de la ABCDImportRepo existe
if ((is_dir($truepathcol."ABCDImportRepo/")) && (is_writable($truepathcol."ABCDImportRepo")))
{
	
//----------------------------------------------------------------------------------------------------
//Llamamos a la funcion de procesar la coleccion
showFiles($truepathcol."ABCDImportRepo/");
//Realizamos el fullinvert de la base de datos         // NO MAS
//$mxinv="";
//if (isset($vdoctext) AND ($vdoctext!=""))
//$mxinv=$converter_path." cipar=".$db_path."par/".$base_ant.".par ".$db_path.$base_ant."/data/".$base_ant." fst=@".$db_path.$base_ant."/data/".$base_ant.".fst uctab=uctab.tab actab=actab.tab fullinv/m=".$db_path.$base_ant."/data/".$base_ant." now -all";
//else
//$mxinv=$converter_path." cipar=".$db_path."par/".$base_ant.".par ".$db_path.$base_ant."/data/".$base_ant." fst=@".$db_path.$base_ant."/data/fulltext.fst uctab=uctab.tab actab=actab.tab fullinv/m=".$db_path.$base_ant."/data/".$base_ant." now -all";

//exec($mxinv, $outputmxinv,$banderamxinv);
$procendedat=date("Y-m-d H:i:s");
$t1=strtotime ($procstartedat);
$t2=strtotime ($procendedat);
$differ = $t2 - $t1;
if ($differ>60)
{
$endtime=time_diff($differ);
}
else 
{
$endtime=$differ;
$endtime.=" seconds";
}
echo '</br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:blue">Final Remarks</label></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The process started at '.$procstartedat.'.</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The process ended at &nbsp;'.$procendedat.'.</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The process took '.$endtime.'.</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-weight:bold;color:blue">'.$doctotal.' documents were processed.</label></br>';
if ($docerror>0) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:red">'.$docerror.' documents were not processed.</label>';
echo "</br></br>";
eliminarDir($truepathcol."ABCDImportRepo");
if (is_dir($truepathcol."ImportError"))
{
//Move the ImportError to ABCDImportRepo	
rmdir($truepathcol."ABCDImportRepo");
rename($truepathcol."ImportError",$truepathcol."ABCDImportRepo");
}
echo '<BR></BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:blue">To continue with full index generation of the database, <A HREF="vmx_fullinv.php?base='.$base_ant.'"> click here   </a> </label></br>';//die;

//----------------------------------------------------------------------------------------------------

}//if (is_dir($img_path.$base_ant."/collection/ABCDImportRepo/"))
else
{
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:red">Fatal Error</label></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspThe ABCDImportRepo folder does not exist or has no write-access';
}//end else if (is_dir($img_path.$base_ant."/collection/ABCDImportRepo/"))
}//end if (is_dir($img_path.$base_ant."/collection/"))
else
{
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<label style="font-weight:bold;color:red">Fatal Error</label></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspThe collection folder does not exist or is write-protected';
}//end else if (is_dir($img_path.$base_ant."/collection/ABCDImportRepo/"))

}//if ($_POST["submit"])
function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

function eliminarDir($carpeta)
{
foreach(glob($carpeta . "/*") as $archivos_carpeta)
{ 
if (is_dir($archivos_carpeta))
{
eliminarDir($archivos_carpeta);
}
else
{
unlink($archivos_carpeta);
}
}
$temppath=substr($carpeta,strpos($carpeta,'ABCDImportRepo'));
if ($temppath!="ABCDImportRepo") rmdir($carpeta);
}
//===================================================================== new EdS
function split_sourcefile1($sourcefilename,$maxsize,$granularity,$textmode) {    // function with array $lines
//=====================================================================
global $truepathcol;
 $linelen=0;
 $continue=0;
 $partheader="<H3><FONT COLOR=GREEN> PART ";
 $firstpar="";
 $cisis_maxrecsize=$maxsize;
 $infile=$sourcefilename;
 $filesize=filesize($infile);
if (!isset($granularity)) $granularity=ceil($filesize/$cisis_maxrecsize);
if ($granularity==0) $granularity=1;
$outname1=basename($infile,'.html');
$partno=1;

if ($partno>1) $outname=$outname1."_".$partno; else $outname=$outname1;
if ($granularity>1) {$maxsize=$filesize/$granularity; if ($maxsize>$cisis_maxrecsize) $maxsize=($cisis_maxrecsize*0.5);}
else $maxsize=$cisis_maxrecsize*0.5;
$bodystart=0;
$totalsize=0;
    $lines=file($infile);                              // array $lines contains all lines of text-file
    while  (strpos($lines[$bodystart],'body>',0)==FALSE AND $bodystart<100) $bodystart=$bodystart+1;
    if ($bodystart==100) $bodystart=0;
      for ($i=1; $i<22;$i++) $firstpar.= $lines[$bodystart+$i]; //snippet of document begin to show at subsequent parts preview
      $firstpar.="<font color=green>= = = = = = = CONTINUATION FROM PREVIOUS PART = = = = = = =</font>";
      $lastline=count($lines);
       for ($iline=0; $iline<=$lastline-1; $iline++) { // main loop for all lines in the file
          $line=$lines[$iline];                      // put the current line in $line
          $linelen=strlen($line);
          $totalsize=$totalsize+$linelen;
          if ($totalsize<$maxsize OR $continue=1)  {            // output less than max
            $writeFile=file_put_contents($truepathcol."ABCDSourceRepo/".$outname.'.html', $lines[$iline], FILE_APPEND);
           if ($totalsize>$maxsize) {
           if ($textmode=='t') $endofline='/p'; else $endofline=substr($line, $linelen-4,2);
            if ($endofline == '/p' OR $endofline == 'p/')
            {     // at end of paragraph change outputfilename and append to it
             $continue=0;           //
             $partno=$partno+1;
             $totalsize=0;
             if ($partno>1) $outname=$outname1.'_'.strval($partno); else $outname=$outname1;
             $partsheader="<table><tr><td width=88%>$firstpar</td><td width=12% valign=top><font size=3 color=red $partheader $partno </font></td></tr></table>";
             $writeFile=file_put_contents($truepathcol."ABCDSourceRepo/".$outname.'.html',$partsheader, FILE_APPEND);
            }   else $continue = 1;
           }
          }
       }
return $partno;
}

function split_sourcefile($sourcefilename,$maxsize,$granularity,$textmode,$firstpar) {   //function without $lines array
//=====================================================================
global $truepathcol;
 $linelen=0;
 $continue=0;
 $partheader="<H3><FONT COLOR=GREEN> # ";
 $cisis_maxrecsize=$maxsize;
 $infile=$sourcefilename;
 $filesize=filesize($infile);
if (!isset($granularity)) $granularity=ceil($filesize/$cisis_maxrecsize);
if ($granularity==0) $granularity=1;
$outname1=basename($infile,'.html');
$partno=1;
$firstparLineCounter=0;
$OS=strtoupper(PHP_OS);
if (strpos($OS,"WIN")=== false)
$endofLineMarker='\n';
else
$endofLineMarker='\r\n';
if ($partno>1) $outname=$outname1."_".$partno; else $outname=$outname1;
if ($granularity>1) {$maxsize=$filesize/$granularity; if ($maxsize>$cisis_maxrecsize) $maxsize=($cisis_maxrecsize*0.5);}
else $maxsize=$cisis_maxrecsize*0.5;
//echo "maxsize=$maxsize<BR>";
if ($filesize>$maxsize) {
// if multi-part start with indicating 'PART 1'
  $partsheader="<table  width=100% border=1><tr><td width=88%>$firstpar</td><td width=12% valign=top bgcolor=antiquewhite><font size=3 color=green $partheader $partno </font></td></tr></table>";
  $writeFile=file_put_contents($truepathcol."ABCDSourceRepo/".$outname.'.html',"\n".$partsheader."\n", FILE_APPEND);
 }
$bodystart=0;
$totalsize=0;
$linecounter1=0;
$linecounter=0;
$firstparAdd=0;
$firstparr="";
//$file = @fopen($infile, "r") ;
if(($file = fopen($infile, "r"))) {      // only if successfully opened the file for reading
while (!feof($file))                   // main loop over all lines of the source file
{
    $thisLine = fgets($file); //line contents
    if (strlen($thisLine)>3) {
        $linecounter = $linecounter+1;
     if (strlen($firstpar)<6) {       //if no metadata, construct firstpar from first x lines of <body>
      if (strpos($thisLine,'<body>')===0) {$firstparLineCounter=1;} else {
      $firstparAdd=1; $firstparLineCounter++;}  //start adding lines in $firstpar
       if ($firstparAdd==1 AND $firstparLineCounter<11) {
          if (strlen(rtrim($thisLine))>3) {         // $firstparLineCounter++;
          $firstparr .= $thisLine;//echo "FIRSTPARR=$firstparr<BR>";
          }
       }
       else $firstparAdd='0';
     } else $firstparr = $firstpar;
          $thisLine = str_replace('><','> <',$thisLine);               //> is not in actab so we add space to split the word
          $linelen=strlen($thisLine);
          $totalsize=$totalsize+$linelen;
          if ($totalsize<$maxsize OR $continue=1)  {            // output less than max
            $writeFile=file_put_contents($truepathcol."ABCDSourceRepo/".$outname.'.html', $thisLine, FILE_APPEND);
           if ($totalsize>$maxsize) {
           $linecounter1=$linecounter1+1;
           if ($textmode=='t') $endofline='/div>'; else $endofline=substr($thisLine, $linelen-6,5);
            if ($endofline == '/div>'  OR $linecounter == $linecounter1+99)    // force split after 99 extra lines
            {     // at end of paragraph change outputfilename and append to it
             $continue=0;           //
             $partno=$partno+1;
             $totalsize=0;
             if ($partno>1) $outname=$outname1.'_'.strval($partno); else $outname=$outname1;
             $partsheader="<table width=100% border=2><tr><td width=88%>$firstparr</td><td width=12% valign=top><font size=3 color=green $partheader $partno </font></td></tr></table>";
             $writeFile=file_put_contents($truepathcol."ABCDSourceRepo/".$outname.'.html',"\n".$partsheader."\n", FILE_APPEND);
            }   else $continue = 1;
           }
          }

    }  // if line not empty
}
       fclose($file) ;
}  // end if if file successfully opened

return $partno;
}




?>




<script languaje=javascript>
document.getElementById("loader").style.display='none';
</script>
</br>
</div>
<?php
include("../common/footer.php");
?>
