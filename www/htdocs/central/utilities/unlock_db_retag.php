<?php
/* Modifications
20210412 fho4abcd Rewrite(helper code fragment,integrate confirm, show status, correct execution&feedback,..)
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
?>
<body>
<script>
function Confirmar(){
	document.continuar.confirmcount.value++;
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
        <?php echo $msgstr["maintenance"]." &rarr; ".$msgstr["mnt_unlock"];?>
	</div>
	<div class="actions">
        <?php
        $backtourl=$backtoscript."?base=".$arrHttp["base"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
        ?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
	<div class="formContent">
<?php
// Ask for confirmation
if (!isset($arrHttp["confirmcount"])) {
    echo "<div align=center><h3>". $msgstr["mnt_unlock"]." : ".$arrHttp["base"]." ?</h3></div>";
    include ("../common/inc_get-dbinfo.php");
    echo "<div align=center>".$msgstr["database"]." ".$msgstr["exwritelock"].
         " = ".$arrHttp["EXCLUSIVEWRITELOCK"]."</div>";
    // Create a form for submission and request confirmation
    echo "<form name=continuar action=unlock_db_retag.php method=post>\n";
    foreach ($_REQUEST as $var=>$value){
        // some values may contain quotes or other "non-standard" values
        $value=htmlspecialchars($value);
        echo "<input type=hidden name=$var value=\"$value\">\n";
        if (!isset($arrHttp["confirmcount"])){ 
            $arrHttp["confirmcount"]=0;
            echo "<input type=hidden name=confirmcount value=\"0\">\n";
        }
    }
    echo "</form>\n";
	Confirmar();
} else{
    // This part is only after confirmation
    echo "<div align=center><h3>". $msgstr["mnt_unlock"]." : ".$arrHttp["base"]."</h3></div>";
    // Create command
    $parameters= "<br>";
    $parameters.= "database: ".$bd."/data/".$base."<br>";
    $retag_path=$cisis_path."retag".$exe_ext;
    $strINV=$retag_path." ".$bd."/data/".$base." unlock 2>&1";

    // execute the command
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br></font><hr>";
        echo ("<h3>Process Result: <br>Process Finished OK</h3>");
        echo "$straux";
    } else {
        echo "<font face=courier size=2>".$parameters."<br>Command line: $strINV<br></font><hr>";
        echo ("<h3><font color='red'><br>Process NOT EXECUTED or FAILED</font></h3><hr>");
        echo "<font color='red'>".$straux."</font>";
    }
}
?>

</div></div>

<?php
include("../common/footer.php");
?>
</body></html>


