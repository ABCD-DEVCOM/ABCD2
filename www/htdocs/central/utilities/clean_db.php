<?php
/* Modifications
20210414 fho4abcd Rewrite(helper code fragment,add confirm, correct error checks,html code..)
20210605 fho4abcd Remove isotag1. Improves operation for standard db's.Translations
20211215 fho4abcd Backbutton by included file
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/soporte.php");
//====================== Functions =================
// Function to show a "confirm" and "cancel" button. Actions by corresponding script
function Confirmar(){
    global $msgstr;
    ?>
    <br><br><div align=center>
	<input type=button name=continuar value="<?php echo $msgstr["procesar"]?>" onclick=Confirmar()>
	&nbsp; &nbsp;
    <input type=button name=cancelar value="<?php echo $msgstr["cancelar"] ?>" onclick=Regresar()>
	</div>
    <?php
}
//----------------------- End functions --------------------------------------------------
$backtoscript="../dbadmin/menu_mantenimiento.php";
$base=$arrHttp["base"];
$bd=$db_path.$base;
$bd_mst=$bd."/data/".$base;
$bd_mst_full=$bd_mst.".mst";
$fullisoname=$db_path."wrk/".$base."_tmp.iso";
$cleancompactmsg="Clean/Compact DB";
?>
<body>
<script>
var win
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.getElementById('preloader').style.visibility='visible'
	document.continuar.submit()
}
function Regresar(){
	document.continuar.action='<?php echo $backtoscript;?>'
	document.continuar.submit()
}
</script>
<?php
// Show institutional info
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["maintenance"]." &rarr; ".$cleancompactmsg;?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
	<div class="formContent">
        <div align=center><h3><?php echo $cleancompactmsg." : ".$base;?></h3></div>
<?php
include ("../common/inc_get-dbinfo.php");
$initsize=number_format(filesize($bd_mst_full),0,',','.');
$initmsg= "<br>".$msgstr["database"].": ".$bd_mst." &rarr; ";
$initmsg.="<b><font color=darkred>".$msgstr["maxmfn"].": ".$arrHttp["MAXMFN"];
$initmsg.="&rarr; Size: ".$initsize."</font></b><br>";

// First screen: Ask for confirmation
if (!isset($arrHttp["confirmcount"])) {
    // Show the "loading" marker initially hidden and absolutely positioned in about the center
    // Create a form for submission and request confirmation
    ?>
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
    <div align=center>
        <?php echo $msgstr["currentstatus"].":<br>".$initmsg?><br>
    </div>
    <form name=continuar  method=post >
        <input type=hidden name=confirmcount value=0>
        <?php
        foreach ($_REQUEST as $var=>$value){
            // some values may contain quotes or other "non-standard" values
            $value=htmlspecialchars($value);
            echo "<input type=hidden name=$var value=\"$value\">\n";
        }
        Confirmar();
        ?>
    </form>
    <?php
} else{
    // Second screen: execute the function
    echo $initmsg;
    if (file_exists($fullisoname)) {
        unlink($fullisoname);
    }
    $strINV=$mx_path." ".$bd_mst." iso=$fullisoname  -all now 2>&1";
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    echo "<hr>".$msgstr["commandline"].": $strINV<br>";
    if($status==0) {
        echo ("<h3>".$msgstr["export_process_ok"]."</h3>");
        echo "$straux";
    } else {
        echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3>");
        echo "<font color='red'>".$straux."</font>";
    }
    if ( file_exists($fullisoname)) {
        echo $msgstr["saved"]." ".$msgstr["cnv_iso"]." $fullisoname<br><br><br>";
    }

    //importing iso
    $strINV=$mx_path." iso=$fullisoname create=".$db_path.$base."/data/".$base."  -all now 2>&1";
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    echo "<br>".$msgstr["commandline"].": $strINV<br>";
    if($status==0) {
        echo ("<h3>".$msgstr["import_process_ok"]."</h3>");
        echo "$straux";
    } else {
        echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3>");
        echo "<font color='red'>".$straux."</font>";
    }
    if (file_exists($fullisoname)) {
        if ( unlink($fullisoname)==true) echo $msgstr["eliminados"]." ".$msgstr["cnv_iso"]." $fullisoname";
    }
    $aftersize=number_format(filesize($bd_mst_full),0,',','.');
    get_dbinfo();// declared in "../common/inc_get-dbinfo.php"
    $aftermsg= "<hr>".$msgstr["database"].": ".$bd_mst." &rarr; ";
    $aftermsg.="<b><font color=darkred>".$msgstr["maxmfn"].": ".$arrHttp["MAXMFN"];
    $aftermsg.="&rarr; Size: ".$aftersize."</font></b><br>";
    echo $aftermsg;
}
?>
</div>
</div>
<?php
include("../common/footer.php");
?>
