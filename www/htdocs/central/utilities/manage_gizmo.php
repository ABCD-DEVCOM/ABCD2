<?php
/* Modifications
20240626 fho4abcd Created
*/
global $arrHttp;
set_time_limit(0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
/*
** Old code might not send specific info.
** Set defaults for the return script,frame info and more
*/
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script
if ( isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
$base=$arrHttp["base"];
$bd=$db_path.$base;
$data=$base."/data";
$datafull=$db_path.$data;
?>
<body >
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
function Creategizmo(){
	document.creategizmo.submit()
}
function Upload(datafolder){
    document.uploadform.backtoscript.value='../utilities/manage_gizmo.php'
	document.uploadform.action='../utilities/upload_wrkfile.php?&backtoscript_org=<?php echo $backtoscript?>'
	document.uploadform.submit()
}

function ActivarMx(folder,file){
    document.continuar.storein.value=folder
    document.continuar.copyname.value=file
    document.continuar.backtoscript.value='../utilities/manage_gizmo.php'
	document.continuar.action='../utilities/mx_show_iso.php?'+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function Exportmst(folder,file){
    document.continuar.storein.value=folder
    document.continuar.copyname.value=file
    document.continuar.backtoscript.value='../utilities/manage_gizmo.php'
	document.continuar.action='../utilities/export_gizmo.php?'+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function UpdateSeq(fullfile){
    document.continuar.archivo.value=fullfile;
    document.continuar.backtoscript.value='../utilities/manage_gizmo.php'
	document.continuar.action='../utilities/edittxtfile.php?'+'&backtoscript_org=<?php echo $backtoscript?>'
	document.continuar.submit()
}
function Eliminar(file){
	if (confirm("<?php echo $msgstr["cnv_deltab"]?>"+" "+file)==true){
	    document.continuar.deletefile.value=file
        document.continuar.submit()
	}
}
</script>
<?php
include "../common/institutional_info.php";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php 
        echo $msgstr["maintenance"]." &rarr; ".$msgstr["gizmo_manage"].": ".$arrHttp["base"];
?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
    <?php include "../common/inc_home.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php" ?>
<div class="middle form">
    <div class="formContent">
    <div align=center ><h2><?php echo $msgstr["gizmo_manage"]?></h2></div>
    <div align=center>
<?php
//===================
include ("../common/inc_get-dblongname.php");
$dbmsg_label=$msgstr["database"].":";
$dbmsg_value=$arrHttp["dblongname"]." (".$base.")";

$file_label=$msgstr["archivo"].": ";
$datafolder_label=$msgstr["workfolder"].":";
// Check if wrk is readable and writable. OS dependent
clearstatcache();
if ( PHP_OS_FAMILY=="Linux") {
    if (is_executable($datafull)) {
        $isexec=true;
    } else {
        $isexec=false;
    }
} else {
    $isexec=true; // Executable always true for windows
}
if (is_writable($datafull) and is_readable($datafull) and $isexec ) {
    $datafolder_value=$datafull;
    $is_readablefolder=true;
} else {
    $datafolder_value="<span style='color:red'>".$datafull." <b>".$msgstr["notreadable"]."</b></span>";
    $is_readablefolder=false;
}
    // Do not continue if the folder is not readable
    if (!$is_readablefolder) die;

    ?>
	<form name=creategizmo action='../utilities/create_gizmo.php' method=POST enctype='multipart/form-data' >
		<input type=hidden name=base value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]?>>
		<input type=hidden name=backtoscript value="../utilities/manage_gizmo.php">
	</form>
    <form name=uploadform  method=post >
		<input type=hidden name=storein value="<?php echo $data?>">
		<input type=hidden name=inframe value='0'>
		<?php
        if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
        foreach ($_REQUEST as $var=>$value){
            if ( $var!= "deletefile" ){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
		?>
    </form>
	<table  cellspacing=5>
		<tr>
			<td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
		</tr>
		<tr>
			<td><?php echo $datafolder_label;?></td><td><?php echo $datafolder_value;?></td>
		</tr>
		<tr><td>
				<a href="javascript:Upload()" class="bt bt-blue" title='<?php echo $msgstr["uploadfile"]?>'>
				<i class="fas fa-file-upload"></i>&nbsp;<?php echo $msgstr["uploadfile"];?></a></td>
			<td>
				<a href="javascript:Creategizmo()" class="bt bt-green" title='<?php echo $msgstr["create_gizmo"]?>'>
				<i class="fas fa-database"></i>&nbsp;<?php echo $msgstr["create_gizmo"];?></a></td>
		</tr>
	</table>
    <?php
    // Get the list of gizmo related files in the working folder
    $file_array = Array();
    $handle = opendir($datafull);
    if ($handle===false) die;// to cope with unexpected situations
    $numfiles=0;
	while (($file = readdir($handle))!== false) {
        $info = pathinfo($file);
        if (is_file($datafull."/".$file) and $info["filename"]!=$base and isset($info["extension"]) and (
			$info["extension"] == "iso" || $info["extension"] == "seq" || $info["extension"] == "mst")) {
            if ( isset($arrHttp["deletefile"]) and $file==$arrHttp["deletefile"]) {
                //delete the file
                unlink ($datafull."/".$file);
                echo "<div>".$msgstr["archivo"]." ".$file." ".$msgstr["deleted"]."</div>";
				// in case of an mst file delete also the xrf
				if ($info["extension"] == "mst") {
					$xrffile=$info["filename"].".xrf";
					$xrffull=$datafull."/".$xrffile;
					if (file_exists($xrffull)){
						unlink($xrffull);
						echo "<div>".$msgstr["archivo"]." ".$xrffile." ".$msgstr["deleted"]."</div>";
					}
				}
            } else {
                $file_array[]=$file;
                $numfiles++;
            }
        }
	}
	closedir($handle);
	if (count($file_array)>=0){
        sort ($file_array);
        reset ($file_array);
        // Create a form with all necessary info
        // Show the list of files in .../data
        ?>
        <form name=continuar  method=post >
			<input type=hidden name=deletefile value=0>
			<input type=hidden name=storein value='<?php if (isset($arrHttp["storein"])) echo $arrHttp["storein"];?>'>
			<input type=hidden name=copyname value=0>
			<input type=hidden name=archivo value=0>
           <?php
            if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
            foreach ($_REQUEST as $var=>$value){
                // do not copy special fields
                if ( $var!= "deletefile" and $var!="storein" and $var!="copyname"){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
        </form>

        <h4><?php echo $msgstr["gizmo_related"];?> </h4>
        <table style="border-collapse:collapse;"  cellpadding=5 >
        <?php
        foreach ($file_array as $file) {
			$fullfile=$datafull."/".$file;
			$fileindata=$data."/".$file;
            $filemsg="<b>".$file."</b><br>";
            $filemsg.="&rarr; ".$msgstr["filemod"].": ".date("Y-m-d H:i:s", filemtime($fullfile));
            $filemsg.=", Size: ".number_format(filesize($fullfile),0,',','.');
			$info = pathinfo($file);
			$extension=$info["extension"];
			?> 
			<tr>
				<td><?php echo $filemsg?></td>
				<td><?php if ($extension=="iso") { ?>
					<a href="javascript:ActivarMx(<?php echo "'$data'"?>,<?php echo "'$file'"?>)" class="bt bt-gray" title='<?php echo $msgstr["ver"]?>'>
					<i class="fas fa-tv"></i></a>
					<?php } else if ($extension=="seq") {?>
					<a href="javascript:UpdateSeq(<?php echo "'$fileindata'";?>)" class="bt bt-blue" title='<?php echo $msgstr["editar"]?>'>
					<i class="fas fa-edit"></i></a>
					<?php } else if ($extension=="mst") {?>
					<a href="javascript:Exportmst(<?php echo "'$data'";?>,<?php echo "'$file'"?>)" class="bt bt-green" title='<?php echo $msgstr["cnv_export"]?>'>
					<i class="fas fa-file-export"></i></a>
					<?php } ?>
				</td>
				<td>
					<a href="javascript:Eliminar('<?php echo $file?>')" class="bt bt-red" title='<?php echo $msgstr["eliminar"]?>'>
					<i class="fas fa-trash-alt"></i></a>
				</td>
			</tr>
			<?php
        }
        echo "</table>";
        echo "<br><div>".$numfiles." ".$msgstr["filesfound"]."</div>";
    }
//===================
echo "</div></div></div>";
include("../common/footer.php");
?>

