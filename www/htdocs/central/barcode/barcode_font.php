<?php
/*
20220309 fho4abcd Created
20220320 fho4abcd modified for new configuration
*/
set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
include ("../config.php");

include ("../common/header.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/soporte.php");
$base=$arrHttp["base"];
echo "<body>";
include("../common/institutional_info.php");
?>
<script>
function Showfont(){
	msgwin=window.open("","showfontform","width=800, height=600, scrollbars, resizable")
	document.showfontform.submit()
	msgwin.focus()
}

function Download(){
    if (document.download.archivo_c.value=="") {
        alert("<?php echo $msgstr['barcode_not_selected']?>");
    } else {
        document.download.submit()
    }
}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["barcode_config"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php
    $backtoscript="../barcode/bcl_config_labels.php";
    include "../common/inc_back.php";
    ?>
    </div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="barcode.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php

include "inc_barcode_constants.php";
echo "<h3 style='text-align:center'>".$msgstr["barcode_font"].": ".$arrHttp["tipo"].$configfilesuffix;
echo " (".$arrHttp['desc'].")</h3>";

//SE LEE EL ARCHIVO DE CONFIGURACION
$configfile=$configfileprefix.$arrHttp["tipo"].$configfilesuffix;
$configfilefull=$db_path.$configfile;
if (!file_exists($configfilefull)){
	echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["misfile"]." &rarr; ".$configfile."<br>".$msgstr["barcode_conf"]."</div>";
	echo "</div></div>";
	include("../common/footer.php");
	die;
}
echo "<div>".$configfile." ".$msgstr["doesexist"]."</div>";

// Read the barcode configuration file
$bar_c=array();
$fp=file($configfilefull);
if ($fp){
	foreach ($fp as $conf){
		$conf=trim($conf);
		if ($conf!=""){
			$a=explode('=',$conf,2);
			$bar_c[$a[0]]=$a[1];
		}
	}
}

// Check if the pft is a file
$ispftfile=false;
if (substr($bar_c["label_format"],0,1)=='@'){
    $ispftfile=true;
}
/*
** Get the contents of the pft: the actual content or the content of the pft file
** Check if the barcode pft file exists.
*/
if ( $ispftfile==true) {
    $pftfilename=trim($bar_c["label_format"]);
    //  Note that it starts with "@"
    $pftfile=$pftfileprefix.substr($pftfilename,1);
    $pftfilefull=$db_path.$pftfile;
    if (!file_exists($pftfilefull)){
        echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["misfile"]." &rarr; ".$pftfile."<br>".$msgstr["barcode_conf"]."</div>";
        echo "</div></div>";
        include("../common/footer.php");
        die;
    } else {
        echo "<div>".$pftfile." ".$msgstr["doesexist"]."</div>";
        // Read the pft file into one string
        $pftcontent = file_get_contents($pftfilefull);
        //echo $pftcontent."<br>";
    }
} else {
    $pftcontent = $bar_c["label_format"];
}
// Show content explanation & examples
?>
<br>
<div style='color:blue'><?php echo $msgstr["barcode_font_1"];?><br><?php echo $msgstr["barcode_template"];?></div>
<div style='color:blue;text-indent:30px'><?php echo $msgstr["barcode_font_template"];?></div>
<div style='color:blue'><?php echo $msgstr["barcode_example"];?></div>
<div style='color:blue;text-indent:30px'><?php echo $msgstr["barcode_font_example"];?></div>
<?php
// Check if the pft has any content
$pftcontent=trim($pftcontent);
if ($pftcontent=="" ) {
    if ( $ispftfile==true) {
        echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["barcode_empty"]." &rarr; ".$pftfilefull."<br>".$msgstr["barcode_conf"]."</div>";
    } else {
        echo "<div style='color:red'>".$msgstr["error"].": ".$msgstr["barcode_empty"]."<br>".$msgstr["barcode_conf"]."</div>";
    }
    echo "</div></div>";
    include("../common/footer.php");
    die;
}
/*
** Get the font indication from the pft content
** template: style="font-family:'Bar Code 39 e HR'..."
** Notes: Check will exactly check the font-family name
*/
$font_pos_end=false;
$font_pos_start=stripos($pftcontent,"font-family:'");
if ( $font_pos_start!=false ) {
    $font_pos_start=$font_pos_start+strlen("font-family:'");
    $font_pos_end=stripos($pftcontent,"'",$font_pos_start);
}
if ( $font_pos_start==false or $font_pos_end==false ) {
    echo "<br><div style='color:red'>".$msgstr["error"].": ".$msgstr["barcode_no_family"]."</div>";
    echo "<div style='color:blue'>".$msgstr["barcode_confif"]."</div>";
    echo "</div></div>";
    include("../common/footer.php");
    die;
}
$font_family=substr($pftcontent,$font_pos_start,$font_pos_end-$font_pos_start);
?>
<form name=showfontform action=barcode_font_ex.php method=post target=showfontform>
<input type=hidden name=base value=<?php echo $arrHttp["base"];?>>
<input type=hidden name=fontfamily value=<?php echo urlencode($font_family)?> >
<input type=hidden name=pft value=<?php echo urlencode($pftcontent)?> >
</form>
<br>
<div>
    </i><?php echo $msgstr["barcode_font_detected"];?> : <b><?php echo $font_family;?></b>
         &nbsp; &nbsp;
        <button class="bt-green" type="button"
            title="<?php echo $msgstr["barcode_font_check"]?>" onclick='javascript:Showfont("font")'>
            <i class="fa fa-eye"></i> <?php echo $msgstr["barcode_font_check"]?></button>
</div>
<br>
<hr>
<div style='color:blue'><?php echo $msgstr["barcode_get_font"];?>
    <br><?php echo $msgstr["barcode_inst_font"];?></div>

<?php
/*
** Show font files delivered by ABCD in the assets folder
** and offer the option to download them
*/
$ABCD_assets=$ABCD_scripts_path."assets/barcodefonts/";
clearstatcache();
$files = array_diff(scandir($ABCD_assets), array('.', '..'));
?>
<br>
<form name=download action="../utilities/download.php">
<?php echo $msgstr["barcode_ttf_asset"];?>
    <select name=archivo_c>
        <option value=''>
        <?php foreach ($files as $shortname) {
            $filename=$ABCD_assets.$shortname;
            ?>
            <option value='<?php echo $filename;?>'><?php echo $shortname;?></option>
        <?php } ?>
    </select>
    &nbsp; &nbsp; </a><button class="bt-green" type="button"
            title="<?php echo $msgstr["download"]?>" onclick='javascript:Download()'>
            <i class="fa fa-eye"></i> <?php echo $msgstr["download"]?></button>
</form>
                
</div>
</div>
<?php
include("../common/footer.php");
?>
