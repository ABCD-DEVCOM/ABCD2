<?php
/* Modifications
20211114 fho4abcd created
20211215 fho4abcd Backbutton by included file+ add gizmo to .par file
20220717 fho4abcd Use $actparfolder as location for .par files + improve .par content (parameterized path in stead of full path)
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
$base=$arrHttp["base"];
$storein=$arrHttp["base"]."/data";// variable name fixed by dirs_explorer function
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["gizmoname"]))    $gizmoname=$arrHttp["gizmoname"];
if ( isset($arrHttp["datafilename"])) $datafilename=$arrHttp["datafilename"];
if ( isset($arrHttp["storein"]))      $storein=$arrHttp["storein"];
$datafullfolder=$db_path.$storein;
$datafullfilename=$datafullfolder."/".$datafilename;
// If no gizmo name: derive it from the datafile
if ( $gizmoname=="" && $datafilename!="") {
    // remove extension from filename
    $gizmoname=substr($datafilename,0,-4);
}

include("../common/header.php");

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function Reselect(){
	document.continuar.confirmcount.value=0;
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
    <?php include "../common/inc_back.php";?>
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
$parfile=$db_path.$actparfolder.$base.".par";

// The test button gives the mx_path to the test window
$testbutton=
'<a href="mx_test.php?mx_path='.$mx_path.'" target=testshow onclick=OpenWindow()>'.$msgstr["testmx"].' MX</a>';
$showbutton=
'<a href="../utilities/show_par_file.php?par_file='.$parfile.'" target=testshow onclick=OpenWindow()>'.$msgstr["show"].' &lt;dbn&gt;.par</a>';

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
    /* Second screen select the gizmo source file and the gizmo database name*/
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
            $numfiles=0;
            while ($file = readdir($handle)) {
                if ($file != "." && $file != ".." && (strpos($file,".iso")||strpos($file,".ISO"))) {
                    echo "<option value='$file'>$file</option>";
                    $numfiles++;
                }
            }
            ?>
            </select></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmodbname"]?></td>
        <td><input type=text name=gizmoname value="<?php echo $gizmoname?>" title="<?php echo $msgstr["gizmonametitle"]?>"></td>
        <td><span style='color:blue'><?php echo $msgstr["gizmonamederived"];?></span></td>
    </tr><tr>
        <?php if ($numfiles>0) { ?>
         <td style='text-align:right'><?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;</td>
         <td><input type=button value='<?php echo $msgstr["gizmocreate"];?>' onclick=Confirmar()></td>
        <?php } else { ?>
        <td colspan=3><span style='color:red'><?php echo $msgstr["error_gizmonoiso"]." ".$datafullfolder." ";?></span>
            <input type=button value='<?php echo $msgstr["gizmoreselect"];?>' onclick=Reselect()></td>
        <?php } ?>
    </tr>       
    </table>
</form>
<?php   
}elseif ($confirmcount==2) {
    /* 
    ** Third screen: Create the gizmo
    ** Step 1: update the .par file: add /update the entry for this gizmo
    */
    $gizmokey=$gizmoname.".*";
    $parfile=$db_path.$actparfolder.$base.".par";
    $fp=file($parfile);
    $contenido="";
    $tokens=array();
    foreach ($fp as $value){
        $tokens=explode('=',$value);
        if (isset($tokens[0])) {
            $tokens0=trim($tokens[0]);
            unset($tokens1);
            if (isset($tokens[1]) AND trim($tokens[1])!="") $tokens1=trim($tokens[1]);
            if ($tokens0!=$gizmokey ) {
                $contenido.=$value;
            }
        } else {
            $contenido.=$value;
        }
    }
    $contenido.=PHP_EOL.$gizmokey."="."%path_database%".$base."/data/".$gizmokey;
	$handle = fopen($parfile, 'w');
    fwrite($handle, $contenido);
    fclose($handle);
    echo $msgstr["updatedfile"]." ".$parfile."<br>";

    $parameters = "<br>";
    $parameters.= $msgstr["dd_term_source"]." : ".$datafullfilename."<br>";
    $parameters.= "gizmo &nbsp;: ".$gizmoname."<br>";
    $parameters.= "mx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$mx_path."<br>";
    $parameters.= " &nbsp; ".$testbutton."&nbsp;&nbsp;&nbsp;&nbsp;".$showbutton. "<br>";


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
