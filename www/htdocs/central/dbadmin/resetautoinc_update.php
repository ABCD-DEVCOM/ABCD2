<?php
/*
20220203 fho4abcd backbutton,div-helper
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      resetautoinc_update.php
 * @desc:      Mark/unmark in the file bases.dat when a database is linked or not with de copies handling
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
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
switch ($arrHttp["Opcion"]){
	case "control_n":
		$file=$db_path.$arrHttp["base"]."/data/control_number.cn";
		$msg=$msgstr["resetcn"];
		$upd=$msgstr["lastcnupd"];
		break;
	case "inventory":
		$file=$db_path."copies/data/control_number.cn";
		$msg=$msgstr["resetinv"];
		$upd=$msgstr["lastinvupd"];
		break;
	case "copies":
	   	$msg=$msgstr["linkcopies"];
	   	break;

}
if (isset($file) and file_exists($file)){
	$fp=file($file);
	$cn_val=implode("",$fp);
}

include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msg;
		if (isset($arrHttp["base"])) echo": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
        <?php
        if ($arrHttp["Opcion"]!="inventory"){
            $backtoscript="../dbadmin/menu_mantenimiento.php";
            include "../common/inc_back.php";
        }
        include "../common/inc_home.php";
    ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php
if ($arrHttp["Opcion"]=="copies"){
	$fp=file($db_path."bases.dat");
	$new=fopen($db_path."bases.dat","w");
	foreach ($fp as $value){
		$value=trim($value);
		$val=explode('|',$value);
		if (trim($val[0])==trim($arrHttp["base"])){
			$value=$val[0].'|'.$val[1]."|";
			if (isset($arrHttp["copies"])){
				$value.='Y';
				$msg=$msgstr["linkedtocopies"];
			}else{
				$msg=$msgstr["unlinkedtocopies"];
			}

		}
		fwrite($new,$value."\n");
	}
	fclose($new);
    echo "<dd><h4>"."<br>".$arrHttp["base"]." ".$msg."</h4>";
}else{
	$fp=fopen($file,"w");
	fwrite($fp,$arrHttp["control_n"]);
	fclose($fp);

	echo "<dd><h4>"."<br>".$upd." ".$arrHttp["control_n"]."</h4>";
}
echo "</div></div>";
include("../common/footer.php");
?>