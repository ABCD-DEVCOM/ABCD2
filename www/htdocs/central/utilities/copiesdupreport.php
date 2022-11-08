<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. Improve html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
set_time_limit(0);
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../common/header.php");
include("../dataentry/plantilladeingreso.php");
include("../dataentry/actualizarregistro.php");
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path."mx";
$base_ant=$arrHttp["base"];
$arrHttp["base"]="loanobjects";
$backtoscript="../dbadmin/menu_mantenimiento.php";

echo "<body onunload=win.close()>\n";
echo "<script src=../dataentry/js/lr_trim.js></script>";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";	
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["CPdupreport_mx"].": " . $base_ant;?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="menu_mantenimiento_copiesdupreport.html";
include "../common/inc_div-helper.php";
?>
<script type="text/JavaScript" language="javascript">
function Save(file)
{

window.open('download_CopDupReport.php?file='+file,'_self');
}
</SCRIPT>	
<div class="middle form">
	<div class="formContent">


<?php
echo "<p>".$msgstr["CPdupreport_mx_text"]."</p>";   
echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
echo "<h3>Report<p>";
$mx=$converter_path." ".$db_path."copies/data/copies \"pft=if npost(['".$db_path."copies/data/copies'],'IN_'v30)>1 then v1,'+-+',v10,'+-+',v30,'+~+',/ fi\" now";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}
$splittxt=explode("+~+",$textoutmx);
$duplicates=array();
$dupIN=",";
for ($i = 0; $i < (count($splittxt)-1); $i++) {//Now going from the first to total-1
$values=explode("+-+",$splittxt[$i]);
$actualid=$values[0];
$actualdb=$values[1];
$actualin=$values[2];
$res="";
for ($j = $i+1; $j < count($splittxt); $j++){//Going from actual until total
$tempvalues=explode("+-+",$splittxt[$j]);
$tempactualid=$tempvalues[0];
$tempactualdb=$tempvalues[1];
$tempactualin=$tempvalues[2];
if ($actualin==$tempactualin){//There is a duplicate
$res.=$actualid."+-+".$actualdb."+-+".$actualin."+~+".$tempactualid."+-+".$tempactualdb."+-+".$tempactualin;
}//There is a duplicate
}//Going from actual until total
if ($res!="") 
if (strpos($dupIN,','.$actualin.',') === false) 
{
$duplicates[]=$res;
$dupIN.=$actualin.",";
}
}//Now going from the first to total-1
if (count($duplicates)>0) {//There are duplicates to display
echo '<table width="500px" border="0"><tr><td width="73%"><label style="color:#FF0000;font-weight:bold;font-size:13px;cursor:default">There ';
$savefile="There ";
if (count($duplicates)>1) {echo "are "; $savefile.="are ";}else {echo "is "; $savefile.="is ";}
$dir=$db_path.'copies/DuplicateCopiesReport.txt';
$dir=str_replace ("\\", "/", $dir);
echo count($duplicates).' repeated inventory number</label></td><td width="27%"><div align="right"><input type="submit" name="Submit" value="'.$msgstr["saveas"].'" onclick="Save(\''.$dir.'\')"/> </div><br/></td></tr></table>';
$savefile.=count($duplicates).' repeated inventory number.

';
echo '<table width="500px" border="1">
  <tr>
    <td width="32%"><div align="center">Inventory Number </div></td>
    <td width="36%"><div align="center">Database</div></td>
    <td width="32%"><div align="center">Control Number </div></td>
  </tr>';
$savefile.='-------------------------------------------------------------------------
-   Inventory Number	-     Database		-     Control Number	-
-------------------------------------------------------------------------
';
for ($i = 0; $i < count($duplicates); $i++) {//Now going by duplicates entries
$dupentries=explode("+~+",$duplicates[$i]);
for ($j = 0; $j < count($dupentries); $j++){//Selecting one Inventory Number duplicate records
$tempvalues=explode("+-+",$dupentries[$j]);
if ($j==0) 
{
echo '<tr><td rowspan="'.count($dupentries).'" align="center">'.$tempvalues[2].'</td>';
$cantblanc=18-strlen($tempvalues[2]);
$savefile.='-     '.$tempvalues[2];
for($b=0;$b<$cantblanc;$b++) $savefile.=' ';
$savefile.='-			-			-
';
}
echo '<td align="center">'.$tempvalues[1].'</td><td align="center">'.$tempvalues[0].'</td></tr>';
$savefile.='-			';
$cantblanc=18-strlen($tempvalues[1]);
$savefile.='-     '.$tempvalues[1];
for($b=0;$b<$cantblanc;$b++) $savefile.=' ';
$cantblanc=18-strlen($tempvalues[0]);
$savefile.='-     '.$tempvalues[0];
for($b=0;$b<$cantblanc;$b++) $savefile.=' ';
$savefile.='-
-			-------------------------------------------------
';
}//Selecting one Inventory Number duplicate records
$savefile.='-------------------------------------------------------------------------
';
if ($i+1 < count($duplicates)) echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
}//Now going by duplicates entries
echo '</table>';
@ $fp = fopen($db_path."copies/DuplicateCopiesReport.txt", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."copies/DuplicateCopiesReport.txt";         
   exit;
 }
fwrite($fp,$savefile);
fclose($fp);

}//There are duplicates to display
else
echo $msgstr["noduplicates"]; 
?>   

</div>
</div>
<?
include("../common/footer.php");
?>
