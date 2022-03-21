<?php
/*
20220316 fho4abcd Created
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/reports.php");
$base=$arrHttp["base"];
$backtoscript="../dbadmin/menu_modificardb.php";
$confirmcount=0;
if (isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
include("../common/header.php");
echo "<body>";
include("../common/institutional_info.php");
?>
<script>
function Enviar(rows){
	err=false
	for (i=1;i<rows;i++){
        namepart=eval("document.labeltableform.name_"+i)
        descpart=eval("document.labeltableform.desc_"+i)
        name=namepart.value;
        desc=descpart.value;
        if ( !name && !desc ) continue
        if ( name && !desc ) {
            alert("<?php echo $msgstr['bcl_missing_desc']?>:  "+name);
            err=true
            continue
        }
        if ( !name && desc ) {
            alert("<?php echo $msgstr['bcl_missing_name']?>: "+desc);
            err=true
            continue
        }
        for (j=i+1;j<rows;j++) {
            namepartj=eval("document.labeltableform.name_"+j)
            namej=namepartj.value;
            if ( name==namej ) {
                alert("<?php echo $msgstr['bcl_duplicate_name']?>: "+name);
                err=true
                continue
            }
        }
        if ( !IsAlfaNum(name) ) {
            alert("<?php echo $msgstr['bcl_label_name']?>: "+name+"\n<?php echo $msgstr['bcl_invalid_name']?>");
            err=true
            continue
        }
	}
    if (err==false) document.labeltableform.submit();
}
function EnviarL(rows){
    document.labeltableform.legacy.value="legacy";
    document.labeltableform.confirmcount.value=0;
    document.labeltableform.submit();
}
function IsAlfaNum(sText){
   var ValidChars = "0123456789abcdefghijklmnopqrstuwwxyz";
   var IsValid=true;
   var Char;
   for (itag = 0; itag < sText.length && IsValid == true; itag++){
      Char = sText.charAt(itag);
      if (ValidChars.indexOf(Char) == -1){
         IsValid = false;
      }
   }
   return IsValid;
}

</script>
<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["barcode_table"]. ": " . $base?>
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
    !isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) and
    !isset($_SESSION["permiso"][$base."_CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$base."_CENTRAL_BARCODE"])){
        echo "<div style='color:red'>".$msgstr["invalidright"]."</div>";
        die;
}
include "inc_barcode_constants.php";
if ( $confirmcount==0) {
    $confirmcount=1;
    ?>
    <div style='color:blue;text-align:center'>
        <?php echo $msgstr["bcl_info_labelgen"]?><br>
        <?php echo $msgstr["bcl_info_labeltype"]?><br><br>
        <?php echo $msgstr["bcl_info_labeltab"]?><br>
        <?php echo $msgstr["bcl_info_labeltabloc"]?> &rarr; <?php echo $labeltable?>
    </div>
    <?php
    $tabindex=0;
    $namesize=20;
    $descsize=40;
    // Start a form with a table to enter/modify the values
    ?>
    <form name=labeltableform method=post >
    <input type=hidden name=legacy>
    <input type=hidden name=confirmcount value=<?php echo $confirmcount?>>
    <input type=hidden name=base value="<?php echo $base;?>">
    <table border=0 align=center>
    <tr>
        <th><?php echo $msgstr["bcl_label_name"]?></th>
        <th><?php echo $msgstr["bcl_label_descr"]?></th>
    </tr>
    <?php
    if (file_exists($labeltablefull)) {
        $labeltablearr=file($labeltablefull);
    }
    if (count($labeltablearr)>0) {
        foreach ($labeltablearr as $value) {
            $value=trim($value);
            if ($value=="") continue;
            $namedesc=explode("|",$value);
            $name=trim($namedesc[0]);
            $desc="";
            if (isset($namedesc[1])) $desc=trim($namedesc[1]);
            ?>
            <tr><?php $tabindex++?>
                <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?> value="<?php echo $name?>"></td>
                <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?> value="<?php echo $desc?>"></td>
            </tr>
            <?php
        }
    }
    if (isset($arrHttp["legacy"]) ) {
        ?>
        <tr><?php $tabindex++?>
            <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?> value="barcode"></td>
            <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?> value="<?php echo $msgstr['barcode']?>"></td>
        </tr>
        <tr><?php $tabindex++?>
            <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?> value="lomos"></td>
            <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?> value="<?php echo $msgstr['barcode_lomos']?>"></td>
        </tr>
        <tr><?php $tabindex++?>
            <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?> value="etiquetas"></td>
            <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?> value="<?php echo $msgstr['barcode_etiquetas']?>"></td>
        </tr>
        <?php
    }
    ?>
    <tr><?php $tabindex++?>
        <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?>></td>
        <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?>></td>
    </tr>
    <tr><?php $tabindex++?>
        <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?>></td>
        <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?>></td>
    </tr>
    <tr><?php $tabindex++?>
        <td><input type=text name=name_<?php echo $tabindex?> size=<?php echo $namesize?>></td>
        <td><input type=text name=desc_<?php echo $tabindex?> size=<?php echo $descsize?>></td>
    </tr>
    </table>
    <input type=hidden name=tabindex value="<?php echo $tabindex;?>">
    </form>
    <br>
    <div style='text-align:center'>
    <a class="bt bt-green" href="javascript:Enviar(<?php echo $tabindex;?>)" ><i class="far fa-save"></i> <?php echo $msgstr["actualizar"]?></a>
    <a class="bt bt-blue" href="javascript:EnviarL(<?php echo $tabindex;?>)" ><i class="fas fa-recycle"></i> <?php echo $msgstr["bcl_legacy"]?></a>
    <a class="bt bt-gray" href="<?php echo $backtoscript."?base=".$base;?>"><i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["cancel"]?></a>
    </div>
    <?php
} else {
    // Second screen: Update of the file.
    $outarray=array();
    $tabindex=$arrHttp["tabindex"];
    for ( $i=1;$i<$tabindex;$i++) {
        $name="";
        $desc="";
        if (isset($arrHttp["name_$i"])) $name=$arrHttp["name_$i"];
        if (isset($arrHttp["desc_$i"])) $desc=$arrHttp["desc_$i"];
        if ($name=="" && $desc=="") continue;
        $line=$name."|".$desc;
        $outarray[]=$line.PHP_EOL; 
        echo "<span>".$line."<br></span>";
    }
    echo "<br>";
    if ( file_put_contents($labeltablefull,$outarray)===false ) {
        echo "<div style='color:red'>".$msgstr["cwritefile"].": ".$labeltable."</div>";
    } else {
        echo "<h3>".$msgstr["updatedfile"]." ".$labeltable."</h3>";
        echo "<br><div>".$msgstr["bcl_continuewith"].": ";
        echo "<a href='../barcode/bcl_config_labels.php?base=".$base."'>".$msgstr["barcode_config"]."</a>";
        echo "</div>";
   }
}
?>
</div>
</div>
<?php
include("../common/footer.php");
?>
