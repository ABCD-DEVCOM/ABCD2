<?php
/*
20210921 fho4abcd Complete rewrite: improve/extend functionality, all strings translatable.
20211110 fho4abcd Ensure dr_path values for UNICODE and CISIS
20211112 fho4abcd remove debug, copy extra files, do not update content of stw,iso,tab, do not create command files
20211122 fho4abcd Improve create of dbn.par: works now with actab/uctab. More files copied/renamed. Add testbutton. Sanitize html.
20211215 fho4abcd Backbutton by included file
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
** Filenames are converted if matching <base_sel>.* and _<base_sel>.*
** Strings in copied files are converted if applicable (See function UpdateContent below)
** Specials for dr_path.def:
**  - This function creates the folders for COLLECTION and ROOT if applicable
** Specials for <dbn>.par:
**  - If unicode values match the original settings of actab/uctab are preserved 
**  - If unicode values are different the keys actab and uctab are not written (with a remark).
**  - Keywords isisac.tab/isisuc.tab are treated as actab/uctab 
** The database content is NOT copied. An empty database is created
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
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
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
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include("../common/inc_div-helper.php");
?>
<div class="middle form">
<div class="formContent">
<?php
if (!file_exists($db_path.$base_old)) {
    // In case of corrupt bases.dat
    echo "<p style='color:red'>".$msgstr["fatal"].": ".$msgstr["nosrcfolder"]." (".$base_old.")";
    die;
}
if ($arrHttp["checkdup"]==0){
    ?>
    <form name=continuar action=crearbd_ex_copy.php method=post>
    <?php
    foreach ($_REQUEST as $var=>$value){
        // some values may contain quotes or other "non-standard" values
        $value=htmlspecialchars($value);
        echo "<input type=hidden name=$var value=\"$value\">\n";
    }
    ?>
    <input type=hidden name=checkdup>
    <?php
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
    ?>
    </form>
    <?php
}
if ($arrHttp["checkdup"]==1 ) {
    // Create the new base folder
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

    /*
    ** Copy & update dr_path.def or create a new with default settings
    */
    $oldfile=$db_path."$base_old"."/dr_path.def";
    $newfile=$db_path."$base_new"."/dr_path.def";
    $contenido="";
    $issetCOLL=false;
    $issetROOT=false;
    $oldunicode=0;// We assume that an unset unicode was set to 0
    if ( file_exists($oldfile) ) {
        $fp=file($oldfile);
        $tokens=array();
        $issetCISIS=false;
        $issetUNI=false;
        foreach ($fp as $value){
            $tokens=explode('=',$value);
            if (isset($tokens[0])) $tokens0=trim($tokens[0]); else $tokens0="";
            if (isset($tokens[1])) $tokens1=trim($tokens[1]); else $tokens1="";
            if ($tokens0=="CISIS_VERSION") {
                $contenido.="CISIS_VERSION=".$arrHttp["CISIS_VERSION"].PHP_EOL;
                $issetCISIS=true;
            } else if ($tokens0=="UNICODE") {
                $contenido.="UNICODE=".$arrHttp["UNICODE"].PHP_EOL;
                $issetUNI=true;
                if ($tokens1!=""){
                    $oldunicode=intval($tokens1);
                    if ( $oldunicode<0) $oldunicode=0;
                    if ( $oldunicode>1) $oldunicode=1;
                }
            } else if ($tokens0=="COLLECTION" && $tokens1!="" ) {
                $issetCOLL=true;
                $contenido.=str_replace($base_old,"$base_new",$value).PHP_EOL;
                $colfolderfull=str_replace("%path_database%",$db_path."/",$tokens1);
                $colfolderfull=str_replace($base_old,"$base_new",$colfolderfull);
                $colfolderfull=trim($colfolderfull);
                if ( substr($colfolderfull,-1)=="/") $colfolderfull=substr($colfolderfull,0,-1);
            } else if ($tokens0=="ROOT" && $tokens1!="" ) {
                $issetROOT=true;
                $contenido.=str_replace($base_old,"$base_new",$value).PHP_EOL;
                $rootfolderfull=str_replace("%path_database%",$db_path."/",$tokens1);
                $rootfolderfull=str_replace($base_old,"$base_new",$rootfolderfull);
                $rootfolderfull=trim($rootfolderfull);
                if ( substr($rootfolderfull,-1)=="/") $rootfolderfull=substr($rootfolderfull,0,-1);
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
    // Create a possible missing COLLECTION folder
    if ( $issetCOLL AND !file_exists($colfolderfull)) {
        $result=@mkdir($colfolderfull);// do not create intermediate folders (to avoid complete wrong full paths)
        if ($result===false) {
            $file_get_contents_error= error_get_last();
            echo "<span style='color:red'>".$msgstr["error_create_folder"].": ".$colfolderfull;
            echo "<br>&rarr; ".$file_get_contents_error["message"];
            echo "<br>&rarr; ".$file_get_contents_error["file"]."</span><br>";
        }
        else {
            echo "<b>".$msgstr["createdfolder"]."</b> ".$colfolderfull."<br>";
        }
    }
    // Create a possible missing ROOT folder
    if ( $issetROOT AND !file_exists($rootfolderfull)) {
        $result=@mkdir($rootfolderfull);// do not create intermediate folders (to avoid complete wrong full paths)
        if ($result===false) {
            $file_get_contents_error= error_get_last();
            echo "<span style='color:red'>".$msgstr["error_create_folder"].": ".$rootfolderfull;
            echo "<br>&rarr; ".$file_get_contents_error["message"];
            echo "<br>&rarr; ".$file_get_contents_error["file"]."</span><br>";
        }
        else {
            echo "<b>".$msgstr["createdfolder"]."</b> ".$rootfolderfull."<br>";
        }
    }

    /*
    ** Copy & update par/[dbn].par
    ** Note that existing actab/uctab entries (old or new) will not be copied
    ** They can be wrong (due to change of ansi<->utf8
    */
    $oldfile=$db_path."par/$base_old.par";
    $newfile=$db_path."par/$base_new.par";
    // The show button gives the content of the parameter file
    $showbutton=
        '<a href="../utilities/show_par_file.php?par_file='.$newfile.'" target=testshow onclick=OpenWindow()>'.$msgstr["show"].' &lt;dbn&gt;.par</a>';

    $fp=file($oldfile);
    $contenido="";
    $tokens=array();
    foreach ($fp as $value){
        $tokens=explode('=',$value);
        if (isset($tokens[0])) {
            $tokens0=trim($tokens[0]);
            unset($tokens1);
            if (isset($tokens[1]) AND trim($tokens[1])!="") $tokens1=trim($tokens[1]);
            // Save the location of the conversion tables if the unicode values match
            if ($oldunicode==$arrHttp["UNICODE"] && isset($tokens1)) {
                if ( $tokens0=="isisac.tab" OR $tokens0=="actab" ) {
                    $oldactab=str_replace($base_old,"$base_new",$tokens1);
                }
                if ( $tokens0=="isisuc.tab" OR $tokens0=="uctab" ) {
                    $olductab=str_replace($base_old,"$base_new",$tokens1);
                }
            }
            if ( $tokens0!="isisac.tab" && $tokens0!="actab" && $tokens0!="isisuc.tab" && $tokens0!="uctab") {
                $contenido.=str_replace($base_old,"$base_new",$value);
            }
        } else {
            $contenido.=str_replace($base_old,"$base_new",$value);
        }
    }
    if (isset($oldactab) ) {
        $actabline="actab=".$oldactab;
        $contenido.=$actabline.PHP_EOL;
    } 
    else {
        echo "<span style='color:blue'>".$msgstr["parmfile"].": par/".$base_new.".par ".$msgstr["parmdefault"]."<br>";
        echo "&rarr; <b>actab=</b> <br></span>";
    }
    if (isset($olductab) ) {
        $uctabline="uctab=".$olductab;
        $contenido.=$uctabline.PHP_EOL;
    } 
    else {
        echo "<span style='color:blue'>".$msgstr["parmfile"].": par/".$base_new.".par ".$msgstr["parmdefault"]."<br>";
        echo "&rarr; <b>uctab=</b> <br></span>";
    }
    CrearArchivo($newfile,$contenido);
    echo "&nbsp;&nbsp;&nbsp;&nbsp;$showbutton<br>";


    // Copy .tab files in the database topfolder. Do not change the name
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

    // Create the data folder
    echo "<br>";
    $newfile=$db_path."$base_new"."/data";
    if (!file_exists($newfile)) {
        mkdir($newfile);
        echo "<b>".$msgstr["createdfolder"]."</b> ".$newfile."<br>";
    }

    /*
    ** Copy all fst's in the data folder. At least one has the database name
    ** Copy also iso files (possible load files for a gizmo)
    ** Copy also stw files
    ** Copy also tab files (possible local actab/uctab files)
    */
    $olddata=$db_path."$base_old"."/data";
    $handle=opendir($olddata);
    while (false !== ($tstfile = readdir($handle))) {
        $ext=substr(strrchr($tstfile, "."), 1);
        if ( $ext!== false && ($ext=="fst" OR $ext=="stw" OR $ext=="iso" OR $ext=="tab")) {
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
    echo "&nbsp;&nbsp;&nbsp;&nbsp;$showbutton<br>";
}
?>
</div>
</div>
<?php
include("../common/footer.php");

/* ===================== Functions ==============*/
function CopyDir($srcdir, $dstdir) {
global $arrHttp, $msgstr,$base_new;
    if (!file_exists($srcdir)) return;
    if (!is_dir($dstdir)){
        mkdir($dstdir);
        echo "<br><b>".$msgstr["createdfolder"]."</b> ".$dstdir."<br>";
    }
    if ($curdir = opendir($srcdir)) {
        while($file = readdir($curdir)) {
            if($file != '.' && $file != '..') {
                $srcfile = $srcdir . "/" . $file;
                /*
                ** Replace filenames if an exact match with source
                ** Replace filename of validation records with pattern <any_string>_<filename>.<ext>
                */
                $newname=$file;
                $oldbase=$arrHttp["base_sel"];
                $valsubstr="_".$oldbase."."; // to catch val,beg.end
                if ( substr($file, 0, strlen($oldbase.".")) === $oldbase.".") {
                    $newname=str_replace($oldbase,$base_new,$file);
                } else if ( strlen($file)>strlen($valsubstr) ) {
                    $newname=str_replace($valsubstr,"_".$base_new.".",$file);
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
    $ext = pathinfo($dstfile, PATHINFO_EXTENSION);
    // No updates in help files (too tricky and not functional)
    if ( isset($ext) && ($ext=="html" or $ext=="htm") ) return;
    // No updates in iso,stw,tab,cfg,val,beg,end files
    if ( isset($ext) && ($ext=="iso" or $ext=="stw" or $ext=="tab") ) return;
    if ( isset($ext) && ($ext=="cfg" or $ext=="val" or $ext=="beg" or $ext=="end") ) return;

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