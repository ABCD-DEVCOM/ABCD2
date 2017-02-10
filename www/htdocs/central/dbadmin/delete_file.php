<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      delete_file.php
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

include("../lang/dbadmin.php");

include("../lang/soporte.php");
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
$archivo="";
if (isset($arrHttp["fmt"])) {
	$archivo=$arrHttp["fmt"].".fmt";
	$file=$arrHttp["fmt"];
	$url="fmt.php";	$lista="formatos.wks";
	$titulo=$msgstr["fmt"];
}
if (isset($arrHttp["pft"])){
	$file=$arrHttp["pft"];
	$url="pft.php";	$archivo=$arrHttp["pft"].".pft";
	$lista="formatos.dat";
	$titulo=$msgstr["pft"];
	$arrHttp["path"]="/pfts/".$_SESSION["lang"];
}
if (isset($arrHttp["tab"])){
	$archivo=$arrHttp["tab"];
	$lista="";
    $titulo=$msgstr["it_tb"];
	$url="";
}
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $arrHttp["base"].": ".$msgstr["delete"].". $titulo: ".$archivo?>
	</div>

	<div class="actions">
<?php
	 echo "<a href=\"pft.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "<font color=white>&nbsp; &nbsp; Script: delete_file.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><font face=verdana color=red>
<?php echo "<h4>".$msgstr["file"].": $archivo</h4>--";
if ($archivo!=""){
	$a=$db_path.$arrHttp["base"]."/".$arrHttp["path"]."/".$_SESSION["lang"]."/$archivo";
	if (!file_exists($a )) $a=$db_path.$arrHttp["base"]."/".$arrHttp["path"]."/".$lang_db."/$archivo";
	$res=unlink($a);
	if ($res==0){		echo $msgstr["nodeleted"];
	}else{		echo $msgstr["deleted"];
		if ($lista!=""){
			$salida="";			$fp=file($db_path.$arrHttp["base"]."/".$arrHttp["path"]."/$lista");
			foreach ($fp as $value){				$value=trim($value);
				$v=explode('|',$value);
				if ($v[0]!=$file) $salida.=$value."\n";			}
            $fp=fopen($db_path.$arrHttp["base"]."/".$arrHttp["path"]."/$lista","w");
            fwrite($fp,$salida);
            fclose($fp);
            echo "<p>$lista: ".$msgstr["updated"];
		}	}
}
if ($encabezado!=""){
	if (isset($arrHttp["pft"]) or $url!=""){		echo "<script>
			url='".$url."'

			if ( top.frames.length>0){
				if (top.ModuloActivo==\"Catalogar\")
					document.writeln(\"<p><a href=javascript:top.Menu('imprimir')>".$msgstr["regresar"]."</a>\")
				else
					document.writeln(\"<p><a href=\"+url+\"?base=".$arrHttp["base"].">".$msgstr["regresar"]."</a>\")
			}
			</script>
			";
	}}
?>