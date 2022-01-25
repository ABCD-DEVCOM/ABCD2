<?php
/* Modifications
2021-01-05 guilda Added $msgstr["regresar"]
2021-04-30 fho4abcd Error message if file is not writable. 
2021-04-30 fho4abcd Corrected html. Replaced helper code fragment by included file
2021-08-29 fho4abcd PDF-> Digital documents,no radiobutton. Digital documents-> 
linked documents
2022-01-18 rogercgui added new user-configurable classes
2022-01-24 rogercgui Included file renaming to avoid accumulation of images in the upload folder. Even without converting the extension the files will have fixed names.
*/
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

//directory where the images go
$target_dir = "../../assets/images/uploads/";

if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
//$Permiso=$_SESSION["permiso"];

//SE LEE LA LISTA DE MENSAJES DISPONIBLEE
$l=$msg_path.'lang/';
if ($handle = opendir($l)) {
	$lang_dir="";
    while (false !== ($entry = readdir($handle))) {
        if ($entry!="." and $entry!=".." and is_dir($l.$entry)){
 			if ($lang_dir=="")
 				$lang_dir=$entry;
 			else
 				$lang_dir.=";".$entry;
        }
    }
    closedir($handle);
}


//================= Function to read the abcd.def file ==========
function LeerIniFile($ini_vars,$ini,$tipo){
global $msg_path, $msgstr;

	if ($tipo==1) $pref="ini_"; else $pref="mod_";
	foreach ($ini_vars as $key=>$Opt){

		if ($Opt["it"]=="title"){
 		    echo "<tr><th colspan=2>".$Opt["Label"]."</th></tr>\n";
 		    continue;
 		}else{
 			echo "<tr>
 			<td style='vertical-align: top;'>
 			".$msgstr['set_'.$key]."
 			</td>
 			<td>";
		}
		switch ($Opt["it"]){
			case "color":
				$opc=explode(";",$Opt["Label"]);
		   		echo "<input type='color' class='mt-5' placeholder='".$Opt["default"]."' data-value='".$Opt["default"]."' name=ini_$key id=ini_$key size=";
		   		if (isset($Opt["size"]))
		   			echo trim($Opt["size"]);
				else
					echo "100";
		   		echo " value='";
		   		
		   		if (isset($ini[$key])) {
					echo $ini[$key];
				} else {
					echo $Opt["default"];
				}

				echo "'>";
				echo "<small>".$Opt["Label"]."</small> &nbsp;<button type=\"button\" clss=\" bt bt-sm bt-gray\" onclick=\"return cleanSet('".$Opt["default"]."','ini_".$key."')\" title=\"Reset\"><i class=\"fas fa-eraser\"></i></button> ";
				break;  			
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
					echo "> $o &nbsp; &nbsp;";
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
					echo "> $o &nbsp; &nbsp;";
				}
                break;
		   	case "hidden":
		   		echo "\n<input type=hidden name=ini_$key size=";
		   		if (isset($Opt["size"]))
		   			echo trim($Opt["size"]);
				else
					echo "100";
		   		echo " value='";
		   		if (isset($ini[$key])) echo $ini[$key];
				echo "'>\r\n";
				break;                

		   	case "file":
				if (isset($ini[$key])){  
					$file_value=$ini[$key];
				} else {
					$file_value="";
				}

		   		echo '<input type="file" name=ini_'.$key.' id=ini_'.$key.' accept="image/png, image/jpeg , image/jpg" onchange="preview_image'.$Opt["ID"].'(event)" value=';
		   		if (isset($ini[$key])) echo $ini[$key];
		   		echo '> <small> Max: 2MB </small>';

		 				if ((!isset($ini[$key])) or (empty($arrHttp[$key]))) {
				echo '<br><div class="mb-4"><img class="p-3 bg-gray-300 p-3 mt-3 " width="100" id="'.$Opt["ID"].'"/>'.$file_value.'</div>';
				} else {
					echo '<br><div class="mb-4"><img class="p-3 bg-gray-300 p-3 mt-3 " width="100" src=../../assets/images/uploads/'.$file_value.' id="'.$Opt["ID"].'"/> '.$file_value.'</div>';
				}

				echo "
					<script type='text/javascript'>
					function preview_image".$Opt["ID"]."(event) {
					 var reader = new FileReader();
					 reader.onload = function()  {
					  var output = document.getElementById('".$Opt["ID"]."');
					  output.src = reader.result;
					 }
					 reader.readAsDataURL(event.target.files[0]);
					}
					</script>";

				break;						


		}
		echo "</td></tr>";
	}
}
//============= end function ========
?>

