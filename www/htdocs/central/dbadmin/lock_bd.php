<?php
/* Modifications
20210413 fho4abcd Redesign. Improved:helper fragment+breadcrumb+feedback+simplified coding,...
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");

$backtoscript="../dbadmin/menu_mantenimiento.php";
$backtourl=$backtoscript."?base=".$arrHttp["base"];
$base=$arrHttp["base"];
$protectfilename=$db_path.$base."/protect_status.def";
if (file_exists($protectfilename)) {
    $protectstatus=1;
    $protectstatusmsg="Protected";
} else {
    $protectstatus=0;
    $protectstatusmsg="NOT protected";
}
echo "<body>";
// Show institutional info
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["maintenance"]." &rarr; ".$msgstr["protect_db"];?>
	</div>
	<div class="actions">
        <a href='<?php echo $backtourl?>'  class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
	<div class="formContent">
    <div align=center>
        <h3><?php echo $msgstr["protect_db"]?></h3>
    </div>
<?php
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"])){
	echo "<h4>".$msgstr["invalidright"]."</h4>";die;
}
if (!isset($arrHttp["action"])){
    ?>
    <div align=center>
        <b><?php echo $msgstr["bd"].": ".$arrHttp["base"]." &rarr; ".$protectstatusmsg ?></b><br><br>
    </div>
    <form name=protect method=post>
        <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
        <table align=center>
            <?php if ($protectstatus==0) {?>
            <tr><td><input type=checkbox name=action value=protect_db></td>
                <td><?php echo $msgstr["protect_db"]?></td>
            </tr>
            <?php } else { ?>
            <tr><td><input type=checkbox name=action value=unprotect_db></td>
                <td><?php echo $msgstr["unprotect_db"]?></td>
            </tr>
            <?php } ?>
            <tr><td></td><td><input type=submit  value=<?php echo $msgstr["procesar"]?> ></td></tr>
        </table>
    </form>
    </div>
</div>
<?php
}else{
    $execstatus="??";$action="none";
    if (isset($_POST['action'])) $action=$_POST['action'];
    if ($action=="protect_db") {
        if (!$handle = fopen($protectfilename, 'w')) {
            $execstatus=" FAILED!!! &rarr; Cannot open file ".$protectfilename;
        }        
        if ( $handle and fwrite($handle, "PROTECTED") === FALSE) {
            $execstatus=" FAILED!!! &rarr; Cannot write to file ".$protectfilename;
        }
        if ( $handle and $execstatus=="??") {
            fclose($handle);
            $execstatus= " OK";
        }
    } else if ($action=="unprotect_db") {
        $execstatus= " OK";
        if (file_exists($protectfilename)){
            if (!unlink($protectfilename)) {
                $execstatus=" FAILED!!!";
            }
        }
    }
    if (file_exists($protectfilename)) {
        $protectstatusmsg="Protected";
    } else {
        $protectstatusmsg="NOT protected";
    }
?>
    <div align=center>
        <h4><?php echo $arrHttp["base"].": ".$msgstr[$arrHttp["action"]]." &rarr; ".$execstatus?></h4>
         <b><?php echo $msgstr["bd"].": ".$arrHttp["base"]." &rarr; ".$protectstatusmsg ?></b>
    </div>
</div>
</div>
<?php
}
include("../common/footer.php");
?>
</body></html>

