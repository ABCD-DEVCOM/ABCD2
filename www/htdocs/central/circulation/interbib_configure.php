<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure.php
 * @desc:      Input the configuration of the borrowers (users) database
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
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$archivo=$db_path."/circulation/def/".$_SESSION["lang"]."/sala.tab";
if (!file_exists($archivo)) $archivo=$db_path."/circulation/def/".$lang_db."/sala.tab";
$fp=file_exists($archivo);
$sala=array();
if ($fp){
	$fp=file($archivo);
	foreach ($fp as $value){		$value=trim($value);
		if ($value!=""){			$v=explode('=',$value);
			$sala[$v[0]]=$v[1];		}
	}
}

include("../common/header.php");

function Actualizar(){global $db_path,$arrHttp,$msgstr;
    $archivo=$db_path."circulation/def/".$_SESSION["lang"]."/ill.tab";
    $ix=-1;
    foreach ($_REQUEST as $key=>$value){    	if (substr($key,0,4)=="tag_"){    		$t=explode('_',$key);
    		$ix=$t[2];
    		$xc=$t[1];
    		if (isset($s[$ix]))
    			$s[$ix].=trim($value);
    		else
    			$s[$ix]=trim($value).'|';
    	}    }
    $fp=fopen($archivo,"w");
    foreach ($s as $value){    	if (trim($value)!="|"){    		fwrite($fp,$value."\n");    	}    }
    fclose($fp);
    echo "<h2>ill.tab ".$msgstr["saved"];}
?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function Guardar(){
	document.forma1.action="interbib_configure.php"
	document.forma1.target="_self";
    document.forma1.submit()
}

</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".$msgstr["r_ill"]." - ".$msgstr["configure"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
				if (!isset($arrHttp["actualizar"]))
					echo "
				<a href=javascript:Guardar() class=\"defaultButton saveButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>".$msgstr["update"]."</strong></span>
				</a>";
				echo "
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/loans_borrowers_configure.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/loans_borrowers_configure.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=Pr%C3%A9stamo_interbibliotecario target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/sala_configure.php </font>";
echo "</div>
		<div class=\"middle form\">
			<div class=\"formContent\"> ";
echo "<form name=forma1 action=sala_configure.php method=post>\n";
if (isset($arrHttp["actualizar"]) and $arrHttp["actualizar"]=="Y"){	Actualizar();}else{
	echo "<input type=hidden name=actualizar value=Y>\n";
	if (file_exists($db_path."circulation/def/".$_SESSION["lang"]."/ill.tab")){		$ibib=file($db_path."circulation/def/".$_SESSION["lang"]."/ill.tab");	}else{		$ibib=array();	}
	echo " <h4>".$msgstr["agreement"]."</h4>";
	echo "<table> ";
	echo "<tr><th>Id</th><th>".$msgstr["agreement"]."</th></tr>";
	$ix=-1;
	foreach ($ibib as $value){		$value=trim($value);
		if ($value!=""){			$ix=$ix+1;
			$v=explode('|',$value);
			echo "<tr><td><input type=text name=tag_a_$ix value=\"".trim($v[0])."\"></td>\n";
			echo "    <td><input type=text name=tag_b_$ix value=\"".trim($v[1])."\" size=100></td>\n";
			echo "</tr>\n";		}
	}
	for ($i=0;$i<2;$i++){		$ix=$ix+1;
		echo "<tr><td><input type=text name=tag_a_$ix value=\"\"></td>\n";
		echo "    <td><input type=text name=tag_b_$ix value=\"\" size=100></td>\n";
		echo "</tr>";	}
	echo "</table>\n";
}
echo "</form></div></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>