<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>

<script language="javascript" type="text/javascript">

function Enviar(){
	document.maintenance.submit()
}

//Function that resets the colour values
function cleanSet(v,campo){
    document.getElementById(campo).value = v
    console.log(v);
    return false;
}
</script>

<?php
include("../common/institutional_info.php");

$set_mod = $arrHttp["Opcion"];

switch ($set_mod){

	case "abcd_styles":
		$ini_vars=array(
					"STYLES" => array("it"=>"title","Label"=>$msgstr["set_logo_css"]),
					"LOGO" => array("it"=>"file","Options"=>"","default"=>"","ID"=>"LOGO"),
					"INSTITUTION_NAME" => array("it"=>"text","Options"=>""),
					"INSTITUTION_URL" => array("it"=>"text","Options"=>""),
					"RESPONSIBLE_NAME" => array("it"=>"text","Options"=>""),
					"RESPONSIBLE_URL" => array("it"=>"text","Options"=>""),
					"RESPONSIBLE_LOGO" => array("it"=>"file","Options"=>"","default"=>"","ID"=>"RESPONSIBLE_LOGO"),				
					"LEGEND3" => array("it"=>"text","Options"=>""),
					"URL3" => array("it"=>"text","Options"=>""),
					"CSS_NAME" => array("it"=>"text","Options"=>""),
		     		"COLORS" => array("it"=>"title","Label"=>"<hr size=2>".$msgstr["set_colors"]),	 			
					"BODY_BACKGROUND" => array("it"=>"color","default"=>"#ffffff","Label"=>" Default: #ffffff or (R: 255, G: 255, B: 255)"),
					"COLOR_LINK" => array("it"=>"color","default"=>"#336699","Label"=>" Default: #336699 or (R: 51, G: 102, B: 153)"),
					"HEADING" => array("it"=>"color","default"=>"#003366","Label"=>" Default: #003366 or (R: 0, G: 51, B: 102)"),
					"HEADING_FONTCOLOR" => array("it"=>"color","default"=>"#f8f8f8","Label"=>" Default: #f8f8f8 or (R: 248, G: 248, B: 248)" ),
					"SECTIONINFO" => array("it"=>"color","default"=>"#336699","Label"=>" Default: #336699 or (R: 51, G: 102, B: 153)"),
					"SECTIONINFO_FONTCOLOR" => array("it"=>"color","default"=>"#ffffff","Label"=>" Default: #ffffff or (R: 255, G: 255, B: 255)"),
					"TOOLBAR" => array("it"=>"color","default"=>"#f8f8f8","Label"=>" Default: #f8f8f8 or (R: 248, G: 248, B: 248)"),
					"HELPER" => array("it"=>"color","default"=>"#f8f8f8","Label"=>" Default: #f8f8f8 or (R: 248, G: 248, B: 248)"),
					"HELPER_FONTCOLOR" => array("it"=>"color","default"=>"#666666","Label"=>" Default: #666666 or (R: 102, G: 102, B: 102)"),
					"FOOTER" => array("it"=>"color","default"=>"#003366","Label"=>" Default: #003366 or (R: 0, G: 51, B: 102)"),
					"FOOTER_FONTCOLOR" => array("it"=>"color","default"=>"#f8f8f8","Label"=>" Default: #f8f8f8 or (R: 248, G: 248, B: 248)"),
					"BG_WEB" => array("it"=>"text","Options"=>""),
					"FRAME_1H" => array("it"=>"text","Options"=>""),
					"FRAME_2H" => array("it"=>"text","Options"=>""),
					"CIRCULATION"=>array("it"=>"title","Label"=>"<hr>".$msgstr["loantit"]),
					"CALENDAR" => array("it"=>"radio","Options"=>"Y;N"),
					"RESERVATION" => array("it"=>"radio","Options"=>"Y;N"),
					"LOAN_POLICY" => array("it"=>"check","Options"=>"BY_USER"),
					"EMAIL" => array("it"=>"radio","Options"=>"Y;N"),
					"AC_SUSP" => array("it"=>"radio","Options"=>"Y;N"),
					"ASK_LPN" => array("it"=>"radio","Options"=>"Y;N"),
					"ILLOAN" => array("it"=>"radio","Options"=>"Y;N"),		

					"SECURITY" => array("it"=>"title","Label"=>$msgstr["set_security"]),
  					"UNICODE" => array("it"=>"radio","Options"=>"0;1"),
					"CISIS_VERSION" => array("it"=>"radio","Options"=>$cisis_versions_allowed),
					"DEFAULT_LANG"  => array("it"=>"radio","Options"=>$lang_dir),
					"MULTIPLE_DB_FORMATS" => array("it"=>"radio","Options"=>"Y;N"),
					"DIRTREE" => array("it"=>"radio","Options"=>"Y;N"),
					"DIRTREE_EXT"=> array("it"=>"text","Options"=>""),
					"PROFILES_PATH"=> array("it"=>"text","Options"=>""),
					"SECURE_PASSWORD_LENGTH" => array("it"=>"text","Options"=>"","size"=>1),
					"SECURE_PASSWORD_LEVEL" => array("it"=>"radio","Options"=>"0;1;2;3;4;5"),


                     "MODULES" => array("it"=>"title","Label"=>"<HR size=2>"),
					);

		$mod_vars=array("TITLE" => array("it"=>"text","Options"=>""),
						"SCRIPT" => array("it"=>"text","Options"=>""),
						"BUTTON" => array("it"=>"text","Options"=>""),
						"SELBASE" => array("it"=>"radio","Options"=>"Y;N")
						);
		$file=$db_path."abcd.def";
		$help="abcd.def";
		break;

	case "dr_path":
		$ini_vars=array("UNICODE" => array("it"=>"radio","Options"=>"0;1"),
						"CISIS_VERSION" => array("it"=>"radio","Options"=>$cisis_versions_allowed),
						"DIGDOCS"=>array("it"=>"title","Label"=>"<hr size=2>"."DIGITAL DOCUMENTS"),
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
						"LOGO" => array("it"=>"file","Options"=>""),
						"DIGITAL"=>array("it"=>"title","Label"=>"<hr size=2>"."LINKED DOCUMENTS"),
						"ROOT" => array("it"=>"text","Options"=>""),
						);
		$file=$db_path.$arrHttp["base"]."/dr_path.def";
		$help=$arrHttp["base"].": dr_path.def";
		break;
}



