<?php
/*
20210921 fho4abcd Complete rewrite: improve/extend functionality, all strings translatable.
20211110 fho4abcd Ensure dr_path values for UNICODE and CISIS
20211112 fho4abcd remove debug, copy extra files, do not update content of stw,iso,tab, do not create command files
*/
/*
** Copies a database to a new folder
** Main parameters set by caller via URL:
** - 'nombre'        = New database foldername (short name)
** - 'desc'          = New database description (long name)
** - 'base_sel'      = Old database to be copied
** - 'UNICODE'       = Value of UNICODE for the new database (may be different from original)
** - 'CISIS_VERSION' = Value of CISIS_VERSION for the new database (may be different from original)
**
** This function copies all relevant configuration files recursively
** Filenames are converted if matching <base_sel>.*
** Strings in copied files are converted if applicable (See function UpdateContent below)
** References to isisuc/isisac are filled according to value of UNICODE
** The data content is NOT copied. An empty database is created
** This function does NOT set any protection: left to default PHP and configuration of the webserver user
*/
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/soporte.php");

include("../common/header.php");
$backtoscript="../common/inicio.php?reinicio=s"; // The default return script
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
$base_new   = $arrHttp['nombre'];
$base_new   = strtolower($base_new);
$descripcion= $arrHttp['desc'];
$base_old   = $arrHttp['base_sel'];

$arrHttp['base']    =$base_new;
$arrHttp['nombre']  =$base_new;
if (!isset($arrHttp["checkdup"])) $arrHttp["checkdup"]=0;

$isisac="isisac.tab";
$isisuc="isisuc.tab";
if ($arrHttp["UNICODE"]==1){
    $isisac="isisactab_utf8.tab";
    $isisuc="isisuctab_utf8.tab";
}

