<?php
/* Modifications
20240627 fho4abcd Created
*/
/*
** Creates an export of a gizmo database in the data folder of the current database
** Options for export
** - Create an iso file or create a text file (.seq)
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
//foreach ($arrHttp as $var=>$value) echo "$var=".htmlspecialchars($value)."<br>";//die;
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
$source_ind="src_seq";
if ( isset($arrHttp["backtoscript"]))    $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["confirmcount"]))    $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["copyname"]))        $gizmoname=$arrHttp["copyname"];// !! This is correct!
if ( isset($arrHttp["gizmoname"]))       $gizmoname=$arrHttp["gizmoname"];
if ( isset($arrHttp["datafilename"]))    $datafilename=$arrHttp["datafilename"];
if ( isset($arrHttp["storein"]))         $storein=$arrHttp["storein"];
if ( isset($arrHttp["source_ind"]))      $source_ind=$arrHttp["source_ind"];

if ( trim($datafilename==""))		$datafilename=$gizmoname;

// remove extension from gizmoname
$gizmoname=str_replace(".mst","",$gizmoname);

include("../common/header.php");

?>
<body>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script>
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
}
function Confirmar(){
	document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function Confirmarchk(){
	myfilename=document.continuar.datafilename.value
	if (myfilename.indexOf('.')>-1){
		alert('<?php echo $msgstr["gizmo_noext"]?>')
		return
	}
	document.continuar.confirmcount.value++;
	document.continuar.submit()
}
function Explorar(){
	msgwin=window.open("../dataentry/dirs_explorer.php?targetForm=continuar&desde=dbcp&Opcion=explorar&base=<?php echo $arrHttp["base"]?>","explorar","width=400,height=600,top=0,left=0,resizable,scrollbars,menu")
    msgwin.focus()
}
function List_iso(){
	document.getElementById("src_seq").checked = false;
	document.getElementById("src_iso").checked = true;
}
function List_seq(){
	document.getElementById("src_iso").checked = false;
	document.getElementById("src_seq").checked = true;
}
</script>
<?php
// Show institutional info
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["gizmo_export"].": ".$gizmoname;?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
    <?php include "../common/inc_home.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">
    <div align=center><h3><?php echo $msgstr["gizmo_export"] ?></h3></div>
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

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the iso file -*/
?>
<form name=continuar method=post>
    <input type=hidden name=confirmcount value=0>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=backtoscript value="<?php echo $backtoscript?>">
    <input type=hidden name=gizmoname value="<?php echo $gizmoname?>">
   <table cellspacing=5 align=center>
    <tr>
        <td><?php echo $msgstr["gizmo_exportfolder"]?></td>
        <td><input type=text name=storein value="<?php echo $storein?>" ></td>
        <td><a href=javascript:Explorar()><?php echo $msgstr["explore"]?></a></td>
    </tr><tr>
		<td><?php echo $msgstr["gizmo_exptype"]?></td>
		<td>
			<input type=radio name=source_ind value="src_seq" id=src_seq onclick="List_seq()"
				<?php if ($source_ind=="src_seq") echo "checked";?>>
				<?php echo $msgstr["gizmo_seq"]." (.seq)";?><br>
			<input type=radio name=source_ind value="src_iso" id=src_iso onclick="List_iso()"
				<?php if ($source_ind!="src_seq") echo "checked";?>>
				<?php echo $msgstr["gizmo_iso"]." (.iso)";?><br>
		</td>
	</tr><tr><td colspan=3><hr></td>
    </tr><tr>
        <td></td>
        <td><a href="javascript:Confirmar()" class="bt bt-green" title='<?php echo $msgstr["continuar"]?>'>
                <i class="fas fa-forward"></i>&nbsp;<?php echo $msgstr["continuar"];?></a>
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
         echo "<input type=hidden name=$var value=\"$value\">\n";
    }
    ?>
    <table cellspacing=5 align=center>
    <tr>
        <td><?php echo $msgstr["gizmo_exportfolder"]?></td>
        <td><?php echo $storein?></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmo_exptype"]?></td>
        <td><?php if ($source_ind=="src_seq") { echo $msgstr["gizmo_seq"];} else {echo $msgstr["gizmo_iso"];};?></td>
    </tr>
        <td><?php echo $msgstr["gizmoname"]?></td>
        <td><?php echo $gizmoname?></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmonametitle"]?></td>
        <td><input type=text name=datafilename value="<?php echo $gizmoname?>" title="<?php echo $msgstr["gizmonametitle"]?>"></td>
        <td><span style='color:blue'><i class="fas fa-info-circle"></i> <?php echo $msgstr["gizmofilederived"];?></span></td>
	</tr><tr><td colspan=3><hr></td>
	</tr><tr>
        <td></td>
        <td><a href="javascript:Confirmarchk()" class="bt bt-green" title='<?php echo $msgstr["continuar"]?>'>
                <i class="fas fa-forward"></i>&nbsp;<?php echo $msgstr["continuar"];?></a>
    </tr>       
    </table>
</form>
<?php   
}elseif ($confirmcount==2) {
    /* 
    ** Third screen: Export the gizmo
    */
	$datafilename=$storein."/".$datafilename;
	$datafilename=str_replace("//","/",$datafilename);
	$datafullfilename=$db_path.$datafilename;
	if ($source_ind=="src_iso") {
		$outputtype="iso";
		$expstring=$msgstr["gizmo_iso"]." (.iso)";
		$datafullfilename.=".iso";
	} else {
		$outputtype="seq";
		$expstring=$msgstr["gizmo_seq"]." (.seq)";
		$datafullfilename.=".seq";
	}
    $parameters = "\n<table style=' margin-left:auto;margin-right:auto;'>";
    $parameters.= "<tr><td>".$msgstr["gizmoname"]."</td><td>: </td><td>".$gizmoname."</td>";
	$parameters.= "<tr><td>".$msgstr["gizmo_exptype"]."</td><td>: </td><td>".$expstring."</td>";
	$parameters.= "<tr><td>".$msgstr["gizmo_exportfile"]."</td><td>: </td><td>".$datafullfilename."</td>";
	$parameters.= "<tr><td>"."mx"."</td><td>: </td><td>".$mx_path."</td>";
    $parameters.= "<tr><td></td><td></td><td>".$testbutton."</td>";
	$parameters.="</table>";
	$inputtype="seq";
	if ($source_ind=="src_iso"){
		$strINV=$mx_path." db=\"".$gizmofullfolder."/".$gizmoname."\" iso=\"".$datafullfilename."\"  -all now 2>&1";
	} else {
		$strINV=$mx_path." db=\"".$gizmofullfolder."/".$gizmoname."\" fix=\"".$datafullfilename."\"  -all now 2>&1";
	}
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
<?php
include("../common/footer.php");
?>