?>


<div class="sectionInfo">
	<div class="breadcrumb">
<?php 
        echo $msgstr["editar"].": ".$help
?>
	</div>
	<div class="actions">
<?php

switch ($arrHttp["Opcion"]){
	case "abcd_styles":
		$backtoscript="../settings/conf_abcd.php?reinicio=s";
		include "../common/inc_back.php";

		break;
	case "security":

		$backtoscript="../settings/conf_abcd.php?reinicio=s";
		include "../common/inc_back.php";

		break;
	case "dr_path":

		$backtoscript="menu_modificardb.php?base=".$arrHttp["base"]."&encabezado=s";
		include "../common/inc_back.php";

		break;
}



if (!isset($arrHttp["Accion"]) or $arrHttp["Accion"]!=="actualizar"){

$savescript="javascript:Enviar()";

include "../common/inc_save.php";	

}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
include "../common/inc_div-helper.php";

$ini=array();
$modulo=array();
$mod="";
// Read a possible existing abcd.def/dr_path.def file
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

/* UPLOAD IMAGE */
function uplodimages($fieldname,$fileimg) {
global $fieldname, $fp, $msg_path, $msgstr,$def,$target_dir;


$target_file = $target_dir.basename($_FILES[$fileimg]["name"]);


$temp = explode(".", $target_file);
$newfilename = $fieldname.'.'. end($temp);

$target_file = $target_dir.basename($newfilename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES[$fileimg]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
/*
if (file_exists($target_file)) {
	fwrite($fp,$fieldname."=".$def[$fieldname]."\n");	
  //echo "Sorry, file already exists.";
  //$uploadOk = 0;
}
*/

// Check file size
if ($_FILES[$fileimg]["size"] > 2097152) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
 // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."."<br>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo $msgstr["set_notsentfile"]."<br>";;
// if everything is ok, try to upload file
} else {

  if (move_uploaded_file($_FILES[$fileimg]["tmp_name"], $target_file)) {
    echo $msgstr["set_thefile"]."&nbsp;<b>".htmlspecialchars( basename( $_FILES[$fileimg]["name"]))."</b>&nbsp;".$msgstr["set_has_been_upload"]."<br>";

  } else {
    echo $msgstr["set_error_upload"]."<br>";;
       fwrite($fp,$fieldname."=".$fileimg."\n");
  }
}	

}
/* END IMAGE UPLOAD */