?>
<body>
<script>
function Confirmar(){
	document.continuar.checkdup.value=1;
	document.continuar.submit()
}
function Regresar(){
	document.continuar.action='menu_creardb.php'
	document.continuar.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["copydb"].": " . $base_new. ". ".$msgstr["createfrom"].": ".$base_old?>
    </div>
    <div class="actions">
<?php 
// Show 'back' button,
$backtourl=$backtoscript."?base=".$arrHttp["base"];
echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
echo "<img src=\"../../assets/images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
    <span><strong>".$msgstr["regresar"]."</strong></span></a>";
?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include("../common/inc_div-helper.php");
?>
<div class="middle form">
<div class="formContent">
<form name=continuar action=crearbd_ex_copy.php method=post>
<?php
foreach ($_REQUEST as $var=>$value){
    // some values may contain quotes or other "non-standard" values
    $value=htmlspecialchars($value);
	echo "<input type=hidden name=$var value=\"$value\">\n";
}
?>
<input type=hidden name=checkdup>
</form>
<?php
if (!file_exists($db_path.$base_old)) {
    // In case of corrupt bases.dat
    echo "<p style='color:red'>".$msgstr["fatal"].": ".$msgstr["nosrcfolder"]." (".$base_old.")";
    die;
}
if ($arrHttp["checkdup"]==0){
    $handle = opendir($db_path);
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && !is_file($db_path."/".$file) && $file==$base_new) {
            ?>
            <div align=center><table>
            <tr><td colspan=2 style="color:red;font-size:150%">
                <?php echo $msgstr["copyfolder"]." '".$base_new."' ".$msgstr["doesexist"]." !!"?></td></tr>
            <tr>
                <td>
                    <input type=button name=continuar value="<?php echo $msgstr["overwritefolder"]?>" onclick=Confirmar()>
                </td>
                <td>
                    <input type=button name=cancelar value="<?php echo $msgstr["cancelar"] ?>" onclick=Regresar()>
                </td>
            </tr></table></div>
            <?php
            $arrHttp["checkdup"]=0;
            break;
        } else {
            $arrHttp["checkdup"]=1;
        }
    }
    closedir($handle);
}
if ($arrHttp["checkdup"]==1 ) {
    if (!file_exists($db_path.$base_new)){
        if (mkdir($db_path.$base_new)==false) {
            echo "<p style='color:red'>".$msgstr["fatal"].": ".$msgstr["foldernotc"]." (".$base_new.")";
            die;
        }
        echo "<b>".$msgstr["createdfolder"]."</b> ".$db_path.$base_new."<br>";
    }
    // Update bases.dat with new database
    $filename= $db_path."bases.dat";
    $fp=file($db_path."bases.dat");
    $contenido="";
    foreach ($fp as $value){
        $ixpos=strpos($value,"|");
        $comp=trim(substr($value,0,$ixpos));
        if ($comp!=$base_new) $contenido.=$value;
    }
    $contenido=trim($contenido);
    $contenido.="\n".$base_new."|".$descripcion;
    CrearArchivo($filename,$contenido);

    // Copy & update par/[dbn].par
    $oldfile=$db_path."par/$base_old.par";
    $newfile=$db_path."par/$base_new.par";
    $fp=file($oldfile);
    $contenido="";
    $tokens=array();
    $issetISISAC=false;
    $issetISISUC=false;
    foreach ($fp as $value){
        $tokens=explode('=',$value);
        if (isset($tokens[0]) && trim($tokens[0])=="isisac.tab") {
            $contenido.="isisac.tab=%path_database%".$isisac.PHP_EOL;
            $issetISISAC=true;
        } else if (isset($tokens[0]) && trim($tokens[0])=="isisuc.tab") {
            $contenido.="isisuc.tab=%path_database%".$isisuc.PHP_EOL;
            $issetISISUC=true;
        } else {
            $contenido.=str_replace($base_old,"$base_new",$value);
        }
    }
    if (!$issetISISAC) $contenido.="isisac.tab=%path_database%".$isisac.PHP_EOL;
    if (!$issetISISUC) $contenido.="isisuc.tab=%path_database%".$isisuc.PHP_EOL;
    CrearArchivo($newfile,$contenido);

    // Copy & update dr_path.def or create a new with default settings
    $oldfile=$db_path."$base_old"."/dr_path.def";
    $newfile=$db_path."$base_new"."/dr_path.def";
    $contenido="";
    $issetCOLL=false;
    if ( file_exists($oldfile) ) {
        $fp=file($oldfile);
        $tokens=array();
        $issetCISIS=false;
        $issetUNI=false;
        foreach ($fp as $value){
            $tokens=explode('=',$value);
            if (isset($tokens[0]) && trim($tokens[0])=="CISIS_VERSION") {
                $contenido.="CISIS_VERSION=".$arrHttp["CISIS_VERSION"].PHP_EOL;
                $issetCISIS=true;
            } else if (isset($tokens[0]) && trim($tokens[0])=="UNICODE") {
                $contenido.="UNICODE=".$arrHttp["UNICODE"].PHP_EOL;
                $issetUNI=true;
            } else if (isset($tokens[0]) && trim($tokens[0])=="COLLECTION") {
                $issetCOLL=true;
                $contenido.=str_replace($base_old,"$base_new",$value).PHP_EOL;
                $colfolderfull=str_replace("%path_database%",$db_path."/",$tokens[1]);
                $colfolderfull=str_replace($base_old,"$base_new",$colfolderfull);
                $colfolderfull=trim($colfolderfull);
                if ( substr($colfolderfull,-1)=="/") $colfolderfull=substr($colfolderfull,0,-1);
            } else {
                $contenido.=str_replace($base_old,"$base_new",$value).PHP_EOL;
            }
        }
        if (!$issetCISIS)   $contenido.="CISIS_VERSION=".$arrHttp["CISIS_VERSION"].PHP_EOL;
        if (!$issetUNI)     $contenido.="UNICODE=".$arrHttp["UNICODE"].PHP_EOL;
    } else {
        $contenido.="UNICODE=".$arrHttp["UNICODE"].PHP_EOL;
        $contenido.="CISIS_VERSION=".$arrHttp["CISIS_VERSION"].PHP_EOL;
        $contenido.="DIRTREE_EXT=*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,".PHP_EOL;
    }
    CrearArchivo($newfile,$contenido);
    if ( $issetCOLL AND !file_exists($colfolderfull)) {
        mkdir($colfolderfull);
        echo "<b>".$msgstr["createdfolder"]."</b> ".$colfolderfull."<br>";
    }

    // Copy .tab files. Do not change the name
    $olddata=$db_path."$base_old";
    $handle=opendir($olddata);
    while (false !== ($tstfile = readdir($handle))) {
        $ext=substr(strrchr($tstfile, "."), 1);
        if ( $ext!== false && ($ext=="tab")) {
            $file   =$db_path.$base_old."/".$tstfile;
            $newfile=$db_path.$base_new."/".$tstfile;
            CopyFile($file, $newfile);
        }
    }
    echo "<br>";
    // Copy ayudas folder
    $file = $db_path."$base_old"."/ayudas";
    $newfile = $db_path."$base_new"."/ayudas";
    CopyDir($file, $newfile);

    // Copy cnv folder
    $file = $db_path."$base_old"."/cnv";
    $newfile = $db_path."$base_new"."/cnv";
    CopyDir($file, $newfile);

    // Copy def folder
    $file = $db_path."$base_old"."/def";
    $newfile = $db_path."$base_new"."/def";
    CopyDir($file, $newfile);

    // Copy loans folder
    $file = $db_path."$base_old"."/loans";
    $newfile = $db_path."$base_new"."/loans";
    CopyDir($file, $newfile);

    // Copy pfts folder
    $file = $db_path."$base_old"."/pfts";
    $newfile = $db_path."$base_new"."/pfts";
    CopyDir($file, $newfile);

    // Add items to data folder
    echo "<br>";
    $newfile=$db_path."$base_new"."/data";
    if (!file_exists($newfile)) {
        mkdir($newfile);
        echo $msgstr["created"]." ".$newfile."<br>";
    }

    // Copy all fst's in the data folder. At least one has the database name
    // Copy also iso files (possible load files for a gizmo)
    // Copy also stw files
    $olddata=$db_path."$base_old"."/data";
    $handle=opendir($olddata);
    while (false !== ($tstfile = readdir($handle))) {
        $ext=substr(strrchr($tstfile, "."), 1);
        if ( $ext!== false && ($ext=="fst" OR $ext=="stw" OR $ext=="iso")) {
            $file   =$db_path.$base_old."/data/".$tstfile;
            $newname=str_replace($base_old,$base_new,$tstfile);
            $newfile=$db_path.$base_new."/data/".$newname;
            CopyFile($file, $newfile);
        }
    }

    //  Do NOT Create fullinv.sh or fullinv.dat in the data folder: The command is too complicated. See fullinv.php

    // Create control_number.cn in the data folder
    $contenido=0;
    $filename=$db_path."$base_new"."/data/control_number.cn";
    CrearArchivo($filename,$contenido);

    // Create the database with no content

    // this one does not work
    // $IsisScript=$xWxis."inicializar_bd.xis";
    // $query = "&base=".$base_new."&cipar=$db_path"."par/".$base_new.".par";
    echo "<br>";
    $query = "&base=".$base_new."&cipar=$db_path"."par/".$base_new.".par"."&Opcion=inicializar";
    $IsisScript=$xWxis."administrar.xis";
    include("../common/wxis_llamar.php");
    foreach ($contenido as $linea){
        if ($linea=="OK"){
            echo "<b>".$msgstr["init"]." ".$base_new." (".$arrHttp["desc"].")</b> ,";
            echo "CISIS_VERSION=".$arrHttp["CISIS_VERSION"].", ";
            echo "UNICODE=".$arrHttp["UNICODE"]."<br><br>";
            echo "<b>".$msgstr["processok"]."<br>";
        } else { echo $linea;
            echo "<p style='color:red;font-size:150%'><b>".$msgstr["mnt_ibd"]." ".$base_new." FAILED</b></p>";
            break;
        }
    }
}
?>
</div>
</div>
<?php
include("../common/footer.php");

