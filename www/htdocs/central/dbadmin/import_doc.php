<?php
/**
 * @program:   ABCD - ABCD-Central 
 * @copyright:  Copyright (C) 2014 UO - VLIR/UOS
 * @file:      import_doc.php
 * @desc:      Import full text docs to a record
 * @author:    Marino Borrero Sánchez, Cuba
 * @since:     20141207
 * @version:   1.0
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
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
$base=$arrHttp["base"];
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Import DOC: " . $base."
			</div>
			<div class=\"actions\">";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";

?>
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_import_doc.html target=_blank>".$msgstr["edhlp"]."</a>";
if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
	$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
	if (isset($def["ROOT"])){
		$dr_path=trim($def["ROOT"]);
		$ix=strrpos($dr_path,"/");
        $dr_path_rel=substr($dr_path,0,$ix-1);
        $ix=strrpos($dr_path_rel,"/");
        $dr_path_rel="<i>[dr_path.def]</i>".substr($dr_path,$ix);
	}else{
		$dr_path=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"]."/";
		$dr_path_rel="<i>[DOCUMENT_ROOT]</i>/bases/".$arrHttp["base"]."/";
	}
}
include("../common/header.php");
?>
<body>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/import_doc.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/import_doc.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: import_doc_mnu.php" ?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<?php
$OS=strtoupper(PHP_OS);
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");
$fn=$_POST["fn"];
$count=0;
if(isset($fn))
{
$fn=explode("&*",$fn);
for($i=0;$i<count($fn)-1;$i++)
{
$mx_path=$cisis_ver."mx";
$base=$_POST["base"];
$bd=$db_path.$base;
$nombre=$fn[$i];
$dirc=$_POST['cd'];
$nombrese=str_replace(" ","_",$nombre);
rename($dirc.$nombre,$dirc.$nombrese);
$nombre=$nombrese;
$tika_path=str_replace($cisis_ver,"",$cisis_path);
$cmdconvert= "java -jar ".$tika_path."tika.jar -h ".$dirc."/".$nombre." > ".$img_path.$base."/collection/ABCDSourceRepo/".$nombre.".html";
exec($cmdconvert,$out,$b);
if($b==1)
{
echo "<br><font color='red'>Error occurred converting to HTML $nombre </font>";
}
else
{
$bdp=$_POST['base'];
rename($img_path.$base."/collection/ABCDSourceRepo/".$nombre.".html",$img_path.$base."/collection/ABCDSourceRepo/".$nombrese.".html");
$nombre=$nombrese.".html";
$fp=file($img_path.$base."/collection/ABCDSourceRepo/".$nombre);
$IsisScript="$Wxis"." IsisScript=".$db_path."wrk/hi.xis";
$strNro="";
foreach ($fp as $Nro){
if ($Nro!="") 
{
$pos=strpos($Nro,'"/>')-strlen($Nro);
if (substr($Nro,0,23)=='<meta name="dc:creator"') $creator=trim(substr($Nro,33,$pos));
if (substr($Nro,0,22)=='<meta name="dc:format"') $format=trim(substr($Nro,32,$pos));
if (substr($Nro,0,23)=='<meta name="dc:subject"') $subject=trim(substr($Nro,33,$pos));
if (substr($Nro,0,21)=='<meta name="dc:title"') $title=trim(substr($Nro,31,$pos));
if (substr($Nro,0,28)=='<meta name="dcterms:created"') $created=trim(substr($Nro,38,$pos));
if (substr($Nro,0,25)=='<meta name="dc:publisher"') $publisher=trim(substr($Nro,35,$pos));
if (substr($Nro,0,27)=='<meta name="dc:description"') $description=trim(substr($Nro,37,$pos));
}
$strNro.= strip_tags($Nro);
}
@ $fp = fopen($db_path."wrk/txt99.txt", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/txt99.txt";         
   exit;
 }
fwrite($fp,$strNro);
fclose($fp);
$nombre=str_replace(".html","",$nombre);
$mxcmd= $cisis_path."mx null  \"proc='<1>".$title."</1><2>".$creator."</2><3>".$subject."</3><4>".$description."</4><5>".$publisher."</5><6>".$created."</6><"."7".">".$ext."</7><8>".$format."</8><97>".$img_path.$base."/collection/".$nombre."</97><98>".$nombre."</98>'\" \"proc='Gload/99=".$db_path."wrk/txt99.txt"."'\" append=".$db_path.$bdp."/data/".$bdp." count=1 now -all";
exec($mxcmd,$out,$b);
if($b ==0)
{
echo "<br>Import process OK for $nombre<br>";
$count++;
rename($dirc."/".$nombre,$img_path.$base."/collection/".$nombre);
}
else
{
echo "<br><font color='red'>Error creating ISIS record $nombre</font><br>";
}
}
}
echo "<br><font color='green'>$count Registries created!</font><br>";
$mxindex=$cisis_path."mx ".$db_path.$bdp."/data/".$bdp." fst=@ ifupd=$db_path$bdp/data/$bdp";
exec($mxindex,$salida,$b);
if($b==0)
echo "<br> Index created OK<br>";
}  
else 
{
include("upload_myfile.php");
}
?>
</div></div>
</body>
</Html>
