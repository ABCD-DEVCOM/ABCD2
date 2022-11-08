<?php
/*
20220717 fho4abcd Use $actparfolder as location for .par & def files
20220822 fho4abcd Create shortcut.pft files if needed
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/iah_conf.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");

unset($fp);

?>
</head>
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
<?php echo $msgstr["iah-conf"].": ".$arrHttp["base"].".def"?>
	</div>
	<div class="actions">
<?php
if (isset($arrHttp["encabezado"]))
	$backtoscript= "menu_modificardb.php?base=".$arrHttp["base"].$encabezado;
	include "../common/inc_back.php";
?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php

$ayuda="iah_edit_db.html";
include "../common/inc_div-helper.php";

?>
<div class="middle form">
	<div class="formContent">


	<?php
	$arrHttp["ValorCapturado"]= stripslashes($arrHttp["ValorCapturado"]);
	echo "<pre>".$arrHttp["ValorCapturado"]."</pre>";
	$file=$db_path.$actparfolder.strtoupper($arrHttp["base"]).".def";
	$fp=fopen($file,"w");
	if (!$fp){
		echo "Cannot open the file $file for writing";
		die;
	}
	$res=fwrite($fp,$arrHttp["ValorCapturado"]);

	fclose($fp);
	echo "<h3>".$msgstr["saved"]." ".$file."</h3>";
    /*
    ** Write an initial shortcut.pft if required and possible
    ** This might need the languages
    */
    $iah_def=parse_ini_file("../../iah/scripts/iah.def.php");
    $iah_lang=explode(',',$iah_def["AVAILABLE LANGUAGES"]);
    // Get the value of FILE SHORTCUT.IAH
    $db_def=parse_ini_file ($file,true,INI_SCANNER_RAW);
	if (isset($db_def["FILE_LOCATION"]["FILE SHORTCUT.IAH"])){
        $shortcut_iah=$db_def["FILE_LOCATION"]["FILE SHORTCUT.IAH"];
        // replace %path_database%
        $shortcut_iah=str_replace("%path_database%",$db_path."/",$shortcut_iah);
        // Check for %lang%
        if ( strpos($shortcut_iah,"%lang%") === false) {
            // No language indicator: use the filename
            CrearArchivo($shortcut_iah);
        } else {
            foreach ($iah_lang as $value){
                $lan_iah=trim($value);
                // replace %lang%
                $shortcut_iah_lang=str_replace("%lang%",$lan_iah."/",$shortcut_iah);
                CrearArchivo($shortcut_iah_lang);
            }
        }
                
    }
	?>
	</div>

</div>
<?php include("../common/footer.php");?>
<?php
/* ----------------------------------------------*/
function CrearArchivo($filename){
    global $msgstr;
    if (file_exists($filename)) {
        echo $msgstr["fileexists"].": '".$filename."'<br>";
        return(0);
    }
	if (!$handle = fopen($filename, 'w')) {
        echo "<span style='color:red'>".$msgstr["copenfile"]." '".$filename."'</span><br>";
        return -1;
   	}
    // Write the content to our opened file.
    if (fwrite($handle, '') === FALSE) {
        echo "<span style='color:red'>".$msgstr["cwritefile"]." '".$filename."'</span><br>";
        return -1;
    }
    fclose($handle);
    echo "<b>".$msgstr["createdemptyfile"]."</b> '".$filename."'<br>";
    return 0;
}
?>