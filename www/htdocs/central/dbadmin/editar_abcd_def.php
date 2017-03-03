<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=>$value<br>";
if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
function LeerIniFile($ini_vars,$ini){
	foreach ($ini_vars as $key=>$Opt){
		echo "<tr>
		         <td>$key</td>
		         <td>";
		switch ($Opt["it"]){
		   	case "text":
		   		echo "<input type=text name=ini_$key size=";
		   		if (isset($Opt["size"]))
		   			echo trim($Opt["size"]);
				else
					echo "100";
		   		echo " value='";
		   		if (isset($ini[$key])) echo $ini[$key];
				echo "'>";
				break;
			case "radio":
				$opc=explode(";",$Opt["Options"]);
				foreach ($opc as $o){
					echo "<input type=radio name=ini_$key value='$o' ";
					if (isset($ini[$key])){
						if ($ini[$key]==$o)
							echo " checked";
					}
					echo ">$o &nbsp; &nbsp;";
				}
				break;
			case "check":
				$opc=explode(";",$Opt["Options"]);
				foreach ($opc as $o){
					echo "<input type=checkbox name=ini_$key value='$o' ";
					if (isset($ini[$key])){
						if ($ini[$key]==$o)
							echo " checked";
					}
					echo ">$o &nbsp; &nbsp;";
				}
                break;
		}
		echo "</td></tr>\n";
	}
	echo "<hr>";
}
?>

<script src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Enviar(){	document.maintenance.submit()}
</script>
<body >
<?php
switch ($arrHttp["Opcion"]){
	case "abcd_def":
		$ini_vars=array("LEGEND1" => array("it"=>"text","Options"=>""),
						"LEGEND2" => array("it"=>"text","Options"=>""),
						"LEGEND3" => array("it"=>"text","Options"=>""),
						"URL1" => array("it"=>"text","Options"=>""),
						"URL2" => array("it"=>"text","Options"=>""),
						"URL3" => array("it"=>"text","Options"=>""),
						"UNICODE" => array("it"=>"radio","Options"=>"0;1"),
						"LOGO" => array("it"=>"text","Options"=>""),
						"LOGO_OPAC" => array("it"=>"text","Options"=>""),
						"CSS_NAME" => array("it"=>"text","Options"=>""),
						"BG_WEB" => array("it"=>"text","Options"=>""),
						"CALENDAR" => array("it"=>"radio","Options"=>"Y;N"),
						"WEBRENOVATION" => array("it"=>"radio","Options"=>"Y;N"),
						"RESERVATION" => array("it"=>"radio","Options"=>"Y;N"),
						"LOAN_POLICY" => array("it"=>"check","Options"=>"BY_USER"),
						"EMAIL" => array("it"=>"radio","Options"=>"Y;N"),
						"AC_SUSP" => array("it"=>"radio","Options"=>"Y;N"),
						"ASK_LPN" => array("it"=>"radio","Options"=>"Y;N"),
						"DIRTREE" => array("it"=>"radio","Options"=>"Y;N"),
						"DIRTREE_EXT"=> array("it"=>"text","Options"=>""),
						"SECURE_PASSWORD_LENGTH" => array("it"=>"text","Options"=>"","size"=>1),
						"SECURE_PASSWORD_LEVEL" => array("it"=>"radio","Options"=>"0;1;2;3;4;5"),
						"FRAME_1H" => array("it"=>"text","Options"=>""),
						"FRAME_2H" => array("it"=>"text","Options"=>""),
                        "MULTIPLE_DB_FORMATS" => array("it"=>"radio","Options"=>"Y;N"),
						);
		$mod_vars=array("TITLE" => array("it"=>"text","Options"=>""),
						"SCRIPT" => array("it"=>"text","Options"=>""),
						"BUTTON" => array("it"=>"text","Options"=>""),
						"SELBASE" => array("it"=>"radio","Options"=>"Y;N")

						);
		$file=$db_path."abcd.def";
		$help="Abcd.def";
		break;
	case "dr_path":
		$ini_vars=array("CSS_NAME" => array("it"=>"text","Options"=>""),
						"LOGO" => array("it"=>"text","Options"=>""),
						"ROOT" => array("it"=>"text","Options"=>""),
						"cisis_ver" => array("it"=>"text","Options"=>""),
						"UNICODE" => array("it"=>"radio","Options"=>"0;1"),
						"db_path" => array("it"=>"text","Options"=>""),
						"mx_path" => array("it"=>"text","Options"=>""),
						"wxis_get" => array("it"=>"text","Options"=>""),
						"wxis_post" => array("it"=>"text","Options"=>""),
						"tesaurus" => array("it"=>"text","Options"=>""),
						"prefix_search_tesaurus" => array("it"=>"text","Options"=>""),
						"barcode" => array("it"=>"radio","Options"=>"Y;N"),
						"barcode1reg" => array("it"=>"radio","Options"=>"Y;N"),
						"dirtree" => array("it"=>"radio","Options"=>"Y;N"),
						"DIRTREE_EXT" => array("it"=>"text","Options"=>""),
						);
		$file=$db_path.$arrHttp["base"]."/dr_path.def";
		$help="Dr_path.def";
		break;
}
	include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">$help
			</div>
			<div class=\"actions\">

	";
