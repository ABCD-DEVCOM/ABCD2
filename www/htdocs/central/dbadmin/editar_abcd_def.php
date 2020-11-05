<?php
session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//foreach ($_REQUEST AS $var=>$value)  echo "$var=>$value<br>";
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");
if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];

//SE LEE LA LISTA DE MENSAJES DISPONIBLEE
$l=$msg_path.'lang/';
if ($handle = opendir($l)) {
	$lang_dir="";
    while (false !== ($entry = readdir($handle))) {
        if ($entry!="." and $entry!=".." and is_dir($l.$entry)){ 			if ($lang_dir=="")
 				$lang_dir=$entry;
 			else
 				$lang_dir.=";".$entry;        }
    }
}

function LeerIniFile($ini_vars,$ini,$tipo){global $msg_path;
	if ($tipo==1) $pref="ini_"; else $pref="mod_";
	foreach ($ini_vars as $key=>$Opt){

		if ($Opt["it"]=="title"){
 		    echo "<th colspan=2>".$Opt["Label"]."</th></tr>\n";
 		    continue;
 		}else{
 			echo "<td>$key</td>
		         <td>";
		}
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
					echo "<input type=checkbox name=$pref$key value='$o' ";
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
}
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Enviar(){	document.maintenance.submit()}
</script>
<body >
<?php
switch ($arrHttp["Opcion"]){
	case "abcd_def":
		$ini_vars=array("UNICODE" => array("it"=>"radio","Options"=>"0;1"),
						"CISIS_VERSION" => array("it"=>"radio","Options"=>$cisis_versions_allowed),
						"DEFAULT_LANG"  => array("it"=>"radio","Options"=>$lang_dir),
						"MULTIPLE_DB_FORMATS" => array("it"=>"radio","Options"=>"Y;N"),
						"DIRTREE" => array("it"=>"radio","Options"=>"Y;N"),
						"DIRTREE_EXT"=> array("it"=>"text","Options"=>""),
						"PROFILES_PATH"=> array("it"=>"text","Options"=>""),
						"SECURE_PASSWORD_LENGTH" => array("it"=>"text","Options"=>"","size"=>1),
						"SECURE_PASSWORD_LEVEL" => array("it"=>"radio","Options"=>"0;1;2;3;4;5"),
						"CIRCULATION"=>array("it"=>"title","Label"=>"<hr size=2>".$msgstr["loantit"]),
						"CALENDAR" => array("it"=>"radio","Options"=>"Y;N"),
						"RESERVATION" => array("it"=>"radio","Options"=>"Y;N"),
						"LOAN_POLICY" => array("it"=>"check","Options"=>"BY_USER"),
						"EMAIL" => array("it"=>"radio","Options"=>"Y;N"),
						"AC_SUSP" => array("it"=>"radio","Options"=>"Y;N"),
						"ASK_LPN" => array("it"=>"radio","Options"=>"Y;N"),
						"ILLOAN" => array("it"=>"radio","Options"=>"Y;N"),
						"STYLES" => array("it"=>"title","Label"=>"<hr size=2>".$msgstr["logo_css"]),
						"LEGEND1" => array("it"=>"text","Options"=>""),
						"LEGEND2" => array("it"=>"text","Options"=>""),
						"LEGEND3" => array("it"=>"text","Options"=>""),
						"URL1" => array("it"=>"text","Options"=>""),
						"URL2" => array("it"=>"text","Options"=>""),
						"URL3" => array("it"=>"text","Options"=>""),
						"LOGO" => array("it"=>"text","Options"=>""),
						"CSS_NAME" => array("it"=>"text","Options"=>""),
						"BODY_BACKGROUND" => array("it"=>"text","Options"=>""),
						"HEADING" => array("it"=>"text","Options"=>""),
						"USERINFO_FONTCOLOR" => array("it"=>"text","Options"=>""),
						"SECTIONINFO" => array("it"=>"text","Options"=>""),
						"SECTIONINFO_FONTCOLOR" => array("it"=>"text","Options"=>""),
						"HELPER" => array("it"=>"text","Options"=>""),
						"HELPER_FONTCOLOR" => array("it"=>"text","Options"=>""),
						"FOOTER" => array("it"=>"text","Options"=>""),
						"FOOTER_FONTCOLOR" => array("it"=>"text","Options"=>""),
						"BG_WEB" => array("it"=>"text","Options"=>""),
						"FRAME_1H" => array("it"=>"text","Options"=>""),
						"FRAME_2H" => array("it"=>"text","Options"=>""),
                        "MODULES" => array("it"=>"title","Label"=>"<HR size=2>"),
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
		$ini_vars=array("UNICODE" => array("it"=>"radio","Options"=>"0;1"),
						"CISIS_VERSION" => array("it"=>"radio","Options"=>$cisis_versions_allowed),
						"PDFIMPORT"=>array("it"=>"title","Label"=>"<hr size=2>"."IMPORT PDF"),
						"IMPORTPDF" => array("it"=>"radio","Options"=>"Y;N"),
						"COLLECTION" => array("it"=>"text","Options"=>""),
						"INVENTORY"=>array("it"=>"title","Label"=>"<hr size=2>"."INVENTORY"),
						"inventory_numeric" => array("it"=>"radio","Options"=>"Y;N"),
						"max_inventory_length" => array("it"=>"text","Options"=>""),
						"max_cn_length" => array("it"=>"text","Options"=>""),
						"barcode" => array("it"=>"radio","Options"=>"Y;N"),
						"barcode1reg" => array("it"=>"radio","Options"=>"Y;N"),
						"dirtree" => array("it"=>"radio","Options"=>"Y;N"),
						"TESAURUS"=>array("it"=>"title","Label"=>"<hr size=2>"."TESAURUS"),
						"tesaurus" => array("it"=>"text","Options"=>""),
						"prefix_search_tesaurus" => array("it"=>"text","Options"=>""),
						"OTHER"=>array("it"=>"title","Label"=>"<hr size=2>"."OTHER"),
						"DIRTREE_EXT" => array("it"=>"text","Options"=>""),
						"leader"      => array("it"=>"text","Options"=>""),
						"STYLES"=>array("it"=>"title","Label"=>"<hr size=2>"."STYLES"),
						"CSS_NAME" => array("it"=>"text","Options"=>""),
						"LOGO" => array("it"=>"text","Options"=>""),
						"DIGITAL"=>array("it"=>"title","Label"=>"<hr size=2>"."DIGITAL DOCUMENTS"),
						"ROOT" => array("it"=>"text","Options"=>""),
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
switch ($arrHttp["Opcion"]){
	case "abcd_def":
		echo "<a href=\"../dbadmin/conf_abcd.php?reinicio=s\" class=\"defaultButton backButton\">";
		break;
	case "css":
		echo "<a href=\"../dbadmin/conf_abcd.php?reinicio=s\" class=\"defaultButton backButton\">";
		break;
	default:
		echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
		break;
}
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
	&nbsp; &nbsp;<?php echo $msgstr["help"]?>: <a href=http://abcdwiki.net/wiki/es/index.php?title=<?php echo $help?> target=_blank>abcdwiki.net</a>
</div>
<?php
$ini=array();
$modulo=array();
$mod="";
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $key=>$value){
		$value=trim($value);
		if ($value!=""){
			$x=explode('=',$value);
			$x[0]=trim($x[0]);
			$x[1]=trim($x[1]);
			if (!isset($ini_vars[$x[0]])) continue;
			if ($x[0]=="DIRTREE_EXT" and trim($x[1])=="") $x[1]="*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,";
			if ($mod=="Y"){
				$modulo[$x[0]]=$x[1];
			}else{
				if (isset($x[1])){
					$ini[$x[0]]=$x[1];
				}else{
					if (trim($x[0])=="[MODULOS]"){
						$modulo[$x[0]]=$x[0];
						$mod="Y";
					}else{
						$ini[$x[0]]=$x[0];
					}
				}
			}
		}
	}
}
if (!isset($ini["DIRTREE_EXT"]) and $arrHttp["Opcion"]!="css")
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
if (!isset($arrHttp["Accion"])){
	echo "<input type=hidden name=Accion value=\"actualizar\">\n";
	echo "<table cellspacing=5 width=400 align=center >";
	LeerIniFile($ini_vars,$ini,"1");
	foreach ($ini as $key=>$val){
		if (!isset($ini_vars[$key]) and trim($val)!="") echo "<tr><td>$key</td><td><input type=text name=ini_$key value=\"$val\"></td></tr>";
	}
	if ($arrHttp["Opcion"]=="abcd_def"){
		echo "<tr><td colspan=2><strong>[MODULOS]</strong></td></tr>";
		LeerIniFile($mod_vars,$modulo,2);
	}
	echo "</table>";
}else{
	if ($arrHttp["Accion"]=="actualizar"){
	   $fp=fopen($file,"w");
	    foreach ($arrHttp as $key=>$Opt){
	    	if (substr($key,0,4)=="ini_"){
	    		$key=substr($key,4);
	    		echo $key."=".$arrHttp["ini_".$key]."<br>";
	    		fwrite($fp,$key."=".trim($arrHttp["ini_".$key])."\n");
	    	}
	    }
	    if ($arrHttp["Opcion"]=="abcd_def" and !isset($arrHttp["ini_LEGEND2"])){
	    	fwrite($fp,"LEGEND2=\n");
	    }
	    if (isset($arrHttp["mod_TITLE"])){
	    	echo "[MODULOS]<BR>";
	    	fwrite($fp,"[MODULOS]\n");
	    	foreach ($arrHttp as $key=>$Opt){
	    		if (substr($key,0,4)=="mod_"){
	    			$key=substr($key,4);
	    			echo $key."=".$arrHttp["mod_".$key]."<br>";
	    			fwrite($fp,$key."=".trim($arrHttp["mod_".$key])."\n");
	    		}
	   		}
	    }
	    fclose($fp);
	    echo "<h4>$help ".$msgstr["updated"]."</h4>";
	    //echo "<a href=editar_abcd_def.php?Opcion=".$_REQUEST["Opcion"]."&base=".$_REQUEST["base"].">".$msgstr["edit"]."</a>";
	 }
}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