/* ===================== Functions ==============*/
function CopyDir($srcdir, $dstdir) {
global $arrHttp, $msgstr;
    if (!file_exists($srcdir)) return;
    if (!is_dir($dstdir)){
        mkdir($dstdir);
        echo "<b>".$msgstr["createdfolder"]."</b> ".$dstdir."<br>";
    }
    if ($curdir = opendir($srcdir)) {
        while($file = readdir($curdir)) {
            if($file != '.' && $file != '..') {
                $srcfile = $srcdir . "/" . $file;
                // Replace filenames only if an exact match with source
                $newname=$file;
                if ( substr($file, 0, strlen($arrHttp["base_sel"].".")) === $arrHttp["base_sel"].".") {
                    $newname=str_replace($arrHttp["base_sel"],$arrHttp["nombre"],$file);
                }
                $dstfile = $dstdir . "/" . $newname;
                if(is_file($srcfile)) {
                    CopyFile($srcfile,$dstfile);
                }
                else if(is_dir($srcfile)) {
                    CopyDir($srcfile, $dstfile);
                }
            }
        }
        closedir($curdir);
    }
    return;
}

/* ----------------------------------------------*/
function CrearArchivo($filename,$contenido){
    global $msgstr;
    $isupdate=0;
    if (file_exists($filename)) $isupdate=1;
	if (!$handle = fopen($filename, 'w')) {
        echo "<span style='color:red'>".$msgstr["copenfile"]." '".$filename."'</span><br>";
        return -1;
   	}
    // Write the content to our opened file.
    if (fwrite($handle, $contenido) === FALSE) {
        echo "<span style='color:red'>".$msgstr["cwritefile"]." '".$filename."'</span><br>";
        return -1;
    }
    fclose($handle);
    if ($isupdate==0) {
        echo "<b>".$msgstr["createdfile"]."</b> '".$filename."'<br>";
    } else {
        echo "<b>".$msgstr["updatedfile"]."</b> '".$filename."'<br>";
    }
    return 0;
}

