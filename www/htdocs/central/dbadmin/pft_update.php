<?PHP
/*
20220129 fho4abcd backbutton+divhelper+more feedback messages
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      pft_update.php
 * @desc:      Updates pft´s files
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
//error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");

include("../lang/dbadmin.php");
include("../lang/admin.php");

if (!isset($arrHttp["Modulo"])) $arrHttp["Modulo"]="";
include("../common/header.php");
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
}
if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["pft"]." - ". $msgstr["update"].": ".$arrHttp["nombre"].".pft (".$arrHttp["base"].")"?>
    </div>

    <div class="actions">
<?php
    if ($arrHttp["Opcion"]=="new"){
        $backtoscript="../common/inicio.php?reinicio=s";
		include "../common/inc_back.php";
	}else{
		if ($arrHttp["Modulo"]=="dataentry"){
            $backtoscript="pft.php?Modulo=dataentry";
            include "../common/inc_back.php";
		}else{
            $backtoscript="menu_modificardb.php";
            include "../common/inc_back.php";
            include "../common/inc_home.php";
        }
	}
?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (!isset($arrHttp["pftname"])){
	if (isset($arrHttp["pft"]))
		$arrHttp["pft"]=stripslashes($arrHttp["pft"]);
	else
		$arrHttp["pft"]=stripslashes($arrHttp["pftedit"]);

	$arrHttp["nombre"]=trim(strtolower($arrHttp["nombre"]));
	$arrHttp["nombre"]=str_replace(".pft","",$arrHttp["nombre"]);
    $archivobase=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["nombre"].".pft";
	$archivo=$db_path.$archivobase;
	$fp=fopen($archivo,"w");
	if (!$fp){
		echo "<h2 style='color:red'>$archivobase ".$msgstr["revisarpermisos"]."</h2>";
		die;
	}
	fputs($fp, $arrHttp["pft"]);
	fclose($fp);
	unset($fp);
	if (isset($arrHttp["headings"])){
        $archivo_hbase=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["nombre"]."_h.txt";
	   	$archivo_h=$db_path.$archivo_hbase;
		$fp=fopen($archivo_h,"w");
		$red=fwrite($fp,$arrHttp["headings"]);
		fclose($fp);
        echo "<h3>".$archivo_hbase." ".$msgstr["created"]."</h3>";
	}
    if (isset($arrHttp["desde"]) and ($arrHttp["desde"]=="dataentry" or $arrHttp["desde"]=="recibos")){
	    echo "<script>
				self.close()
			 </script>
			 </body>
			 </html>";
    	die;
    }
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat")){
		$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat");
	}else{
		if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat")){
			$fp=file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat");
		}
	}
	$flag="";
	// IF THERE IS A HEADING FOR THE FORMAT
	$head="";
	$tipof="|";
	if (isset($arrHttp["headings"])) {
		$head="Y";
		$tipof="|".$arrHttp["tipof"];
	}
	// DELETE THE FILE FORMAT NAME FROM THE DESCRIPTION OF THE FORMAT
	$desc=str_replace("(".$arrHttp["nombre"].")","",$arrHttp["descripcion"]);
    $datbase=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat";
	$dat=$db_path.$datbase;
	$fp_out=fopen($dat,"w");
	if (isset($fp)){
		foreach ($fp as $value){
			if (trim($value)!=""){
				$f=explode('|',$value);
				if ($f[0]==$arrHttp["nombre"]) {
					fputs($fp_out,$arrHttp["nombre"]."|".$desc.$tipof."\n");
					$flag="S";
				}else{
					fputs($fp_out,trim($value)."\n");
				}
			}
		}
	}
	fclose($fp_out);
	if ($flag!="S"){
		$fp_out=fopen($dat,"a");
		fputs($fp_out,$arrHttp["nombre"]."|".$desc.$tipof."\n");
		fclose($fp_out);
	}
    echo "<h3>".$datbase." ".$msgstr["updated"]."</h3>";


}else{
// SAVE OPERATORS ASSIGNED TO THE PFT
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat")){
		$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat");
	}else{
		if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat")){
			$fp=file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/formatos.dat");
		}
	}
	$p=explode('|',$arrHttp["pftname"]);
	$pname=$p[0];
	foreach ($fp as $value){
		$value=trim($value);
		$l=explode('|',$value);
		if (!isset($l[2])) $l[2]="";
		if ($l[0]==$pname){
			$salida[]=$l[0]."|".$l[1]."|".$l[2];
		}else{
			$salida[]=$value;
		}
	}
    $datbase=$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat";
	$dat=$db_path.$datbase;
	$fp_out=fopen($dat,"w");
	foreach ($salida as $value) {
		fputs($fp_out,$value."\n");
	}
	fclose($fp_out);
    echo "<h3>".$datbase." ".$msgstr["updated"]."</h3>";
}

if (isset($archivo))
	echo "<h3>$archivobase ".$msgstr["updated"]."</h3>";
else
	echo "<h3>".$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat ".$msgstr["updated"]."</h3>";

if (!isset($arrHttp["encabezado"])){
	$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat");
	if ($fp) {
		echo "<script>

		var i;
		if (top.ModuloActivo==\"catalog\"){
			selectbox=top.menu.document.forma1.formato
			for(i=selectbox.options.length-1;i>=0;i--){
				selectbox.remove(i);
			}
			top.menu.document.forma1.formato.options[0]=new Option('','');
		";
		$i=0;
		$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat");
		foreach($fp as $linea){
			if (trim($linea)!="") {
				$l=explode('|',$linea);
				$cod=trim($l[0]);
				$nom=trim($l[1]);
				if (trim($cod)!=""){
					$i=$i+1;
					echo "
					top.menu.document.forma1.formato.options[$i]=new Option('$nom','$cod');
					";
				}
			}
		}
		echo "}\n";
		$i=$i+1;
		echo "top.menu.document.forma1.formato.options[$i]=new Option('".$msgstr["noformat"]."','')\n";
        $i=$i+1;
		echo "top.menu.document.forma1.formato.options[$i]=new Option('".$msgstr["all"]."','ALL')\n";
		echo "top.menu.document.forma1.formato.selectedIndex=1
		     </script>";
	}
}
echo "</div></div>";
include("../common/footer.php");
if (isset($arrHttp['desde']) and ($arrHttp['desde']=="dataentry" or $arrHttp["desde"]=="recibos" )){
?>
<script>
	self.close()
</script>
<?php
}
?>