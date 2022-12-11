<?php
/*
** The data loaded in the form is sent to this file.
** This script has functionality to validate, process and store the data in the ODDS database
**
** Modifications
** 0221210 fho4abcd Full rewrite (use msgstr,....)
*/
session_start();
//The check for logged in is not done here (also no timeout etc)

include("../central/common/get_post.php");
$base="odds";//default base if none set by caller
if (isset($arrHttp["base"])) {
    $base=$arrHttp["base"];
} else {
    $arrHttp["base"]=$base;
}

include("../central/config.php");
$lang=$_SESSION["lang"];
$module_odds="Y";// influences language dropdown and exit button

include("../central/lang/admin.php");
include("../central/lang/odds.php");// note that the labels in this file may be used in other translations
include("../central/common/header.php");
?>
<body>
<?php
include("../central/common/institutional_info.php");
$arrHttp["encabezado"]="";
//}
?>
<link href="/assets/css/odds.css" rel="stylesheet" type="text/css">
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["odds_form_st"]?>
    </div>
    <div class="actions">
        <?php
        $backtoscript="form_odds.php";
        include "../central/common/inc_back.php";
        ?>
    </div>
        <div class="spacer">&#160;</div>
    </div>
<?php
include "../central/common/inc_div-helper.php";

// venimos del formulario?
$reload = true;
if (!isset($_SESSION["verifica"])) {
    $reload = false;
    $_SESSION["verifica"] = true; 
} 
// build back link for the user data
$parameters  = "?base=".$base;
$parameters .= isset($arrHttp['referer']) ? "&referer=".trim($arrHttp['referer']) : "";
$parameters .= isset($arrHttp['tag630']) ? "&id=".trim($arrHttp['tag630']) : "";
$parameters .= isset($arrHttp['tag510']) ? "&name=".trim($arrHttp['tag510']) : "";
$parameters .= isset($arrHttp['tag528']) ? "&email=".trim($arrHttp['tag528']) : "";
$parameters .= isset($arrHttp['tag512']) ? "&phone=".trim($arrHttp['tag512']) : "";
$parameters .= isset($arrHttp['tag520']) ? "&category=".trim($arrHttp['tag520']) : "";

// get configs
$cipar = $base.".par";
$mfn = "new";
/**/
$cn = get_cn($base, $db_path);
if ($cn == "" or $cn == false){
    echo "<div style='color:red'>&nbsp;&nbsp;".$msgstr["odds_nocontrolnr"]."</div>";
} 

//other in source field	replaces the dropdown value
if (substr( $_POST["tag900"], 0, 7  )  == "others_") {
    if (isset($_POST["tag900_other"])) {
        if (trim($_POST["tag900_other"]) != "") {
            $_POST["tag900"] = trim($_POST["tag900_other"]);
        }
    }
}
unset($_POST["tag900_other"]);

//other in category field	replaces the dropdown value
if ($_POST["tag520"] == "XX") {
    if (isset($_POST["tag520_other"])) {
        if (trim($_POST["tag520_other"]) != "") {
            $_POST["tag520"] = trim($_POST["tag520_other"]);
        }
    }
}
unset($_POST["tag520_other"]);

$tags = _flattenPOST($_POST, $cn);
if ($tags == "") {
    echo "<div style='color:red'>"."Program error:function _flattenPOST did not return any tag"."</div>";
    die;
}

$query = "&base=".$base ."&cipar=".$db_path.$actparfolder.$cipar."&Mfn=New&Opcion=crear&ValorCapturado=";
$query =  $query.$tags;
$IsisScript=$xWxis."actualizar.xis";
$url = $wxisUrl."?IsisScript=".$IsisScript.$query."&cttype=Y&path_db=".$db_path;

include("../central/common/wxis_llamar.php");
// The created MFN is in the returned content of he database action
if (isset($contenido[1]) && substr($contenido[1],0,4)=="MFN:") {
    echo "<div style='color:blue'>&nbsp;&nbsp;".$msgstr['odds_cre_rec1']." <b>".$contenido[1]." </b>";
    echo $msgstr['odds_cre_rec2']." ".$base."</div>";
    $message = $msgstr['notice_success'];
} else {
    $message = $msgstr['notice_error']."<hr>";
}
$message .= "<br/><br/><a href='form_odds.php".$parameters."'>".$msgstr['notice_back']."</a><br><br>";
?>

