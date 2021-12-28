<?php
/*
20211228 fho4abcd renamed from barcode.php from barcode_search.php. Initial cleanup
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../config.php");
include("../common/header.php");
?><body>
<script src=../dataentry/js/lr_trim.js></script>
<script>
function Submit(){
    document.maintenance.submit()
}
</script>
<?php
$base=$arrHttp["base"];
$backtoscript="../dbadmin/menu_mantenimiento.php";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["barcode_search"].": " . $base?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="menu_mantenimiento_barcode.html";
include "../common/inc_div-helper.php";

$converter_path=$mx_path;
$t="";$barcode="";
$base=$arrHttp["base"];
$bd=$db_path.$base;
if (isset($_GET['barcode'])) $barcode=$_GET['barcode'];
if (isset($_GET['bf'])) $bf=$_GET['bf'];
$strINV=$converter_path." ".$bd."/data/".$base." \"".$barcode."\"";
if($barcode!="") {
    exec($strINV, $output,$t);
    $straux="";
    $strstr="";
    for($i=0;$i<count($output);$i++) {
        $straux[$i]=$output[$i]."<br>";
        $strstr.=$output[$i];
    }
}

?>
<div class="middle form">
<div class="formContent">
<?php

if($t==0 and $barcode!=""){
    echo ("<h3>Results for barcode '$barcode' in database $base</h3><br>");
    echo "<li>Found in $base?";
    if(strpos($strstr,"Hits=0")==false and $t==0) echo " yes";
    else echo " no";
    echo " </li>";
    if(strpos($strstr,"Hits=0")==false and $t==0) {
        $mfnf=split("mfn= ",$strstr);
        $aux= trim($mfnf[1]);
        $i=0;
        $mfn="";
        while($aux[$i]!=' ') {
            $mfn.=$aux[$i];
            $i++;
        }
        echo "<li>Mfn= ".$mfn."</li>";
        $cn=$straux[4];
        $cnOK="";
        $str=$strstr;
        for($i=0;$i<strlen($str)-3;$i++)  {
            if($str[$i]=='1' and $str[$i+1]==' ' and $str[$i+2]==' ' and $str[$i+3]=='®') {
                $i=$i+4;
                while($str[$i]!='¯') {
                    $prevcn.=$str[$i];
                    $i++;
                }
                break;
            }
        }
        $CN=$prevcn;
        echo "<li><font color='red'>Control number:".$CN."</font></li>";
    }
}

if (isset($straux)) if(strpos($straux[3],"=")) {
    $bd2=$_GET['bd2'];
    $cnf=$_GET['cnf'];
    $bd=$db_path.$bd2;
    $auxsplit=split("<br>",$cnOK);
    $cnOK=$auxsplit[0];
    $cng=$cnOK;
    $CN=CN($strstr);
    $strINV2=$converter_path." ".$bd."/data/".$bd2." \"".$CN."\""." "."\"pft=v$cnf\"" ;
    exec($strINV2, $output2,$t);
    $strout="";
    for($i=0;$i<count($output2);$i++) {
        $strout.= $output2[$i]."<br>";
    }
    if(strpos($strout,"Hits=0")==false and $t==0) {
        echo "<h3>The control number  $CN is present in the $bd2 database</h3><br>";
    } else {
        echo "<h3><font color='red'>The control number $CN is NOT present in the $bd2 database in the field '$cnf'</font></h3>";
    }
}
else
if($t!=0)
echo ("<h2>Output: <br>process NOT EXECUTED</h2><br>");
if($base=="")
{
echo"NO database selected";
}
?>
<form name=maintenance>
    <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
    <table cellspacing=5 width=400 align=center>
    <tr><td><?php echo $msgstr["barcode_enter"]?></td>
        <td><input type='text' name='barcode'></td>
    </tr>
    <tr><td><?php echo "Enter secondary database"?></td>
        <td><input type='text' name='bd2' value='marc'></td>
    </tr>
    <tr><td><?php echo "Control Number Field"?></td>
        <td><input type='text' name='cnf' value='1'></td>
    </tr>
    <tr><td colspan=2 style='text-align:center'><a class="bt bt-green" href="javascript:Submit()">
             <i class="fas fa-search"></i> <?php echo $msgstr["m_buscar"]?></a></td>
    </tr>
    </table>
</form>
</div></div>
<?php
include("../common/footer.php");

//================
function CN ($str) { //to get control number from mx output
    $cnf=$_GET['cnf'];
    for($i=0;$i<strlen($str)-3;$i++) {
        if($str[$i]=='$cnf' and $str[$i+1]==' ' and $str[$i+2]==' ' and $str[$i+3]=='®') {
            $i=$i+4;
            while($str[$i]!='¯') {
                $prevcn.=$str[$i];
                $i++;
            }
            break;
        }
    }
    return $prevcn;
}
?>