/* ----------------------------------------------*/
function CopyFile($srcfile,$dstfile){
    global $msgstr;
    echo $msgstr["copyfrom"]." '".$srcfile."' &rarr; '".$dstfile."' ... ";
    if (copy($srcfile, $dstfile)) {
        echo $msgstr["isok"]."<br>\n";
        touch($dstfile, filemtime($srcfile));
        UpdateContent($dstfile);
    } else {
        echo "<br><span style='color:red'>".$msgstr["error"].": ". $srcfile." ".$msgstr["isnotcopied"]."</span><br>\n";
    }
}
/* ----------------------------------------------*/
/* Update the contents of a copied file
** The string for the old base is replaced by the string for the new base
** Note that the string may occur in .dat and .wks and .pft files
** As all files are inspected here the location of the string is also considered
*/
function UpdateContent($dstfile){
    global $msgstr,$base_old,$base_new;
    // No updates in help files (too tricky and not functional)
    $ext = pathinfo($dstfile, PATHINFO_EXTENSION);
    if ( isset($ext) && ($ext=="html"  or $ext=="htm") ) return;
    // No updates in iso,stw and tab files
    if ( isset($ext) && ($ext=="iso"  or $ext=="stw" or $ext=="tab") ) return;
    
    $fileupdated=false;
    $content="";
    $fp=file($dstfile);
    $tokens=array();
    foreach ($fp as $value){
        $update=false;
        $tokens=explode('|',$value);
        $linecontent=$value;
        // in pfts we find "../base_old/.."
        if ( strpos($linecontent,"/".$base_old."/") !==false ) {
            $fileupdated=true;$update=true;
            $linecontent=str_replace("/".$base_old."/","/".$base_new."/",$linecontent);
        }
        // in pfts we find "..['base_old'].."
        if ( strpos($linecontent,"['".$base_old."']") !==false ) {
            $fileupdated=true;$update=true;
            $linecontent=str_replace("['".$base_old."']","['".$base_new."']",$linecontent);
        }
        // in fmt and fdt we find "...|base_old|..."
        if ( strpos($linecontent,"|".$base_old."|") !==false ) {
            $fileupdated=true;$update=true;
            $linecontent=str_replace("|".$base_old."|","|".$base_new."|",$linecontent);
        }
        // in .wks and .dat we find "base_old|..." at the beginning of the line
        if ( isset($tokens[0]) && trim($tokens[0])==$base_old) {
            $fileupdated=true;$update=true;
            $linecontent=str_replace($base_old,$base_new,$linecontent);
        }
        // in pfts we find "..cipar=base_old.par..."
        if ( strpos($linecontent,"cipar=".$base_old.".par") !==false ) {
            $fileupdated=true;$update=true;
            $linecontent=str_replace("cipar=".$base_old.".par","cipar=".$base_new.".par",$linecontent);
        }
        if ( $update ) {
            $content.=$linecontent;
        } else {
            $content.=$value;
        }
    }
    if ( $fileupdated ) {
        CrearArchivo($dstfile,$content);
    }
    return;
}
?>