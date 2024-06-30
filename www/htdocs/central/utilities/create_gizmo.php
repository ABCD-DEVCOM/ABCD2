<?php
/* Modifications
20211114 fho4abcd created
20211215 fho4abcd Backbutton by included file+ add gizmo to .par file
20220717 fho4abcd Use $actparfolder as location for .par files + improve .par content (parameterized path in stead of full path)
20240630 fho4abcd Interactive control update .par file. Extend with text/seq file for input. Better pop-up window. More checks
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
$updatepar="no";
$source_ind="src_seq";
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if ( isset($arrHttp["gizmoname"]))    $gizmoname=$arrHttp["gizmoname"];
if ( isset($arrHttp["datafilename"])) $datafilename=$arrHttp["datafilename"];
if ( isset($arrHttp["storein"]))      $storein=$arrHttp["storein"];
if ( isset($arrHttp["updatepar"]))    $updatepar=$arrHttp["updatepar"];
if ( isset($arrHttp["source_ind"]))   $source_ind=$arrHttp["source_ind"];
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
function OpenWindow(){
	msgwin=window.open("","testshow","width=800,height=250");
	msgwin.focus()
}
function Confirmar(){
	document.continuar.confirmcount.value++;
	if ( document.continuar.datafilename.value=="") {
		alert('<?php echo $msgstr["gizmo_reqsel"].": ".$msgstr["gizmo_inputsrcfile"];?>')
		document.continuar.confirmcount.value=1;
		return
	}
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
<?php echo $msgstr["create_gizmo"]?>
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
'<a href="../utilities/show_par_file.php?par_file='.$parfile.'" target=testshow onclick=OpenWindow()>'.$msgstr["show"].' '.$base.'.par</a>';

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the iso file -*/
?>
<form name=continuar method=post>
    <input type=hidden name=confirmcount value=0>
    <input type=hidden name=datafilename value=0>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <input type=hidden name=backtoscript value="<?php echo $backtoscript?>">
    <table cellspacing=5 align=center>
    <tr><tr>
        <td><?php echo $msgstr["datasrcfolder"]?></td>
        <td><input type=text name=storein value="<?php echo $storein?>" ></td>
        <td><a href=javascript:Explorar()><?php echo $msgstr["explore"]?></a></td>
    </tr><tr>
		<td><?php echo $msgstr["gizmo_srctype"]?></td>
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
		if ($var!="datafilename"){
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
        <td><?php echo $storein?></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmo_srctype"]?></td>
        <td><?php if ($source_ind=="src_seq") { echo $msgstr["gizmo_seq"];} else {echo $msgstr["gizmo_iso"];};?></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmo_inputsrcfile"]?></td>
        <td><select name='datafilename'>
			<option value=''></option>
            <?php
            $handle=opendir($datafullfolder);
            $numfiles=0;
            while ($file = readdir($handle)) {
				if ($source_ind=="src_seq"){
					$extension="seq";
				} else {
					$extension="iso";
				}
				$path_parts = pathinfo($file);
				if ($path_parts['extension']==$extension || $path_parts['extension']==strtoupper($extension)) {
					$basename=$path_parts['basename'];
					echo "<option value='$basename'>$basename</option>";
					$numfiles++;
				}
            }
            ?>
            </select></td>
    </tr><tr>
        <td><?php echo $msgstr["gizmodbname"]?></td>
        <td><input type=text name=gizmoname value="<?php echo $gizmoname?>" title="<?php echo $msgstr["gizmonametitle"]?>"></td>
        <td><span style='color:blue'><i class="fas fa-info-circle"></i> <?php echo $msgstr["gizmonamederived"];?></span></td>
    </tr><tr>
		<td><?php echo $msgstr["gizmoupdpar"]." ".$base.".par ?"?></td>
		<td><input type=checkbox name=updatepar value=Yes
			<?php if(isset($arrHttp["updatepar"])) echo "checked";?>></td>
		<td><span style='color:blue'><i class="fas fa-info-circle"></i> <?php echo $msgstr["gizmoonlyhtml"];?><br><?php echo $showbutton;?></span></td>
	</tr><tr><td colspan=3><hr></td>
	</tr><tr>
        <?php if ($numfiles>0) { ?>
         <td style='text-align:right'><?php echo $msgstr["dd_continuewith"]?>&nbsp;&rarr;</td>
         <td><input type=button value='<?php echo $msgstr["gizmocreate"];?>' onclick=Confirmar()></td>
        <?php } else { ?>
        <td colspan=3><span style='color:red'>
			<?php echo $msgstr["gizmo_nofiles"].$extension."' ".$msgstr["gizmo_infolder"]." ".$datafullfolder." ";?></span>
            <input type=button value='<?php echo $msgstr["gizmoreselect"];?>' onclick=Reselect()></td>
        <?php } ?>
    </tr>       
    </table>
</form>
<?php   
}elseif ($confirmcount==2) {
    /* 
    ** Third screen: Create the gizmo
	** Step 1 check if .seq file has at least one line with the "|" separator
	*/
	$inputtype="seq";
	if ($source_ind=="src_iso") $inputtype="iso";
	$isok=false;
	if ($inputtype=="seq") {
		$fpseq=file($datafullfilename);
		foreach ($fpseq as $value){
			if ( trim($value)!="") {
				$tokens=explode('|',$value);
				if(isset($tokens[1])){
					$isok=true;
				}
				else {
					$isok=false;
					break;
				}
			}
		}
	}
	/*
    ** Step 2: update the .par file: add /update the entry for this gizmo
    */
	if ($updatepar=="Yes" && $isok) {
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
	}
    $parameters = "\n<table style=' margin-left:auto;margin-right:auto;'>";
    $parameters.= "<tr><td>".$msgstr["dd_term_source"]."</td><td>: </td><td>".$datafullfilename."</td>";
    $parameters.= "<tr><td>"."gizmo"."</td><td>: </td><td>".$gizmoname."</td>";
    $parameters.= "<tr><td>"."mx"."</td><td>: </td><td>".$mx_path."</td>";
    $parameters.= "<tr><td></td><td></td><td>".$testbutton;
    $parameters.= " &nbsp; ".$showbutton."</td>";
	$parameters.="</table>";

    $strINV=$mx_path." ".$inputtype."=\"".$datafullfilename."\" create=".$gizmofullfolder."/".$gizmoname."  -all now 2>&1";
    ?>
    <font face=courier size=2><?php echo $parameters?><br>
          <?php echo $msgstr["commandline"]?>: <?php echo $strINV?><br></font>
    <hr>
    <?php
	if ($isok) {
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
	} else {
			echo ("<h3><font color='red'><br>".$msgstr["processfailed"]."</font></h3>");
			echo "<font color='red'>".$datafullfilename." ".$msgstr["gizmo_nosepar"]."</font>";
	}
}
?>
</div>
</div>
<?php
include("../common/footer.php");
?>
