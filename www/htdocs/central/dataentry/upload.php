<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      upload.php
 * @desc:
 * @author:    Guilda Ascencio
 * @since:     20091203
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
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../common/header.php");
?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_import"]." ".$msgstr["cnv_iso"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"carga_iso.php?base=".$arrHttp["base"]."&tipo=".$arrHttp["tipo"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/importiso.html target=_blank>".$msgstr["edhlp"]."</a>";
		echo "<font color=white>&nbsp; &nbsp; Script: dataentry/upload.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";

$path_to_file=$db_path.$arrHttp["path"]."/";
$files = $_FILES['userfile'];
$ext_allowed=array("ISO","TXT","");
$ext_all="";
foreach ($ext_allowed as $val){
	$ext_all.=" &nbsp; ".$val;
}
foreach ($files['name'] as $key=>$name) {	$ext = pathinfo($name, PATHINFO_EXTENSION);
	if(!in_array(strtoupper($ext),$ext_allowed) ) {
		echo "<p><dd><h3>".$name." ".$msgstr["inv_file_ext"]." ".$ext_all."</h3></p></dd>";
    	die;
	}  	$max=get_cfg_var ("upload_max_filesize");
    if ((int)$files['size'][$key]==0){    	$max=get_cfg_var ("upload_max_filesize");
    	echo "upload_max_filesize = $max<br>";    	echo $msgstr["maxfilesiz"];
    	die;    }
	if ($files['size'][$key]) {
      // clean up file name
   		$name = str_replace(" ", "_",
            	str_replace("%20", "_", strtolower($name)
            )
         );
  		$location = $path_to_file.$name;
		$loc=$arrHttp["base"]."/wrk/$name";
		echo $loc;
  		if (!copy($files['tmp_name'][$key],$location)){
		    echo "<p>". $msgstr["archivo"]." ".$loc." ".$msgstr["notransferido"];
		}else{
		  	echo "<p>*** ". $msgstr["archivo"]." ".$loc." ".$msgstr["transferido"];
		  	if (isset($arrHttp["Tag"])){
			  	echo "<script>
					  campo=window.opener.document.forma1.".$arrHttp["Tag"].".value
					  if (Trim(campo)==\"\")
					  	campo+=\"$name\"\n
					  else
					  	campo+='\\r'+\"$name\"\n";
					  if (isset($arrHttp["subc"]) and $arrHttp["descripcion"]!="")
					  	echo "campo+=\"^".$arrHttp["subc"].$arrHttp["descripcion"]."\"\n";
		              echo "
					  window.opener.document.forma1.".$arrHttp["Tag"].".value=campo
					  window.opener.document.forma1.".$arrHttp["Tag"].".rows++
					  self.close()
					  </script>
			  		  ";

			}
  			unlink($files['tmp_name'][$key]);
  		}
   	}
}
echo "</div></div>";
include("../common/footer.php");
?>