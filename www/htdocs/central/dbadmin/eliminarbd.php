<?php
/* Modifications
20210323 fho4abcd Replaced helper code fragment by included file
20210324 fho4abcd Reprogrammed, decent error processing, improved feedback and backbutton
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
include ("../common/inc_file-delete.php");

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
echo "<form name=continuar action=eliminarbd.php method=post>\n";
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
        <?php echo $msgstr["mnt_ebd"]." " .$msgstr["database"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
<?php 
// Show 'back' button, This depends on the stage: if the deletion is done go back to home.
$backtourl=$backtoscript."?base=".$arrHttp["base"];
if ($arrHttp["confirmcount"]>=2) $backtourl="/central/common/inicio.php";
echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
    <span><strong>".$msgstr["regresar"]."</strong></span></a>";
?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="menu_mantenimiento.html";
include  "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
// Set up and perform necessay checks
$errors=0;
$databasefolder =$db_path.$arrHttp["base"];
$parfullname    =$db_path."par/".$arrHttp["base"].".par";
$deffullname    =$db_path."par/".strtoupper($arrHttp["base"]).".def";
$fullbasesdotdat=$db_path."bases.dat";

//Check that the database is not protected. This is a real error
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
// Deletion may be necessary after some corruption:
// Errors may occur and do not stop the proces
// Get info of the database
include "../common/inc_get-dbinfo.php";
include "../common/inc_get-dblongname.php";

// Display the action to be executed
echo "<div><h4>".$msgstr["database"].": ".$arrHttp["base"]." (".$arrHttp["dblongname"].")<br>";
echo $msgstr["borrartodo"]."<br>";
echo $msgstr["delete"]." ". $arrHttp["MAXMFN"]." ".$msgstr["registros"]. "</h4></div>";

//Ask for confirmation (twice)
if ($arrHttp["confirmcount"]<2) {
    if ($arrHttp["confirmcount"]==0) {
        echo "<div><h4><font color=red>".$msgstr["mnt_ebd"]." ?</font></h4></div>";
    } else {
        echo "<div><h1><font color=red>".$msgstr["areysure"]."</font></h1></div>";
    }
	Confirmar();
	die;
}
// This part will be excuted the second invocation. 
// Messages indicate what the program will do
$errors=0;

// Remove the database folder
$errors+=DeleteTree($databasefolder);
// Remove the .def file
$errors+=DeleteFile($deffullname,1);
// Remove the .par file as last
$errors+=DeleteFile($parfullname,1);

// Read bases.dat and remove the database entry
$fp=file($fullbasesdotdat);
foreach ($fp as $value){
    $value=trim($value);
    if ($value!=""){
        $linearr=explode('|',$value);
        $curbase=$linearr[0];
        if ($curbase!=$arrHttp["base"]) $contenido[]=$value."\n";
    }
}
// Write the new contents to bases.dat
$retput=@file_put_contents($fullbasesdotdat,$contenido);
$res=$OK;
if ($retput===false) {
    $errors++;
    $contents_error= error_get_last();
    $res=$NOT_OK." : ".$contents_error["message"];
}
echo $msgstr["update"].": ".$msgstr["dblist"]." ".$res."<br>";

echo "<h4>".$msgstr["end_process"].": ".$errors." error(s).</h4>";
?>
<a href="/central/dbadmin/profile_edit.php">Suggestion: <?php echo $msgstr["profiles"] ?> </a>
</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>\n";
?>