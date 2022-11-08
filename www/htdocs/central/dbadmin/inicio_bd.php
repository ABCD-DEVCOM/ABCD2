<?php
/* Modifications
20210317 fho4abcd Created from dbadmin/administrar_ex.php to avoid confusion with other files with that name
20210317 fho4abcd Replaced helper code fragment by included file, removed some unused code
20210324 fho4abcd Reprogrammed, improved feedback
20211215 fho4abcd Backbutton by included file
20220713 fho4abcd Use $actparfolder as location for .par files
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
$backtoscript="menu_mantenimiento.php"; // The default return script
$inframe=1;                             // The default runs in a frame
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))      $inframe=$arrHttp["inframe"];

//====================== Functions =================
// Function to show a "confirm" and "cancel" button. Actions by corresponding script
function Confirmar(){
    global $msgstr;
    ?>
    <br><br>
	<input type=button name=continuar value="<?php echo $msgstr["procesar"]?>" onclick=Confirmar()>
	&nbsp; &nbsp;
    <input type=button name=cancelar value="<?php echo $msgstr["cancelar"] ?>" onclick=Regresar()>
	</div></div></body></html>
    <?php
}
//----------------------- End functions --------------------------------------------------

include("../common/header.php");
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
// Create a form for submission.
echo "<form name=continuar action=inicio_bd.php method=post>\n";
foreach ($_REQUEST as $var=>$value){
    // some values may contain quotes or other "non-standard" values
    $value=htmlspecialchars($value);
	echo "<input type=hidden name=$var value=\"$value\">\n";
}
if (!isset($arrHttp["confirmcount"])){ 
    $arrHttp["confirmcount"]=0;
    echo "<input type=hidden name=confirmcount value=\"0\">\n";
}
echo "</form>\n";

// If outside a frame: show institutional info
if ($inframe!="1") include "../common/institutional_info.php";
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["maintenance"]." " .$msgstr["database"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
    <div class="formContent">
<?php
// First some initial checks
// Not all very likely to occur, but better safe than sorry
$errors=0;
$databasefolder=$db_path.$arrHttp["base"];
$parfullname   =$db_path.$actparfolder.$arrHttp["base"].".par";
if (!file_exists($databasefolder)){
    echo "<h3><font color=red>".$databasefolder.": ".$msgstr["folderne"]."</font></h3>";
    $errors++;
}
if (!file_exists($parfullname)){
    echo "<h3><font color=red>".$parfullname.": ".$msgstr["ne"]."</font></h3>";
    $errors++;
}
//Check that the database is not protected
if (file_exists($db_path.$arrHttp["base"]."/protect_status.def")){
    $fp=file($db_path.$arrHttp["base"]."/protect_status.def");
    foreach ($fp as $value){
        $value=trim($value);
        if ($value=="PROTECTED"){
            echo "<div><font color=red>".$msgstr["protect_active"]."</font></div>";
            $errors++;
        }
    }
}

if ($errors>0) {
	echo "</div></div>";
	include("../common/footer.php");
	echo "</body></html>";
	die;
}
// Display information about the status
echo "<table>";
// Display the executable that will be used
echo "<tr><td>".$msgstr["procesar"].":<td><td>".$wxisUrl."</td></tr></table><br>";

// Get info of the database
include "../common/inc_get-dbinfo.php";
include "../common/inc_get-dblongname.php";

// Display the action to be executed
echo "<div><h4>".$msgstr["mnt_ibd"]." ".$arrHttp["base"]." (".$arrHttp["dblongname"].")<br>";
echo $msgstr["delete"]." ". $arrHttp["MAXMFN"]." ".$msgstr["registros"]. "</h4></div>";

//Ask for confirmation (twice)
if ($arrHttp["confirmcount"]<2) {
    if ($arrHttp["confirmcount"]==0) {
        echo "<div><h4><font color=red>".$msgstr["elregistros"]." ?</font></h4></div>";
    } else {
        echo "<div><h1><font color=red>".$msgstr["areysure"]."</font></h1></div>";
   }
	Confirmar();
	die;
}
// This part will be excuted the second invocation. 

$query = "&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["cipar"]."&Opcion=inicializar";
$IsisScript=$xWxis."administrar.xis";
// the actual initialisation
include("../common/wxis_llamar.php");
foreach ($contenido as $linea){
    if ($linea=="OK"){
        echo "<h4>".$msgstr["init"]." ".$arrHttp["base"]." (".$arrHttp["dblongname"].")</h4>";
    } else {
        echo "<h4><font color=red>".$msgstr["mnt_ibd"]." ".$arrHttp["base"]." FAILED</font></h4>";
    }
}
?>
</div></div>
<?php
	include("../common/footer.php");
?>
