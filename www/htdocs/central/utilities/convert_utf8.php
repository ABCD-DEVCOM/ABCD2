<?php
/**
 * @program:   ABCD - ABCD-Central
 * @copyright:  Copyright (C) 2015 UO - VLIR/UOS
 * @file:      convert_utf8.php
 * @desc:      Convert files to utf8
 * @author:    Marino Borrero Sánchez, Cuba. marinoborrero@gmail.com
 * @since:     20162711
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
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../config.php");
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body onunload=win.close()>";
include("../common/institutional_info.php");
$base=$arrHttp["base"];
$bd=$db_path.$base;
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";

	echo "<a href=\"../dbadmin/menu_mantenimiento.php?base=".$base."&encabezado=S\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";

echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
	?>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: utilities/convert_utf8.php";

?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
	<?php
// start file
	$ext=$_GET['ext'];
	if(isset($ext) and count($ext)>0)
	{
    $converted = array();
    $utf8      = array();
    $unknown   = array();
	$base_chk=$_GET['base_chk'];
	$htdocs_chk=$_GET['htdocs_chk'];
	$acces_chk=$_GET['acces_chk'];
	if($_GET['path']=="base")
	{
    $path=$bd.$_GET['selected_base'];
	$iterator  = new RecursiveDirectoryIterator($path);
	}
else if($_GET['path']=="htdocs")
{
	$tmp=explode("cgi-bin",$cisis_path);
	$path_htdocs=$tmp[0]."htdocs/";
	$iterator  = new RecursiveDirectoryIterator($path_htdocs);
}
else
{
$path=$bd."acces/";
	$iterator  = new RecursiveDirectoryIterator($path);
}

    $validExtensions = $ext; // Extensiones de archivo a buscar y convertir
    //echo '<div id="loader" style="display:block" align="center"><img src="../dataentry/img/preloader.gif" width="128" height="128" alt=""/></div>';//
    foreach(new RecursiveIteratorIterator($iterator) as $fileInfo)
    {
        $explode = explode('.', $fileInfo);
        $arrayPop = array_pop($explode);
        $extension = strtolower($arrayPop);
        if (in_array($extension, $validExtensions))
        {
            $file     = $fileInfo->getRealPath();
            $contents = file_get_contents($file);
            $encoding = mb_detect_encoding($contents, "auto", true);

            // Check encoding
            if ($encoding===FALSE)
            {
                // Convert file from undefined encoding to UTF-8
                file_put_contents(
                    $file,
                    mb_convert_encoding(
                        $contents,
                        'UTF-8'
                    )
                );
                $unknown[] = $file;
            }
            else if ($encoding==='UTF-8')
            {
                // Already in UTF-8
                $utf8[] = $file;
            }
            else
            {
                // Convert file from detected encoding to UTF-8
                file_put_contents(
                    $file,
                    mb_convert_encoding(
                        $contents,
                        'UTF-8'
                    )
                );
                $converted[] = $file;
            }
        }
    }
	}
	?>
	    <?php
	if(isset($ext) && count($ext)>0)
	{
	echo "<h3>File comversion statistics:</h3><hr/><br/>";
    echo "Not converted, already in utf-8:\n";
	echo count($utf8)."<br/><br/>";
    for($i=0;$i<count($utf8);$i++)
	{
		if($uft8[$i]!="")
		echo $uft8[$i]."<br/>";
	}
	echo "<hr/>";
    echo "Converted (but not detected original encoding):\n";
    echo count ($unknown)."<br/><br/>";
    for($i=0;$i<count($unknown);$i++)
	{
		if($unknown[$i]!="")
		echo $unknown[$i]."<br/>";
	}
		echo "<hr/>";

    echo "Converted (known enconding):\n";
    echo count($converted)."<br/><br/>";
	for($i=0;$i<count($converted);$i++)
	{
		if($converted[$i]!="")
		echo $converted[$i]."<br/>";
	}
	$style_config= "display:none;";
	echo "<script>document.getElementById('iframe_proc').style='display:none';</script>";
	}
	else
	{
		$style_config= "display:block;";
	}
?>
<iframe id="iframe_proc" src="proc.html" width="128" height="128" marginheight="0" marginwidth="0" noresize scrolling="No" frameborder="0" style="display:none;">
</iframe>
<div id="see_config" style="<?php echo $style_config;?>">
<form id="config" name="config" method="get" action="">
<table>
<tr>
<td>
Convert base <strong><?php echo $base;?></strong> <input type="radio" name="path" checked value="base"> &nbsp;&nbsp;<input type="hidden" id="selected_base" name="selected_base" value="<?php echo $base;?>">
</td>
<td>
Convert base <strong>acces</strong> <input type="radio"  name="path" value="acces">
</td>
<td>
Convert <strong>htdocs folder</strong> <input type="radio"  name="path" value="htdocs">
</td>
</tr>
</table>
<br/><br/>
Extensions<hr/>
<table>
<tr>
<td>html</td><td><input type="checkbox" name="ext[]" value="html" checked></td><td>xml</td><td><input type="checkbox" name="ext[]" value="xml" checked></td>
<td>fst</td><td><input type="checkbox" name="ext[]" value="fst" checked></td><td>pft</td><td><input type="checkbox" name="ext[]" value="pft" checked></td>
<td>def</td><td><input type="checkbox" name="ext[]" value="def" checked></td><td>tab</td><td><input type="checkbox" name="ext[]" value="tab" checked></td>
<td>fdt</td><td><input type="checkbox" name="ext[]" value="fdt" checked></td><td>fmt</td><td><input type="checkbox" name="ext[]" value="fmt" checked></td>
<td>stw</td><td><input type="checkbox" name="ext[]" value="stw" checked></td>
</tr>
</table>
<br/>
<input type="submit" value="Convert" onclick="javascript:show_proc();"/>
</form>
</div>
</div>
</div>
<script>
function check_vars_base()
{

		alert('base');

}
function check_vars_htdocs()
{

		document.getElementById('base_chk').checked=false;


}
function show_proc()
{
	document.getElementById('iframe_proc').style="display:block";
	document.getElementById('see_config').style="display:none";
}
document.getElementById("loader").style.display='none';
</script>
<?php
include("../common/footer.php");
?>
