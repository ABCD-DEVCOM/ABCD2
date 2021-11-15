<?php
/* Modifications
20211114 fho4abcd created
*/
/*
** Creates a gizmo database in the data folder of the current database
** Options for creation
** - Search for an iso file and create an gizmo from that file
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/importdoc.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$confirmcount=0;
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
$gizmoname="";
$datafilename="";
$storein=$arrHttp["base"]."/data";// variable name fixed by dirs_explorer function
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["gizmoname"]))    $gizmoname=$arrHttp["gizmoname"];
if ( isset($arrHttp["datafilename"])) $datafilename=$arrHttp["datafilename"];
if ( isset($arrHttp["storein"]))      $storein=$arrHttp["storein"];
$datafullfolder=$db_path.$storein;
$datafullfilename=$datafullfolder."/".$datafilename;

include("../common/header.php");

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function Explorar(){
	msgwin=window.open("../dataentry/dirs_explorer.php?targetForm=continuar&desde=dbcp&Opcion=explorar&base=<?php echo $arrHttp["base"]?>","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
    msgwin.focus()
}
</script>
<?php
// Show institutional info
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["create_gizmo"]?>
	</div>
	<div class="actions">
<?php
        if (!isset($arrHttp["base"]))$arrHttp["base"]="_no db set_";
        $backtourl=$backtoscript."?base=".$arrHttp["base"];
        if (isset($arrHttp["backtoscript_org"])) $backtourl.="&backtoscript=".$arrHttp["backtoscript_org"];
        echo "<a href='$backtourl'  class=\"defaultButton backButton\">";
?>
		<img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">
    <div align=center><h3><?php echo $msgstr["create_gizmo"] ?></h3></div>
<?php
/*
** The gizmo will be created in <database>/data
** The sources for the gizmo are .iso files in folder <database>/data
*/
$gizmofullfolder=$db_path.$arrHttp["base"]."/data";
// The test button gives the mx_path to the test window
$testbutton=
'<a href="mx_test.php?mx_path='.$mx_path.'" target=testshow onclick=OpenWindow()>'.$msgstr["testmx"].' MX</a>';

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the iso file -*/
?>
<form name=continuar method=post>
    <input type=hidden name=confirmcount value=0>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=backtoscript value="<?php echo $backtoscript?>">
    <table cellspacing=5 align=center>
    <tr>
        <th colspan=3>
            <?php echo $msgstr["gizmolocatefolder"];?>
        </th>
    </tr><tr>
        <td><?php echo $msgstr["datasrcfolder"]?></td>
        <td><input type=text name=storein value="<?php echo $storein?>" ></td>
        <td><a href=javascript:Explorar()><?php echo $msgstr["explore"]?></a></td>
    </tr><tr>
         <td style='text-align:right'><?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;</td>
         <td><input type=button value='<?php echo $msgstr["gizmocreate_options"];?>' onclick=Confirmar()>
    </tr>       
    </table>
</form>
<?php
}elseif ($confirmcount==1) {
?>
<form name=continuar method=post>
    <?php
    foreach ($arrHttp as $var=>$value){
        if ($var!="storein") {
        echo "<input type=hidden name=$var value=\"$value\">\n";
        }
    }
    ?>
    <table cellspacing=5 align=center>
    <tr>
        <th colspan=3 style='text-align:center'>
            <?php echo $msgstr["gizmocreate_options"];?>
        </th>
    </tr><tr>
        <td><?php echo $msgstr["datasrcfolder"]?></td>
        <td><input type=text name=storein value="<?php echo $storein?>" readonly></td>
    </tr><tr>
    </tr><tr>
        <td><?php echo $msgstr["datasrcfile"]?></td>
        <td><select name='datafilename'>
            <?php
            $handle=opendir($datafullfolder);
            while ($file = readdir($handle)) {
                if ($file != "." && $file != ".." && (strpos($file,".iso")||strpos($file,".ISO"))) {
                    echo "<option value='$file'>$file</option>";
                }
            }
            ?>
            </select></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmodbname"]?></td>
        <td><input type=text name=gizmoname value="<?php echo $gizmoname?>" title="<?php echo $msgstr["gizmonametitle"]?>"></td>
    </tr><tr>
         <td style='text-align:right'><?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;</td>
         <td><input type=button value='<?php echo $msgstr["gizmocreate"];?>' onclick=Confirmar()> 
    </tr>       
    </table>
</form>
<?php   
}elseif ($confirmcount==2) {
    // Check parameters
    if( $gizmoname=="" ) {
        echo "<span style='color:red'>".$msgstr["gizmoisempty"];
        die;
    }
    $parameters = "<br>";
    $parameters.= $msgstr["dd_term_source"]." : ".$datafullfilename."<br>";
    $parameters.= "gizmo &nbsp;: ".$gizmoname."<br>";
    $parameters.= "mx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".$mx_path."<br>";
    $parameters.= " &nbsp; ".$testbutton."<br>";


    $strINV=$mx_path." iso=\"".$datafullfilename."\" create=".$gizmofullfolder."/".$gizmoname."  -all now 2>&1";
    ?>
    <font face=courier size=2><?php echo $parameters?><br>
          <?php echo $msgstr["commandline"]?>: <?php echo $strINV?><br></font>
    <hr>
    <?php
    exec($strINV, $output,$status);
    $straux="";
    for($i=0;$i<count($output);$i++){
        $straux.=$output[$i]."<br>";
    }
    if($status==0) {
        echo ("<h3>".$msgstr["processok"]."</h3>");
        echo "$straux";
    } else {
        echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3>");
        echo "<font color='red'>".$straux."</font>";
    }
}
?>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>