<div class="middle homepage">
    <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>
        <div style="display: block; background-image: url(odds_title_back.png); height: 32px; width: 760px; color: #ffffff; font-size:150%; font-weight: bold;  padding-left: 5px;font-family: Verdana, Arial, Helvetica, sans-serif; margin: 0 0 5px; 0 ">
            <?php echo $msgstr['title'];  ?>
        </div>
        <div class="boxContent toolSection ">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tbody>
  <tr>
    <td valign="top" class="cuerpoCuad">&nbsp;</td>
    <td colspan="2" valign="top" class="cuerpoText1">      
    <table width="780" border="0" cellspacing="0" cellpadding="1" bordercolor="#cccccc" class="textNove">
      <tbody>
        <tr>
            <td height="12">
            <!-- SUBTITULO -->
            <?php
                echo $message;
            ?>
            </td>
        </tr>
        </tbody>
    </table>
    </td>
  </tr>
  </tbody>
</table>

</div>
<div class="spacer">&nbsp;</div>
<div class="boxBottom">
<div class="bbLeft">&#160;</div>
<div class="bbRight">&#160;</div>
</div>
</div>
</div>
<?php
include("../central/common/footer.php");


/********************************************************************/
function _flattenPOST($post, $cn) {
    $ValorCapturado = "";
    $post["tag100"] = date("Ymd");
    $processed_tags = array();
    foreach ($post as $key => $line) {
        if (substr($key, 0, 3) == "tag") {
            $key=trim(substr($key,3));
            $lin=stripslashes($line);
            if (strlen($key)==1) $key="000".$key;
            if (strlen($key)==2) $key="00".$key;
            if (strlen($key)==3) $key="0".$key;

            // repetibles
            if (isset($processed_tags[$key])) {
                $new_line = $processed_tags[$key] . "\n" .  $line;
                $processed_tags[$key] = $new_line;
            } else {
                $processed_tags[$key] = $line;
            }
        }
    }
    // cn en v001
    $processed_tags['0001'] = $cn;

    // tipo de literatura (v005)
    if ($processed_tags['0006'] == 'as') {
        $processed_tags['0005'] = "S";
    } else if ($processed_tags['0006'] == 'am' || $processed_tags['0006'] == 'amc' ) {
        $processed_tags['0005'] = "M";
    } else if ($processed_tags['0006'] == 'at') {
        $processed_tags['0005'] = "T";
    } else if ($processed_tags['0006'] == 'al' || $processed_tags['0006'] == 'ad' || $processed_tags['0006'] == 'ar' || $processed_tags['0006'] == 'cj' || $processed_tags['0006'] == 'aj') {
        $processed_tags['0005'] = "L";
    }

    foreach ($processed_tags as $key => $line) {
        $value = explode("\n", $line);
        foreach ($value as $v) {
            $ValorCapturado.=urlencode('<').$key.urlencode('>').urlencode(trim($v)).urlencode('</').$key.urlencode('>');
        }
    }
    return $ValorCapturado;
}
// se determina el número siguiente del campo autoincremente
function get_cn($base, $db_path) {
    $cn="";
    $archivo=$db_path.$base."/data/control_number.cn";
    if (!file_exists($archivo)){
        $cn=false;
        return;
    }
    $perms=fileperms($archivo);
        if (is_writable($archivo)){
        //se protege el archivo con el número secuencial
        chmod($archivo,0555);
        // se lee el último número asignado y se le agrega 1
        $fp=file($archivo);
        $cn=implode("",$fp);
        $cn=$cn+1;
        // se remueve el archivo .bak y se renombre el archivo .cn a .bak
        if (file_exists($db_path.$base."/data/control_number.bak")) {
            unlink($db_path.$base."/data/control_number.bak");
        }
        $res=rename($archivo,$db_path.$base."/data/control_number.bak");
        chmod($db_path.$base."/data/control_number.bak",$perms);
        $fp=fopen($archivo,"w");
        fwrite($fp,$cn);
        fclose($fp);
        chmod($archivo,$perms);
        if (isset($max_cn_length)) {
            $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
        }
    }else{
        $cn=false;
    }
    return $cn;
}