if (!isset($ini["DIRTREE_EXT"]) and $arrHttp["Opcion"]!="css")
	$ini["DIRTREE_EXT"]="*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,";
?>


<div class="middle">
	<div class="formContent" >


<form name="maintenance" method="post" enctype="multipart/form-data">
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<?php
if (isset($arrHttp["base"]))
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";

if (!isset($arrHttp["Accion"])){
	echo "<input type=hidden name=Accion value=\"actualizar\">\n";
	echo "<table cellspacing=8 width=90% align=center >";

	LeerIniFile($ini_vars,$ini,"1");
	foreach ($ini as $key=>$val){
		if (!isset($ini_vars[$key]) and trim($val)!="") echo "<tr><td>$key</td><td><input type=text name=ini_$key value=\"$val\"></td></tr>";
	}

	if ($arrHttp["Opcion"]=="abcd_styles"){
		echo "<tr><td colspan=2><strong>[MODULOS]</strong></td></tr>";
		LeerIniFile($mod_vars,$modulo,2);
	}
?>
	<tr>
	<td></td>
	<td>
		<a class="bt bt-green" href="javascript:Enviar()" ><i class="far fa-save"></i> <?php echo $msgstr["actualizar"]?></a>
		<a class="bt bt-gray" href="../settings/conf_abcd.php?reinicio=s"><i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["cancel"]?></a>
	</td>
	</tr>

</table>

<?php	
}else{
    if ($arrHttp["Accion"]=="actualizar"){
        $fp=@fopen($file,"w");
        if (!$fp) {
            $contents_error= error_get_last();
            echo "<font color=red><b>".$msgstr["copenfile"]." ".$help."</b> : ".$contents_error["message"];
        } else { 
            foreach ($arrHttp as $key=>$Opt){
               if (substr($key,0,4)=="ini_"){
                    $key=substr($key,4);
                    echo $key."=".$arrHttp["ini_".$key]."<br>";
                    fwrite($fp,$key."=".trim($arrHttp["ini_".$key])."\n");

  
                }

            }

                    $fileslist=array("ini_LOGO", "ini_RESPONSIBLE_LOGO");


					foreach ($fileslist as $fileimg){
   						$fieldname=substr($fileimg, strlen("ini_"));

   						if ($_FILES[$fileimg]["name"]) {

						$temp = explode(".", $_FILES[$fileimg]["name"]);
						$newfilename = $fieldname.'.'. end($temp);
						$file_name  = $newfilename;

   						fwrite($fp,$fieldname."=".$file_name ."\n");
   					} else {
						fwrite($fp,$fieldname."=".$def[$fieldname]."\n");	
					}

   						uplodimages($fieldname,$fileimg);  			

					}

/*
            if ($arrHttp["Opcion"]=="abcd_def" and !isset($arrHttp["ini_LEGEND2"])){
                fwrite($fp,"LEGEND2=\n");
            }

*/            
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
}
?>
</form>
</div>
</div>

<?php include("../common/footer.php");?>