if ($arrHttp["Opcion"]=="abcd_def")
	echo "<a href=\"../dbadmin/conf_abcd.php?reinicio=s\" class=\"defaultButton backButton\">";
else
	echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>Regresar</strong></span></a>";
if (!isset($arrHttp["Accion"]) or $arrHttp["Accion"]!=="actualizar"){
	echo "<a href=\"javascript:Enviar()\" class=\"defaultButton saveButton\">";
	echo "
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
			<span><strong>". $msgstr["save"]."</strong></span>
			</a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php


if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])  or isset($_SESSION["permiso"]["CENTRAL_ALL"]) )
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/distribucion.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=$help target=_blank>abcdwiki.net</a>";
$ini=array();
$modulo=array();
$mod="";
if (file_exists($file)){	$fp=file($file);
	foreach ($fp as $key=>$value){
		$value=trim($value);
		if ($value!=""){
			$x=explode('=',$value);
			if ($x[0]=="DIRTREE_EXT" and trim($x[1])=="") $x[1]="*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,";
			if ($mod=="Y"){				$modulo[$x[0]]=$x[1];			}else{				if (isset($x[1])){					$ini[$x[0]]=$x[1];
				}else{					if (trim($x[0])=="[MODULOS]"){						$modulo[$x[0]]=$x[0];
						$mod="Y";					}else{						$ini[$x[0]]=$x[0];					}				}
			}
		}
	}}
if (!isset($ini["DIRTREE_EXT"]))
	$ini["DIRTREE_EXT"]="*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,";
?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<form name=maintenance method=post>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<?php
if (isset($arrHttp["base"]))
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
if (!isset($arrHttp["Accion"])){	echo "<input type=hidden name=Accion value=\"actualizar\">\n";	echo "<table cellspacing=5 width=400 align=center >";
	LeerIniFile($ini_vars,$ini);
	foreach ($ini as $key=>$val){
		if (!isset($ini_vars[$key]) and trim($val)!="") echo "<tr><td>$key</td><td><input type=text name=ini_$key value=\"$val\"></td></tr>";
	}
	if ($arrHttp["Opcion"]=="abcd_def"){		echo "<tr><td colspan=2><strong>[MODULOS]</strong></td></tr>";
		LeerIniFile($mod_vars,$ini);	}
	echo "</table>";
}else{	if ($arrHttp["Accion"]=="actualizar"){	   $fp=fopen($file,"w");
	    foreach ($arrHttp as $key=>$Opt){	    	if (substr($key,0,4)=="ini_"){	    		$key=substr($key,4);	    		echo $key."=".$arrHttp["ini_".$key]."<br>";
	    		fwrite($fp,$key."=".trim($arrHttp["ini_".$key])."\n");
	    	}	    }
	    if ($help=="Abcd.def" and !isset($arrHttp["ini_LEGEND2"])){	    	fwrite($fp,"LEGEND2=\n");	    }
	    if (isset($arrHttp["mod_TITLE"])){	    	echo "[MODULOS]<BR>";
	    	foreach ($mod_vars as $key){
	    		if (isset($arrHttp["mod_".$key])){
	    			echo $key."=".$arrHttp["mod_".$key]."<br>";
	    			fwrite($fp,$key."=".trim($arrHttp["mod_".$key])."\n");
	    		}
	   		}
	    }
	    fclose($fp);
	    echo "<h4>$help ".$msgstr["updated"]."</h4>";
	 }}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
