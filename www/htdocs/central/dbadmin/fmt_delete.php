<?php
/*
** 20220112 fho4abcd backbutton+helper+clean html+ confirm delete
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../common/header.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
$lang=$_SESSION["lang"];
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$fmtfilnam=$arrHttp["fmt"];
$fmtfile=$fmtfilnam.".fmt";
$fullfmtfile=$db_path.$arrHttp["base"]."/def/".$lang."/$fmtfile";
$wksfile="formatos.wks";
$backtoscript="../dbadmin/fmt_adm.php"; // The default return script
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
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["fmt"]." &rarr; ". $msgstr["delete"]?>
	</div>
    <div class="actions">
    <?php
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
	</div>
    <div class="spacer">&#160;</div>
</div>

<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<div style="text-align:center">
<?php
// Create a form for submission.
echo "<form name=continuar action=fmt_delete.php method=post>\n";
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
// Ask for confirmation in the first pass
if ($arrHttp["confirmcount"]==0) {
    ?>
    <div><h4><font color=red><?php echo $msgstr["delete"]?>: <?php echo  $fullfmtfile?> ?</font></h4></div>
    <?php
	Confirmar();
} else{
    // remove the worksheet (if any)
    if (!file_exists($fullfmtfile)){
        echo "<h4 style='color:red'>".$msgstr["file"].": ".$fmtfile ." &nbsp; ".$msgstr["ne"]." !!</h4>";
    }else{
        $res=unlink($fullfmtfile);
        if ($res==false){
            echo "<h4 style='color:red'>".$msgstr["file"].": ".$fmtfile ." &nbsp; ".$msgstr["nodeleted"]." !!</h4>";
        }else{
            echo "<h4 >".$msgstr["file"].": ".$fmtfile ." &nbsp; ".$msgstr["deleted"]." !!</h4>";
        }
    }
    // remove the entry from the worksheet table
    $salida="";
    $fp=file($db_path.$arrHttp["base"]."/def/".$lang."/$wksfile");
    foreach ($fp as $value){
        $value=trim($value);
        $v=explode('|',$value);
        if ($v[0]!=$fmtfilnam) $salida.=$value."\n";
    }
    $fp=fopen($db_path.$arrHttp["base"]."/def/".$lang."/$wksfile","w");
    fwrite($fp,$salida);
    fclose($fp);
    echo "<h4>".$wksfile.": ".$msgstr["actualizados"]."</h4>";
}
echo "</div></div>";
include("../common/footer.php");
//====================== Functions =================
// Function to show a "confirm" and "cancel" button. Actions by corresponding script
function Confirmar(){
    global $msgstr;
    ?>
    <br><br>
    <button class="button_browse delete bt-red" type="button" onclick="Confirmar()" title="<?php echo $msgstr["delete"]?>">
        <i class="far fa-trash-alt"></i> <?php echo $msgstr["delete"]?></button>
	&nbsp; &nbsp;
    <button class="button_browse bt-gray" type="button" onclick="Regresar()" title="<?php echo $msgstr["cancel"]?>">
        <i class="far fa-times"></i> <?php echo $msgstr["cancel"]?></button>
    <?php
}
//----------------------- End functions --------------------------------------------------

?>