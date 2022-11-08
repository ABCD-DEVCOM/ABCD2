<?php
/*
20220612 fho4abcd Created
20220627 fh04abcd Typo in title + improve error check
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../lang/importdoc.php");
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
/*
** Set defaults
*/
$backtoscript="../common/inicio.php"; // The default return script
$inframe=1;                      // The default runs in a frame
$impdoc_cnfcnt=0;
if ( isset($arrHttp["backtoscript"]))  $backtoscript=$arrHttp["backtoscript"];
if ( isset($arrHttp["inframe"]))       $inframe=$arrHttp["inframe"];
$backtourl=$backtoscript."?base=".$arrHttp["base"]."&inframe=".$inframe;
$confirmcount=0;
if (isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
include("../common/header.php");
?>
<body>
<script>
function Enviar(rows){
	err=false
	for (i=1;i<rows;i++){
        mimepart=eval("document.typetableform.mime_"+i)
        mime=mimepart.value;
        const e = document.getElementById("recordtype_"+i);
        type = e.value;
        if ( !type && !mime ) continue
        if ( type && !mime ) {
            alert("<?php echo $msgstr['dd_error_empty_type']?>:  "+type);
            err=true
            continue
        }
        if ( !type && mime ) {
            alert("<?php echo $msgstr['dd_error_empty_mime']?>: "+mime);
            err=true
            continue
        }
        for (j=i+1;j<rows;j++) {
            mimepartj=eval("document.typetableform.mime_"+j)
            mimej=mimepartj.value;
            if ( mime==mimej ) {
                alert("<?php echo $msgstr['dd_error_duplicate_mime']?>: "+mime);
                err=true
                continue
            }
        }
        if ( !IsAlfaNum(mime) ) {
            err=true
            continue
        }
	}
    if (err==false) document.typetableform.submit();
}
function IsAlfaNum(sText){
   var ValidChars = "0123456789abcdefghijklmnopqrstuvwxyz/+-.";
   var IsValid=true;
   var Char;
   for (itag = 0; itag < sText.length && IsValid == true; itag++){
      Char = sText.charAt(itag);
      if (ValidChars.indexOf(Char) == -1){
         alert("<?php echo $msgstr['dd_error_inv_chars']?>: "+mime+"\n ('"+Char+"')");
         IsValid = false;
      }
   }
   return IsValid;
}

</script>

<?php
// If outside a frame: show institutional info
if ($inframe!=1) include "../common/institutional_info.php";
?>
<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["dd_configrct"]. ": " . $base?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
    <?php include "../common/inc_home.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$base."_CENTRAL_ALL"]) ){
        echo "<div style='color:red'>".$msgstr["invalidright"]."</div>";
        die;
}
// Set collection related parameters and create folders if not present
// File $recConfigFull is created if not present
include "../utilities/inc_coll_chk_init.php";
// Read the record type configuration file if this is the first call
echo "<h3 style='text-align:center'>".$msgstr["dd_imp_check_mime"]."</h3>";

