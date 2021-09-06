<?php
session_start();
set_time_limit(0);
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../common/header.php");
$converter_path=$cisis_path."mx";
$base_ant=$arrHttp["base"];
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body onunload=win.close()>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";	
}
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".$msgstr["splitoccs"].": " . $base_ant."
			</div>
			<div class=\"actions\">";
if (isset($arrHttp["encabezado"])){
echo "<a href=\"../dbadmin/menu_mantenimiento.php?base=".$base_ant."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../../assets/images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_splitoccs.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_splitoccs.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: splitoccs.php</font>";
?>
</div>		
<div class="middle form">
	<div class="formContent">
<form action="" method="post" name="form1" target="_self" id="form1" onsubmit="OpenWindows();">
<?php
echo "<p>".$msgstr["splitoccs_tx"]."</p>";   
  echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";
  echo "<h3>".$msgstr["database"]." ".$base_ant."<p>";
  ?>
  
<script language="javascript">  
function OpenWindows() {      
NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
win.focus()
    }	
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
</script>    
  <table width="750" border="0">
  <tr>
    <td width="202" align="right">		<label>Repeated Field
  <input name="rf" type="text" id="rf" value="<?php echo $_POST["rf"];?>" size="5"/>
  </label></td>
    <td width="22" align="center"></td>
    <td width="187" align="left"></td>
    <td width="321" align="left"></td>
  </tr> 
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><?php 
  echo "<input type=submit name=submit value=".$msgstr["update"].">"; 
  if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
 ?></td>
    </tr>
</table> 
</form>
</div>
<?php
function Vfield($field)
{
$field=trim($field);
if ($field[0]=='v') return str_replace( 'v','',$field);
return $field;
}
if ($_POST["submit"])
{

$rf=Vfield(strtolower($_POST['rf']));
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$base_ant."&cipar=$db_path"."par/".$base_ant.".par&Opcion=status";
include("../common/wxis_llamar.php");
$ix=-1;
foreach($contenido as $linea) {
	//echo "$linea<br>";
	$ix=$ix+1;
	if ($ix>0) {
		if (trim($linea)!=""){
	   		$a=explode(":",$linea);
	   		if (isset($a[1])) $tag[$a[0]]=$a[1];
	  	}
	}
}
$cantbefore=(int) $tag["MAXMFN"];


//Read the FDT
$savestring="'d*',
(if p(v".$rf.") and nocc(v".$rf.")>1 and iocc=nocc(v".$rf.") then \n";
$tab_st=$db_path.$base_ant."/def/".$_SESSION["lang"]."/".$base_ant.".fdt";
if (!file_exists($tab_st))
	$tab_st=$db_path.$base_ant."/def/".$lang_db."/".$base_ant.".fdt";
if (file_exists($tab_st)){
$fp=file($tab_st);
foreach ($fp as $value){
	$value=trim($value);
	if ($value!=""){
		$v=explode("|",$value);
		if (($v[0]=='F') or ($v[0]=='T')) if ($v[1]!=$rf) $savestring.="if v".$v[1]."[1]<>'' then '<".$v[1].">',v".$v[1]."[1],'</".$v[1].">' ,fi,\n";		
	}

}
}
$savestring.="'<".$rf.">',v".$rf.",'</".$rf.">'\n";
$savestring.="fi,)
";

@ $fp = fopen($db_path."wrk/lo_create.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_create.prc";         
   exit;
 } 
fwrite($fp,$savestring);
fclose($fp);
@ $fp = fopen($db_path."wrk/lo_change.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_change.prc";         
   exit;
 }
 $savestring="(if p(v".$rf.") and nocc(v".$rf.")>1 and iocc=nocc(v".$rf.") then '' else '<4004>',v".$rf.",'</4004>' fi,)"; 
fwrite($fp,$savestring);
fclose($fp);
@ $fp = fopen($db_path."wrk/lo_mod.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_mod.prc";         
   exit;
 }
 $savestring="'d".$rf."',(,'<".$rf.">',v4004,'</".$rf.">',),"; 
fwrite($fp,$savestring);
fclose($fp);
@ $fp = fopen($db_path."wrk/lo_modf.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_modf.prc";         
   exit;
 }
 $savestring="'d4004'"; 
fwrite($fp,$savestring);
fclose($fp);

@ $fp = fopen($db_path."wrk/lo_check.pft", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_check.pft";         
   exit;
 }
 $savestring="(if p(v".$rf.") and nocc(v".$rf.")>1 then 'rep',break, fi)"; 
fwrite($fp,$savestring);
fclose($fp);

$mxch=$converter_path." $db_path".$base_ant."/data/".$base_ant."  \"pft=@".$db_path."wrk/lo_check.pft\" now -all";
exec($mxch,$outmxch,$banderamxch);
$textoutmx=$outmxch[0];
if ($textoutmx=="") 
{
$banderafin=1;
echo '<br /><span style="color: #FF0000"><b>There is no need to run this script in your database, there are no duplicates</b></span>';
} 
else 
{
$cant=ceil($cantbefore/100);
for($i=0;$cant>$i;$i++)
{
$from=$i*100+1;
$to=$i*100+100;
$mxbase=$converter_path." $db_path".$base_ant."/data/".$base_ant."  create=".$db_path.$base_ant."/data/".$base_ant."temp from=".$from." to=".$to." now -all";
exec($mxbase,$outmxbase,$banderamxbase);

$banderafin=0;
while($banderafin==0){

$mx=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  \"proc=@".$db_path."wrk/lo_create.prc\" append=".$db_path.$base_ant."/data/".$base_ant."temp now -all";
exec($mx,$outmx,$banderamx);
$mx1=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  \"proc=@".$db_path."wrk/lo_change.prc\" copy=".$db_path.$base_ant."/data/".$base_ant."temp now -all";
exec($mx1,$outmx1,$banderamx1);
$mx2=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  \"proc=@".$db_path."wrk/lo_mod.prc\" copy=".$db_path.$base_ant."/data/".$base_ant."temp now -all";
exec($mx2,$outmx2,$banderamx2);
$mx3=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  \"proc=@".$db_path."wrk/lo_modf.prc\" copy=".$db_path.$base_ant."/data/".$base_ant."temp now -all";
exec($mx3,$outmx3,$banderamx3);
$outmxch=array();
$mxch=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  \"pft=@".$db_path."wrk/lo_check.pft\" now -all";
exec($mxch,$outmxch,$banderamxch);
$textoutmx=$outmxch[0];
if ($textoutmx=="") $banderafin=1;
}
$mxbase=$converter_path." $db_path".$base_ant."/data/".$base_ant."temp  append=".$db_path.$base_ant."/data/".$base_ant."new now -all";
exec($mxbase,$outmxbase,$banderamxbase);
}//for

}//else if ($textoutmx=="") 
$mxbase=$converter_path." $db_path".$base_ant."/data/".$base_ant."new  create=".$db_path.$base_ant."/data/".$base_ant." now -all";
exec($mxbase,$outmxbase,$banderamxbase);

$mxinv=$converter_path." ".$db_path.$base_ant."/data/".$base_ant." fst=@".$db_path.$base_ant."/data/".$base_ant.".fst fullinv=".$db_path.$base_ant."/data/".$base_ant." now -all";
exec($mxinv, $outputmxinv,$banderamxinv);

$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$base_ant."&cipar=$db_path"."par/".$base_ant.".par&Opcion=status";
include("../common/wxis_llamar.php");
$ix=-1;
foreach($contenido as $linea) {
	//echo "$linea<br>";
	$ix=$ix+1;
	if ($ix>0) {
		if (trim($linea)!=""){
	   		$a=explode(":",$linea);
	   		if (isset($a[1])) $tag[$a[0]]=$a[1];
	  	}
	}
}
$cantafter=(int) $tag["MAXMFN"];
$cantadd=$cantafter-$cantbefore;
echo '<br /><span style="color: blue"><b>'.$cantadd.' records were created</b></span>';
@ unlink($db_path."wrk/lo_create.prc");
@ unlink($db_path."wrk/lo_change.prc");
@ unlink($db_path."wrk/lo_mod.prc");
@ unlink($db_path."wrk/lo_modf.prc");
@ unlink($db_path."wrk/lo_check.pft");
@ unlink($db_path.$base_ant."/data/".$base_ant."temp.mst");
@ unlink($db_path.$base_ant."/data/".$base_ant."temp.xrf");
@ unlink($db_path.$base_ant."/data/".$base_ant."new.mst");
@ unlink($db_path.$base_ant."/data/".$base_ant."new.xrf");
}//if ($_POST["submit"])
?>
</div>
<?
include("../common/footer.php");
?>
