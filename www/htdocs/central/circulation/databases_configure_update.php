<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      databases_configure_update.php
 * @desc:      Update the configuration of an bibliographic database
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

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";  die;

function ActualizarLoansDat(){global $db_path,$arrHttp,$msgstr;
	$link_copies="N";
	$bases_dat=array();
	$fp=file($db_path."bases.dat");
//SE VERIFICA SI HAY ALGUNA BASE DE DATOS VINCULADA CON LOANOBJECTS
	foreach ($fp as $base){		$base=trim($base);		if ($base!=""){
			$b=explode("|",$base);
			if (!isset($b[2])) $b[2]="N";
			if ($b[2]!="Y")
				$bases_dat[$b[0]]=$base;
			else
				$link_copies="Y";

		}
	}
	//echo $msgstr["bd_loanobjects"].": $link_copies <br>";
	$loans_dat=array();
	$loans_kardex=array();
	if (file_exists($db_path."loans.dat")){
		$fp=file($db_path."loans.dat");
		foreach ($fp as $base){			$base=trim($base);			if ($base!=""){				$b=explode("|",$base);
				if (isset($bases_dat[$b[0]]))
					$loans_dat[$b[0]]=$b[1];
					if (isset($b[2]))
						$loans_kardex[$b[0]]=$b[2];   //KARDEX DE PUBLICACIONES			}		}

	}
	if (!isset($loans_dat[$arrHttp["base"]])){
		$base=$bases_dat[$arrHttp["base"]];
		$base=trim($base);
		if ($base!=""){
			$b=explode("|",$base);
			if ($b[0]!="loanobjects")
			    $loans_dat[$b[0]]=$b[1];
		}
	}
	if ($link_copies!="Y"){		echo "<h5><font color=darkred>loans.dat</font></H5>";
		$fp=fopen ($db_path."loans.dat","w");
		foreach ($loans_dat as $var=>$value){
			$value=trim($value);
			if ($value!=""){
				if ($var!="loanobjects"){
					echo "$var|$value|";
					if(isset($loans_kardex[$var])){						echo $loans_kardex[$var];
						$value.='|'.$loans_kardex[$var];					}
					echo "<br>";					fwrite($fp,$var."|".$value."\n");
				}			}		}
		fclose($fp);
		echo "<h2>loans.dat: ".$msgstr["updated"]."</h4>";
	}else{		if (file_exists($db_path."loans.dat"))		 	unlink($db_path."loans.dat");	}
}

function GuardarPft($Pft,$base){global $msgstr,$db_path,$arrHttp;
	$dir=$db_path.$arrHttp["base"]."/loans";
	$dir_short=$arrHttp["base"]."/loans/".$_SESSION["lang"]."/";
	if (!file_exists($dir)){		$res=mkdir($dir);
		if (!$res) {			echo $dir_short." ".$msgstr["foldernotc"];
			die;		}
		$dir.="/".$_SESSION["lang"];
		if (!file_exists($dir)){
			$res=mkdir($dir);
			if (!$res) {				echo $dir_short." ".$msgstr["foldernotc"];
				die;			}
		}
	}
	$fp=fopen($base,"w");
	fwrite($fp,$Pft);
	fclose($fp);	echo "<xmp>".$Pft."</xmp><p>";
	echo $dir_short.$arrHttp["base"]. " ". $msgstr["saved"]."<hr>";
}

include("../common/header.php");
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["sourcedb"].". ".$msgstr["loan"].". ".$msgstr["configure"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"databases.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"middle form\">
			<div class=\"formContent\">\n";

$object_db=$arrHttp["base"];

if ($object_db!="loanobjects"){
	$Pft="";
	if ($arrHttp["link_copies"]=="N"){
		if (isset($arrHttp["invkey"])){
			echo "<h5><font color=darkred>". $msgstr["invkey"]." - ".$msgstr["nckey"]."</font></H5>";
			$Pft="IN ".$arrHttp["invkey"];
		}

		if (isset($arrHttp["nckey"])and trim($arrHttp["nckey"])!=""){			$Pft.="\nNC ".$arrHttp["nckey"];
		}

		GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_conf.tab");
	}else{
		$file=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_conf.tab";		if (file_exists($file))
			unlink($file);	}

	if ($arrHttp["link_copies"]=="N"){
		if (!isset($arrHttp["num_i"]))
			$arrHttp["num_i"]="";
		echo "<h5><font color=darkred>". $msgstr["pft_ninv"]."</font></H5>";
		$Pft=stripslashes($arrHttp["num_i"]);
		GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_inventorynumber.pft");
	}else{		$file=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_inventorynumber.pft";
		if (file_exists($file))
			unlink($file);	}

	if (!isset($arrHttp["num_c"]))
		$arrHttp["num_c"]="";
	echo "<h5><font color=darkred>". $msgstr["pft_nclas"]."</font></H5>";
	$Pft=stripslashes($arrHttp["num_c"]);
	GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_cn.pft");

	if ($arrHttp["link_copies"]=="N"){
		if (!isset($arrHttp["tm"]))
			$arrHttp["tm"]="";
		echo "<h5><font color=darkred>". $msgstr["pft_typeofr"]."</font></H5>";
		$Pft=stripslashes($arrHttp["tm"]);
		GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_typeofobject.pft");
	}else{		$file=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_typeofobject.pft";
		if (file_exists($file))
			unlink($file);	}

	if ($arrHttp["link_copies"]=="N"){
		if (!isset($arrHttp["totalej"]))
			$arrHttp["totalej"]="";
		echo "<h5><font color=darkred>". $msgstr["pft_typeofr"]."</font></H5>";
		$Pft=stripslashes($arrHttp["totalej"]);
		GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_totalitems.pft");
	}else{		$file=$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_totalitems.pft";
		if (file_exists($file))
			unlink($file);	}

	// Estos formatos son comunes para las dos modalidades de préstamos (sin copies o con copies)
	if (!isset($arrHttp["bibref"]))
		$arrHttp["bibref"]="";
	echo "<h5><font color=darkred>". $msgstr["pft_obj"]."</font></H5>";
	$Pft=stripslashes($arrHttp["bibref"]);
	GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_display.pft");

	if (!isset($arrHttp["bibstore"]))
		$arrHttp["bibstore"]="";
	echo "<h5><font color=darkred>". $msgstr["pft_store"]."</font></H5>";
	$Pft=stripslashes($arrHttp["bibstore"]);
	GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_store.pft");

	if (!isset($arrHttp["loandisp"]))
		$arrHttp["loandisp"]="";
	echo "<h5><font color=darkred>". $msgstr["pft_loandisp"]."</font></H5>";
	$Pft=stripslashes($arrHttp["loandisp"]);
	GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/loans_show.pft");

	if (!isset($arrHttp["tor"]))
		$arrHttp["tor"]="";
	echo "<h5><font color=darkred>". $msgstr["pft_typeobjreserv"]."</font></H5>";
	$Pft=stripslashes($arrHttp["tor"]);
	GuardarPft($Pft,$db_path.$arrHttp["base"]."/loans/".$_SESSION["lang"]."/reserve_object.pft");
}
//SE ELIMINA O CREA O ACTUALIZA EL LOANS.DAT

ActualizarLoansDat();
?>
</div></div>
<?php include ("../common/footer.php");?>
</body>
</html>