if ( $confirmcount==0) {
    $confirmcount=1;
    ?>
    <div style='color:blue;text-align:center'>
        <?php echo $msgstr["dd_imp_info_mime"]?><br>
        <?php echo $msgstr["dd_imp_info_type"]?><br><br>
        <?php echo $msgstr["dd_imp_info_map"]?><br>
        <?php echo $msgstr["dd_imp_info_maploc"]?> &rarr; <?php echo $recConfigFull?>
    </div>
    <?php
    $tabindex=0;
    $typesize=20;
    $mimesize=80;
    // Start a form with a table to enter/modify the values
    ?>
    <form name=typetableform method=post >
    <input type=hidden name=confirmcount value=<?php echo $confirmcount?>>
    <input type=hidden name=base value="<?php echo $base;?>">
    <table border=0 align=center>
    <tr>
        <th><?php echo $msgstr["dd_term_mime"]?></th>
        <th><?php echo $msgstr["dd_term_type"]?></th>
    </tr>
    <?php
    if (file_exists($recConfigFull)) {
        $labeltablearr=file($recConfigFull);
    }
    if (count($labeltablearr)>0) {
        foreach ($labeltablearr as $value) {
            $value=trim($value);
            if ($value=="") continue;
            if (strlen($value)<4 ) continue;
            if (stripos($value,'//') !== false ) continue;
            if (stripos($value, '#') !== false ) continue;
            $typesizearr=explode("|",$value);
            $mime=trim($typesizearr[0]);
            if ($mime=="" ) continue;
            $type="";
            if (isset($typesizearr[1])) $type=trim($typesizearr[1]);
            ?>
            <tr><?php $tabindex++?>
                <td><input type=text name=mime_<?php echo $tabindex?> size=<?php echo $mimesize?> value="<?php echo $mime?>"></td>
                <td><select id="recordtype_<?php echo $tabindex?>" name="recordtype_<?php echo $tabindex?>">
                        <option value=""> </option>
                        <option <?php if ($type=="text")  echo "selected";?> value="text">text </option>
                        <option <?php if ($type=="image") echo "selected";?> value="image">image</option>
                    </select></td>
            </tr>
            <?php
        }
    }
    ?>
    <tr><?php $tabindex++?>
        <td><input type=text name=mime_<?php echo $tabindex?> size=<?php echo $mimesize?>></td>
        <td><select id="recordtype_<?php echo $tabindex?>" name="recordtype_<?php echo $tabindex?>">
                <option value=""> </option>
                <option value="text">text </option>
                <option value="image">image</option>
             </select></td>
    </tr>
    <tr><?php $tabindex++?>
        <td><input type=text name=mime_<?php echo $tabindex?> size=<?php echo $mimesize?>></td>
        <td><select id="recordtype_<?php echo $tabindex?>" name="recordtype_<?php echo $tabindex?>">
                <option value=""> </option>
                <option value="text">text </option>
                <option value="image">image</option>
             </select></td>
    </tr>
    <tr><?php $tabindex++?>
        <td><input type=text name=mime_<?php echo $tabindex?> size=<?php echo $mimesize?>></td>
        <td><select id="recordtype_<?php echo $tabindex?>" name="recordtype_<?php echo $tabindex?>">
                <option value=""> </option>
                <option value="text">text </option>
                <option value="image">image</option>
             </select></td>
    </tr>
    </table>
    <input type=hidden name=tabindex value="<?php echo $tabindex;?>">
    </form>
    <br>
    <div style='text-align:center'>
    <a class="bt bt-green" href="javascript:Enviar(<?php echo $tabindex;?>)" ><i class="far fa-save"></i> <?php echo $msgstr["actualizar"]?></a>
    <a class="bt bt-gray" href="<?php echo $backtoscript."?base=".$base;?>"><i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["cancel"]?></a>
    </div>
    <?php
} else {
    // Second screen: Update of the file.
    $outarray=array();
    $tabindex=$arrHttp["tabindex"];
    for ( $i=1;$i<$tabindex;$i++) {
        $type="";
        $mime="";
        if (isset($_POST["recordtype_$i"])) $type=$_POST["recordtype_$i"];
        if (isset($arrHttp["mime_$i"])) $mime=$arrHttp["mime_$i"];
        if ($type=="" && $mime=="") continue;
        $line=$mime."|".$type;
        $outarray[]=$line.PHP_EOL; 
        echo "<span>".$line."<br></span>";
    }
    echo "<br>";
    if ( file_put_contents($recConfigFull,$outarray)===false ) {
        echo "<div style='color:red'>".$msgstr["cwritefile"].": ".$recConfigFull."</div>";
    } else {
        echo "<h3>".$msgstr["updatedfile"]." ".$recConfigFull."</h3>";
        echo "</div>";
   }
}
?>
</div>
</div>
<?php
include("../common/footer.php");
?>
