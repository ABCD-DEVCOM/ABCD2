<?php
/**
 * @program:   ABCD - ABCD-Central-Utility - http://abcd.netcat.be/
 * @copyright:  Copyright (C) 2015 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      docbatchimport.php
 * @desc:      Script to automaticly extract the metadata from the documents and create full text indexed DB
 * @author:    Marcos Mirabal - marcos.clary@gmail.com
 * @since:     20141203
 * @version:   2.8.1
 * @updated:   20170323
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
$base_ant=$arrHttp["base"];
//Adjusting Tika path
$tikapath=$cgibin_path;
//if ($cisis_ver!="")  $tikapath=str_replace($cisis_ver,'',$cisis_path);
//Setting the path to mx
$converter_path=$cisis_path."mx";

$OS=strtoupper(PHP_OS);
//if (strpos($OS,"WIN")=== false) 
//{
//$tikacommands='java -jar '.$tikapath.'tika-server.jar --host=127.0.0.1 --port=9998 > '.$db_path."wrk/TikaTemp.txt".' &';
//exec($tikacommands,$outcms,$banderacms);
//}
$maxfilezise=26214400;//25 MB

$inipath = php_ini_loaded_file();
$fp=file($inipath);

foreach($fp as $avalue)
{
	$pos = strpos($avalue, "upload_max_filesize");
	if ($pos !== false)
	 {
		$cadmax=explode("=",$avalue);
		$maxfilezise="";
		$var=$cadmax[1];
		for($i=0;$i<strlen($var);$i++)
		  for($j=0;$j<=9;$j++)
			{				
				$local=(string)$j;				
				if ($var[$i]==$local) $maxfilezise.=$var[$i];						
			}
	 }	 
}
$maxfilezise=((int)$maxfilezise)*1048576;
//Get the path of the collection folder
$def = parse_ini_file($db_path.$base_ant."/dr_path.def");
	if (isset($def["COLLECTION"])){
        $truepathcol=trim($def["COLLECTION"]);
        }
        else echo "Collection path not set in dr_path.def !";
//$fp=file($db_path.$base_ant."/dr_path.def");
//foreach($fp as $avalue)
//{
//	$pos = strpos($avalue, "COLLECTION");
//	if ($pos !== false)
//	 {
//		$cadmax=explode("=",$avalue);
//                $cmlen=strlen($cadmax);
//echo "CADMAX=$cadmax[1] with size of $cmlen <BR>";
//	if (!feof()) {$truepathcol=$cadmax[1]}
//$truepathcol=$cadmax[1] ;
//        else
//        $truepathcol=substr($cadmax,0,strlen($cadmax)-1);
//	 }	 
//}
//Fixing the last line problem
//$truepathcol=substr($truepathcol,0,(strrpos($truepathcol,'/')+1));
//echo "DR_PATHDEF=" .$db_path.$base_ant."/dr_path.def<BR>";
//echo "TRUEPATHCOL=$truepathcol<BR>";

echo "<body onunload=win.close()>\n";

if (is_writable($truepathcol))
{
 if (is_writable($truepathcol."ABCDImportRepo"))
 {
 echo $truepathcol . "ABCDImportRepo is writable<BR>";
 }
 else   // ImportRepo not writable
 echo "$truepathcol is writable but not ABCDImportRepo<BR>";
}
else             // truepathcol not writable
 echo "The collection folder $truepathcol does not exist or is write-protected";


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
echo '<b><label style="color:red">'.$msgstr["warning"].'</label></b></br>'; 
echo $msgstr["docbatchimport_tw"]."</br>";
echo $msgstr["docbatchimport_filezise"]." ".($maxfilezise/1048576)." MB";
echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";  
echo '</br></br></br>';
  ?>
<div id="formarea" style="display:block"> 
<table width="750px" border="0">
  <tr>
     <td width="10">&nbsp;</td>
    <td colspan="10" style="font-size:14px">Match your fields with the (Dublin Core) metadata format.</td>
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
echo "<input type=submit name=submit value=".$msgstr["update"].">"; 
  if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
 ?></td>
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
echo '<div id="loader" style="display:block" align="center"><img src="../dataentry/img/preloader.gif" width="128" height="128" alt=""/></div></br></br>';
ob_flush();flush();
$doctotal=0;
$docerror=0;
$total=mt_rand(1, 1000);

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
global $total,$tikapath,$converter_path,$db_path,$base_ant,$cisis_ver,$Wxis,$doctotal,$img_path,$OS,$procstartedatN,$docerror,$maxfilezise,$truepathcol;
if(!is_dir($path.$archivo)){ 
//Get the file info
$originalFileName=$archivo;
$info = pathinfo($path.$archivo);
$ext = $info['extension'];
// clean up file name to make it easy to process
$newdocname= preg_replace("/[^a-z0-9._]/", "",str_replace(" ", "_", str_replace("%20", "_", strtolower($archivo)))); 
$newdocname=str_replace(".".$ext,"",$newdocname);
if (filesize($path.$archivo)<$maxfilezise)
{//If File is less than 25 MB
//build the text to display
$cadena='&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:blue">Processing</label> <label style="font-style:italic">'.$archivo.'</label> of <label style="font-weight:bold">'.number_format(filesize($path.$archivo)/1024,2,",",".").'Kb</label>. Renaming to <label style="font-weight:bold;color:blue">'.$newdocname.$total.".".$ext."</label> .Creating records...";ob_flush();flush(); 
//rename the file before proccessing
$temppath=substr($path,strpos($path,'ABCDImportRepo'));
$fixpath=substr($temppath,(strpos($temppath,'/')+1));
createPath($truepathcol.$fixpath);
rename($path.$archivo, $truepathcol.$fixpath.$newdocname.$total.".".$ext);
//Get the fields tags
$vid=RemoveV($_POST["id"]);
$vtitle=RemoveV($_POST["title"]);
$vcreator=RemoveV($_POST["creator"]);
$vsubject=RemoveV($_POST["subject"]);
$vdescription=RemoveV($_POST["description"]);
$vpublisher=RemoveV($_POST["publisher"]);
$vdate=RemoveV($_POST["date"]);
$vtype=RemoveV($_POST["type"]);
$vformat=RemoveV($_POST["format"]);
$vsource=RemoveV($_POST["source"]);
$vsections=RemoveV($_POST["sections"]);
$vurl=RemoveV($_POST["url"]);
$vdoctext=RemoveV($_POST["doctext"]);
$vdated=RemoveV($_POST["dated"]);
$vdocsource=RemoveV($_POST["docsource"]);
//Extract the HTML
if (strpos($OS,"WIN")=== false)
{
//Linux
//$tikacommand='curl -T '.$truepathcol.$fixpath.$newdocname.$total.".".$ext.' http://127.0.0.1:9998/tika --header "Accept: text/html" >'.$db_path."wrk/".$newdocname.$total.'.html';
$tikacommand='java -jar '.$tikapath.'tika.jar -h '.$truepathcol.$fixpath.$newdocname.$total.".".$ext.' >'.$db_path."wrk/".$newdocname.$total.'.html';
//echo "TIKACMD=$tikacommand<BR>";
exec($tikacommand,$outcm,$banderacm);
}
else
{
//Windows
$tikacommand='java -jar '.$tikapath.'tika.jar -h '.$truepathcol.$fixpath.$newdocname.$total.".".$ext.' >'.$db_path."wrk/".$newdocname.$total.'.html';
exec($tikacommand,$outcm,$banderacm);
}
$creator=$fotmat=$subject=$title=$created=$publisher=$description=$str="";
$fp=file($db_path."wrk/".$newdocname.$total.'.html');
foreach ($fp as $value){
if ($value!="") 
{
//Get the metadata
$pos=strpos($value,'"/>')-strlen($value);
if (substr($value,0,23)=='<meta name="dc:creator"') $creator=trim(substr($value,33,$pos));
if (substr($value,0,22)=='<meta name="dc:format"') $format=trim(substr($value,32,$pos));
if (substr($value,0,23)=='<meta name="dc:subject"') $subject=trim(substr($value,33,$pos));
if (substr($value,0,21)=='<meta name="dc:title"') $title=trim(substr($value,31,$pos));
if (substr($value,0,28)=='<meta name="dcterms:created"') $created=trim(substr($value,38,$pos));
if (substr($value,0,25)=='<meta name="dc:publisher"') $publisher=trim(substr($value,35,$pos));
if (substr($value,0,27)=='<meta name="dc:description"') $description=trim(substr($value,37,$pos));
if (substr($value,0,6)!='<meta ') $str.= $value;
}
}
//Get the ID
$currentID=ProximoNumero($base_ant);
//Create the fields proc
$fieldspart="\"proc='";
$vspath=$base_ant;
$docsourcepath=$truepathcol."ABCDSourceRepo/".$newdocname.$total.".html";
if (($fixpath!="") and ($fixpath!="ABCDImportRepo/")) $vspath=substr($fixpath,0,-1);
if (($currentID!="") and ($vid!="")) $fieldspart.="<".$vid.">".$currentID."</".$vid.">";
if (($title!="") and ($vtitle!="")) $fieldspart.="<".$vtitle.">".$title."</".$vtitle.">";
if (($creator!="") and ($vcreator!="")) $fieldspart.="<".$vcreator.">".$creator."</".$vcreator.">";
if (($subject!="") and ($vsubject!="")) $fieldspart.="<".$vsubject.">".$subject."</".$vsubject.">";
if (($description!="") and ($vdescription!="")) $fieldspart.="<".$vdescription.">".$description."</".$vdescription.">";
if (($publisher!="") and ($vpublisher!="")) $fieldspart.="<".$vpublisher.">".$publisher."</".$vpublisher.">";
if (($created!="") and ($vdate!="")) $fieldspart.="<".$vdate.">".$created."</".$vdate.">";
if (($ext!="") and ($vtype!="")) $fieldspart.="<".$vtype.">".$ext."</".$vtype.">";
if (($format!="") and ($vformat!="")) $fieldspart.="<".$vformat.">".$format."</".$vformat.">";
if (($archivo!="") and ($vsource!="")) $fieldspart.="<".$vsource.">".$archivo."</".$vsource.">";
if ($vsections!="") $fieldspart.="<".$vsections.">".$vspath."</".$vsections.">"; 
if (($fixpath.$newdocname.$total.".".$ext!="") and ($vurl!="")) $fieldspart.="<".$vurl.">".$fixpath.$newdocname.$total.".".$ext."</".$vurl.">"; 
$fieldspart.="<112>".$procstartedatN."</112>";
if (($vdocsource!="") and ($vurl!="")) $fieldspart.="<".$vdocsource.">".$docsourcepath."</".$vdocsource.">"; 
$fieldspart.="'\"";


//Save the file and import the content into a record if allow
$gloadproc="";
if (($vdoctext!="") and ($str!=""))
{
$gloadproc="\"proc='Gload/".$vdoctext."=".$db_path."wrk/DocImportFullTxTv99.txt"."'\"";
//Save the text into a file
@ $fp = fopen($db_path."wrk/DocImportFullTxTv99.txt", "w");
fwrite($fp,$str);
fclose($fp); 
$mx = $converter_path." null ".$gloadproc." ".$fieldspart." append=".$db_path.$base_ant."/data/".$base_ant." count=1 now -all";
exec($mx,$outmx,$banderamx);
}
else
{
//Save the text into a file
createPath($truepathcol."ABCDSourceRepo/");
@ $fp = fopen($docsourcepath, "w");
fwrite($fp,$str);
fclose($fp); 
$mx = $converter_path." null ".$fieldspart." append=".$db_path.$base_ant."/data/".$base_ant." count=1 now -all";
exec($mx,$outmx,$banderamx);
} 

@unlink($db_path."wrk/TikaTemp.txt");
@unlink($db_path."wrk/DocImportFullTxTv99.txt");
@unlink($db_path."wrk/".$newdocname.$total.'.html');
$total++;
$doctotal++;
$cadena.=' <label style="font-weight:bold">Done</label></br>'; ob_flush();flush(); 
}//End of If File is less than 25 MB 
else
{
$cadena='&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:red">NOT Processed</label> <label style="font-style:italic">'.$archivo.'</label> of <label style="font-weight:bold">'.number_format(filesize($path.$archivo)/1024,2,",",".").'Kb</label>. <label style="font-weight:bold;color:red">File size limit exceded</label></br>';ob_flush();flush(); 
$docerror++;
//Move the file to the error folder
$temppath=substr($path,strpos($path,'ABCDImportRepo'));
$fixpath=substr($temppath,(strpos($temppath,'/')+1));
createPath($truepathcol."ImportError/");
createPath($truepathcol."ImportError/".$fixpath);
rename($path.$archivo, $truepathcol."ImportError/".$fixpath.$newdocname.$total.".".$ext);
}

}

return $cadena;	
}
function RemoveV($field)
{
$field=trim($field);
if (($field[0]=='v') or ($field[0]=='V')) return str_replace( 'v','',strtolower($field));
return $field;
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
//Realizamos el fullinvert de la base de datos
$mxinv="";
if ($vdoctext!="") $mxinv=$converter_path." cipar=".$db_path."par/".$base_ant.".par ".$db_path.$base_ant."/data/".$base_ant." fst=@".$db_path.$base_ant."/data/".$base_ant.".fst uctab=uctab.tab actab=actab.tab fullinv/m=".$db_path.$base_ant."/data/".$base_ant." now -all";
else
$mxinv=$converter_path." cipar=".$db_path."par/".$base_ant.".par ".$db_path.$base_ant."/data/".$base_ant." fst=@".$db_path.$base_ant."/data/fulltext.fst uctab=uctab.tab actab=actab.tab fullinv/m=".$db_path.$base_ant."/data/".$base_ant." now -all";

exec($mxinv, $outputmxinv,$banderamxinv);
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
?>
<script languaje=javascript>
document.getElementById("loader").style.display='none';
</script>
</br>
</div>
<?php
include("../common/footer.php");
?>
