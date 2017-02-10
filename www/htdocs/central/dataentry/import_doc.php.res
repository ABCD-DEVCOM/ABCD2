
<?php
/**
 * @program:   ABCD - ABCD-Central 
 * @copyright:  Copyright (C) 2014 UO - VLIR/UOS
 * @file:      fmt.php
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
//include("../common/header.php");

$base=$arrHttp["base"];
//include("../common/institutional_info.php");
//echo "<div style='float:right;'><a href='menu_mantenimiento.php?base=$base&encabezado=s' class='defaultButton backButton'><img src='../images/icon/defaultButton_back.png'/><span><strong> back </strong></span></a></div>";
	
//echo "<div style='float:right;'> <a href=\"menu_mantenimiento.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
//echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" /><span><strong> Back </strong></span></a></div>";

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
//echo "<font color=white>&nbsp; &nbsp; Script: import_doc.php</font>";

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





if(isset($fn))
{
$fn=explode("&*",$fn);


for($i=0;$i<count($fn)-1;$i++)
{
 
$mx_path=$cisis_ver."mx";

//$base="marc";
$base=$_POST["base"];
$bd=$db_path.$base;
$nombre=$fn[$i];
//$nombre=str_replace(" ","\\ ",$fn[$i]);
$nombrese=str_replace(" ","_",$nombre);
rename("../../bases/$base"."/collection/".$nombre,"../../bases/$base"."/collection/".$nombrese);
$nombre=$nombrese;
$tika_path=str_replace($cisis_ver,"",$cisis_path);
$cmdconvert= "java -jar ".$tika_path."tika.jar -h "."../../bases/$base"."/collection/".$nombre." > ".$db_path."wrk/".$nombre.".html";
echo $cmdconvert;
exec($cmdconvert,$out,$b);
//echo 'cmdconvert=' . $cmdconvert . '<BR>';
if($b==1)
{
echo "<br><font color='red'>Error occurred converting to HTML $nombre </font>";


}
else
{
//$nombre=str_replace("\\ "," ",$nombre);
rename($db_path."wrk/".$nombre.".html",$db_path."wrk/".$nombrese.".html");
$nombre=$nombrese.".html";

echo "<br><h2>Import process OK</h2>";

}

  /* $fichero_texto = fopen ($db_path."wrk/" . $nombre, "r");
   $Nro = fread($fichero_texto, filesize($db_path."wrk/" . $nombre));
   $IsisScript="$Wxis"." IsisScript=".$db_path."wrk/hi.xis";*/
$bdp=$base;//"base1";

$fp=file($db_path."wrk/".$nombre);
$IsisScript="$Wxis"." IsisScript=".$db_path."wrk/hi.xis";
foreach ($fp as $Nro){
if ($Nro!="") 
{
if (substr($Nro,0,23)=='<meta name="dc:creator"') $creator=trim(substr($Nro,33,-5));
if (substr($Nro,0,22)=='<meta name="dc:format"') $format=trim(substr($Nro,32,-5));
if (substr($Nro,0,23)=='<meta name="dc:subject"') $subject=trim(substr($Nro,33,-5));
if (substr($Nro,0,21)=='<meta name="dc:title"') $title=trim(substr($Nro,31,-5));
if (substr($Nro,0,28)=='<meta name="dcterms:created"') $created=trim(substr($Nro,38,-5));
if (substr($Nro,0,25)=='<meta name="dc:publisher"') $publisher=trim(substr($Nro,35,-5));
if (substr($Nro,0,27)=='<meta name="dc:description"') $description=trim(substr($Nro,37,-5));
}
$strNro.= strip_tags($Nro);
}
$nombre=str_replace(".html","",$nombre);
//$nombre=str_replace("\\ "," ",$nombre);
$tag="99";
$url="98";
$str="<IsisScript name=hi>
<parm name=cipar><pft>'$bdp.*=$db_path"."$bdp/data/$bdp.*',/
'htm.pft=$bdp\data\$bdp.pft'</pft></parm>
<do task=update>
<parm name=db>$bdp</parm>
<parm name=fst><pft>cat('$bdp.fst')</pft></parm>
<parm name=mfn>New</parm>
<field action=define tag=1102>Isis_Status</field>
<update>
<field action=add tag=1>$title</field>
<field action=add tag=2>$creator</field>
<field action=add tag=3>$subject</field>
<field action=add tag=4>$description</field>
<field action=add tag=5>$publisher</field>
<field action=add tag=7>$created</field>
<field action=add tag=9>$format</field>
<field action=add tag=$url>"."bases/$base"."/collection/$nombre</field>
<field action=add tag=$tag>$strNro</field>
<field action=add tag=1001>45</field>
<field action=add tag=1092>0</field>
<field action=add tag=1091>0</field>
<field action=add tag=1002>45</field>
<field action=add tag=3030>all</field>
<field action=add tag=5001>$bdp</field>
<field action=replace tag=100 split=occ><pft>(v100/)</pft></field>
<write>Unlock</write>
<display>
<pft>if val(v1102) = 0 then '<b>Created!</b><hr>' fi </pft>
</display>
</update>
</do>
</IsisScript>";
@ $fp = fopen($db_path."wrk/hi.xis", "w");

@  flock($fp, 2);

  if (!$fp)
  {
    echo "<p><strong> Error ocurred in ISIS Script."
         ."Please try again.</strong></p></body></html>";
    exit;
  }

  fwrite($fp, $str);
  flock($fp, 3);
  fclose($fp);
exec($IsisScript,$salida,$bandera);
}
}
else 
{
include ("phpfileuploader/ajax-multiplefiles.php");

/*
require_once ("phpfileuploader/phpuploader/include_phpuploader.php");

	
	
echo "<form name=\"import\" action=\"\" method=\"post\"><br>
  <input type=\"hidden\" name=\"fn\">
  <input type=\"hidden\" name=\"base\">
  </form>";
	echo "<div class=\"demo\">
        <h2>Select the documents (max. 25 mb for each document)</h2>
        <p> Allowed file types: <span style=\"color:red\">html,htm,pdf,doc,docx,xls</span>).
		<p>";
		
			$uploader=new PhpUploader();
			
			$uploader->MultipleFilesUpload=true;
			$uploader->InsertText="Upload Multiple File";
			
			$uploader->MaxSizeKB=125600;	
			$uploader->AllowedFileExtensions="html,htm,pdf,doc,docx,xls";
			
			//Where'd the files go?
			include("../../config.php");
			$uploader->SaveDirectory=$db_path."/wrk";
			
			include("../common/get_post.php");
  			$base=$arrHttp["base"];
			$uploader->Render();

			
		echo "</p>
	<script type='text/javascript'>

	function CuteWebUI_AjaxUploader_OnTaskComplete(task)
	{

		//var div=document.createElement(\"DIV\");
		//div.innerHTML=task.FileName + \" is uploaded!\";

		//document.body.appendChild(div);
document.import.fn.value=task.FileName;
		document.import.base.value=\"$base\";
		document.import.submit();
//names=names+task.FileName+' ';
		
	}
//document.write(names);
	</script>		
	</div>
</body>
</html>
";*/
}

?>

</div></div>

<?php
//include("../common/footer.php");

?>
</body>
</Html>
