<?php

session_start();
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
			<div class=\"breadcrumb\">".$msgstr["addCPfromDB_mx"].": " . $base_ant."
			</div>
			<div class=\"actions\">";
if (isset($arrHttp["encabezado"])){
echo "<a href=\"menu_mantenimiento.php?base=".$base_ant."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_addcopiesdatabase.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_addcopiesdatabase.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: addcopiesdatabase.php</font>";
?>
<script language="javascript">
function AlterEntry(opcion)
{
value=document.form1.agregar.value;

//Main Library
if (value=="ml")
if (opcion==1)
{
if (document.getElementById("ml").style.display=='none')
{
document.getElementById("ml").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Main Library Field&nbsp;<input name="mlf" type="text" id="mlf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="mlsf" type="text" id="mlsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table>';
document.getElementById("ml").style.display='block';
}
}
else
{
document.getElementById("ml").innerHTML='';
document.getElementById("ml").style.display='none';
}
//Branch Library
if (value=="bl")
if (opcion==1)
{
if (document.getElementById("bl").style.display=='none')
{
document.getElementById("bl").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Branch Library Field&nbsp;<input name="blf" type="text" id="blf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="blsf" type="text" id="blsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table>';
document.getElementById("bl").style.display='block';
}
}
else
{
document.getElementById("bl").innerHTML='';
document.getElementById("bl").style.display='none';
}
//Tome
if (value=="tome")
if (opcion==1)
{
if (document.getElementById("tome").style.display=='none')
{
document.getElementById("tome").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Tome Field&nbsp;<input name="tomef" type="text" id="tomef" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="tomesf" type="text" id="tomesf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="right">&nbsp;</td></tr></table>';
document.getElementById("tome").style.display='block';
}
}
else
{
document.getElementById("tome").innerHTML='';
document.getElementById("tome").style.display='none';
}
//Volume
if (value=="volume")
if (opcion==1)
{
if (document.getElementById("volume").style.display=='none')
{
document.getElementById("volume").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Volume/Part Field&nbsp;<input name="volumef" type="text" id="volumef" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="volumesf" type="text" id="volumesf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="right">&nbsp;</td></tr></table>';
document.getElementById("volume").style.display='block';
}
}
else
{
document.getElementById("volume").innerHTML='';
document.getElementById("volume").style.display='none';
}
//Copy Number
if (value=="cpnum")
if (opcion==1)
{
if (document.getElementById("cpnum").style.display=='none')
{
document.getElementById("cpnum").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Copy Number Field&nbsp;<input name="cpnumf" type="text" id="cpnumf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="cpnumsf" type="text" id="cpnumsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="right">&nbsp;</td></tr></table>';
document.getElementById("cpnum").style.display='block';
}
}
else
{
document.getElementById("cpnum").innerHTML='';
document.getElementById("cpnum").style.display='none';
}
//Acquisition
if (value=="ad")
if (opcion==1)
{
if (document.getElementById("ad").style.display=='none')
{
document.getElementById("ad").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Acquisition Field&nbsp;<input name="adf" type="text" id="adf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="adsf" type="text" id="adsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("ad").style.display='block';
}
}
else
{
document.getElementById("ad").innerHTML='';
document.getElementById("ad").style.display='none';
}
//Provider
if (value=="provider")
if (opcion==1)
{
if (document.getElementById("provider").style.display=='none')
{
document.getElementById("provider").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Provider Field&nbsp;<input name="providerf" type="text" id="providerf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="providersf" type="text" id="providersf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("provider").style.display='block';
}
}
else
{
document.getElementById("provider").innerHTML='';
document.getElementById("provider").style.display='none';
}
//Date of arraival
if (value=="date")
if (opcion==1)
{
if (document.getElementById("date").style.display=='none')
{
document.getElementById("date").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Date of arraival Field&nbsp;<input name="datef" type="text" id="datef" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="datesf" type="text" id="datesf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table>';
document.getElementById("date").style.display='block';
}
}
else
{
document.getElementById("date").innerHTML='';
document.getElementById("date").style.display='none';
}
//Price
if (value=="price")
if (opcion==1)
{
if (document.getElementById("price").style.display=='none')
{
document.getElementById("price").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Price Field&nbsp;<input name="pricef" type="text" id="pricef" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="pricesf" type="text" id="pricesf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("price").style.display='block';
}
}
else
{
document.getElementById("price").innerHTML='';
document.getElementById("price").style.display='none';
}
//Purchase order
if (value=="po")
if (opcion==1)
{
if (document.getElementById("po").style.display=='none')
{
document.getElementById("po").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Purchase order Field&nbsp;<input name="pof" type="text" id="pof" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="posf" type="text" id="posf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("po").style.display='block';
}
}
else
{
document.getElementById("po").innerHTML='';
document.getElementById("po").style.display='none';
}
//Suggestion number
if (value=="sn")
if (opcion==1)
{
if (document.getElementById("sn").style.display=='none')
{
document.getElementById("sn").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Suggestion number Field&nbsp;<input name="snf" type="text" id="snf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="snsf" type="text" id="snsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("sn").style.display='block';
}
}
else
{
document.getElementById("sn").innerHTML='';
document.getElementById("sn").style.display='none';
}
//Conditions
if (value=="cond")
if (opcion==1)
{
if (document.getElementById("cond").style.display=='none')
{
document.getElementById("cond").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>Conditions Field&nbsp;<input name="condf" type="text" id="condf" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="condsf" type="text" id="condsf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td>&nbsp;</td></tr></table>';
document.getElementById("cond").style.display='block';
}
}
else
{
document.getElementById("cond").innerHTML='';
document.getElementById("cond").style.display='none';
}
//In exchange of
if (value=="exchange")
if (opcion==1)
{
if (document.getElementById("exchange").style.display=='none')
{
document.getElementById("exchange").innerHTML='<table width="750" border="0"><tr><td width="202" align="right"><label>In exchange of Field&nbsp;<input name="exchangef" type="text" id="exchangef" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="exchangesf" type="text" id="exchangesf" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="right">&nbsp;</td></tr></table>';
document.getElementById("exchange").style.display='block';
}
}
else
{
document.getElementById("exchange").innerHTML='';
document.getElementById("exchange").style.display='none';
}
}
function ComprobarNum(origin)
{
numero=document.getElementById(origin).value;
if (isNaN(numero)==true)
	{
		alert("Please check the number in the field: "+origin);
		if (origin=='from') document.form1.from.focus();
		else document.form1.to.focus();
		return;
	}
}
function ChangeOption(option)
{
if (option==1)
{
document.getElementById("systype").style.display="block";
document.getElementById("fieldsel").style.display="none";
}
else
{
document.getElementById("systype").style.display="none";
document.getElementById("fieldsel").style.display="block";
document.form1.typef.focus();
}
}
</script>
</div>
<div class="middle form">
	<div class="formContent">
<form action="" method="post" name="form1" target="_self" id="form1" onsubmit="OpenWindows();">
<?php
echo "<p>".$msgstr["addcopiesdatabase"]."</p>";
  echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";
  echo "<h3>".$msgstr["database"]." ".$base_ant."<p>";
  ?>
  <table width="750" border="0">
  <tr>
    <td width="202" align="right"> <label>From
   <input type="text" name="from" id="from" onchange="ComprobarNum('from')"/>
  </label>  </td>
    <td width="22">&nbsp;</td>
    <td width="187" align="left">  <label>To
  <input type="text" name="to" id="to" onchange="ComprobarNum('to')"/>
  </label></td>
    <td width="200" align="left">    <label>
	<script language="javascript">//estableciendo el foco en el 2do textbox
   document.form1.from.value="1";
  document.form1.to.focus();
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
    Last MFN=
<?php
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
$total=(int) $tag["MAXMFN"];
echo '<script language="javascript">
   document.form1.to.value="'.$total.'";
   </script>';
echo $total;
  ?>
  </label></td>
   <td width="121" align="right">&nbsp;</td>
  </tr>
    <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
	<td align="left">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td align="right"><label>Control Number Field
  <input name="cnf" type="text" id="cnf" value="<?php if ($_POST["cnf"]!="") echo $_POST["cnf"]; else echo "v1";?>" size="5"/>
  </label></td>
    <td align="center">-</td>
    <td align="left"><label>SubField
  <input name="cnsf" type="text" id="cnsf" value="<?php if ($_POST["cnsf"]!="") echo $_POST["cnsf"];?>" size="5"/>
  </label></td>
    <td align="left"><select name=agregar id=atunique onChange=AlterEntry(1) style=width:165px>
	<option value=''>add</option>
	<option value="ml">Main Library</option>
	<option value="bl">Branch Library</option>
	<option value="tome">Tome</option>
	<option value="volume">Volume/Part</option>
	<option value="cpnum">Copy Number</option>
	<option value="ad">Acquisition type</option>
	<option value="provider">Provider/Donnor/Institution</option>
	<option value="date">Date of arraival</option>
	<option value="price">Price</option>
	<option value="po">Purchase order</option>
	<option value="sn">Suggestion number</option>
	<option value="cond">Conditions</option>
	<option value="exchange">In exchange of</option>
	</select>&nbsp;<a href=javascript:AlterEntry(0)><img src=../dataentry/img/delete_occ.gif border=0 ></a>
	</td>
	<td align="left"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
	<td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><label>Inventory Number Field
  <input name="inf" type="text" id="inf" value="<?php if ($_POST["inf"]!="") echo $_POST["inf"];?>" size="5"/>
  </label></td>
    <td align="center">-</td>
    <td align="left"><label>SubField
  <input name="insf" type="text" id="insf" value="<?php if ($_POST["insf"]!="") echo $_POST["insf"];?>" size="5"/>
  </label></td>
    <td align="left"></td>
	<td align="left">&nbsp;</td>
  </tr>
    </tr>
    <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
	<td align="left">&nbsp;</td>
  </tr>
</table>
<?php
if ($_POST["mlf"]!="")
echo '<div id="ml" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Main Library Field&nbsp;<input name="mlf" type="text" id="mlf" value="'.$_POST["mlf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="mlsf" type="text" id="mlsf" value="'.$_POST["mlsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="ml" style="display:none"></div>';

if ($_POST["blf"]!="")
echo '<div id="bl" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Branch Library Field&nbsp;<input name="blf" type="text" id="blf" value="'.$_POST["blf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="blsf" type="text" id="blsf" value="'.$_POST["blsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="bl" style="display:none"></div>';

if ($_POST["tomef"]!="")
echo '<div id="tome" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Tome Field&nbsp;<input name="tomef" type="text" id="tomef" value="'.$_POST["tomef"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="tomesf" type="text" id="tomesf" value="'.$_POST["tomesf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="tome" style="display:none"></div>';

if ($_POST["volumef"]!="")
echo '<div id="volume" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Volume Field&nbsp;<input name="volumef" type="text" id="volumef" value="'.$_POST["volumef"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="volumesf" type="text" id="volumesf" value="'.$_POST["volumesf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="volume" style="display:none"></div>';

if ($_POST["cpnumf"]!="")
echo '<div id="cpnum" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Copy Number Field&nbsp;<input name="cpnumf" type="text" id="cpnumf" value="'.$_POST["cpnumf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="cpnumsf" type="text" id="cpnumsf" value="'.$_POST["cpnumsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="cpnum" style="display:none"></div>';

if ($_POST["adf"]!="")
echo '<div id="ad" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Acquisition Field&nbsp;<input name="adf" type="text" id="adf" value="'.$_POST["adf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="adsf" type="text" id="adsf" value="'.$_POST["adsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="ad" style="display:none"></div>';

if ($_POST["providerf"]!="")
echo '<div id="provider" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Provider Field&nbsp;<input name="providerf" type="text" id="providerf" value="'.$_POST["providerf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="providersf" type="text" id="providersf" value="'.$_POST["providersf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="provider" style="display:none"></div>';

if ($_POST["datef"]!="")
echo '<div id="date" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Date Field&nbsp;<input name="datef" type="text" id="datef" value="'.$_POST["datef"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="datesf" type="text" id="datesf" value="'.$_POST["datesf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="date" style="display:none"></div>';

if ($_POST["pricef"]!="")
echo '<div id="price" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Price Field&nbsp;<input name="pricef" type="text" id="pricef" value="'.$_POST["pricef"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="pricesf" type="text" id="pricesf" value="'.$_POST["pricesf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="price" style="display:none"></div>';

if ($_POST["pof"]!="")
echo '<div id="po" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Purchase order Field&nbsp;<input name="pof" type="text" id="pof" value="'.$_POST["pof"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="posf" type="text" id="posf" value="'.$_POST["posf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="po" style="display:none"></div>';

if ($_POST["snf"]!="")
echo '<div id="sn" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Suggestion number Field&nbsp;<input name="snf" type="text" id="snf" value="'.$_POST["snf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="snsf" type="text" id="snsf" value="'.$_POST["snsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="sn" style="display:none"></div>';

if ($_POST["condf"]!="")
echo '<div id="cond" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>Conditions Field&nbsp;<input name="condf" type="text" id="condf" value="'.$_POST["condf"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="condsf" type="text" id="condsf" value="'.$_POST["condsf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="cond" style="display:none"></div>';

if ($_POST["exchangef"]!="")
echo '<div id="exchange" style="display:block"><table width="750" border="0"><tr><td width="202" align="right"><label>In exchange of Field&nbsp;<input name="exchangef" type="text" id="exchangef" value="'.$_POST["exchangef"].'" size="5"/></label></td><td width="22" align="center">-</td><td width="187"align="left"><label>SubField&nbsp;<input name="exchangesf" type="text" id="exchangesf" value="'.$_POST["exchangesf"].'" size="5"/></label></td><td width="121" align="left"></td><td width="200" align="left">&nbsp;</td></tr></tr><tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr></table></div>';
else
echo '<div id="exchange" style="display:none"></div>';
?>
<table width="750" border="0">
<tr>
<td width="202" align="right"><label>Use the system types
      <input name="radiobutton" type="radio" value="systype" <?php if ($_POST["radiobutton"]=="systype") echo 'checked="checked"'; else if (!$_POST["submit"]) echo 'checked="checked"'; ?> onchange="ChangeOption(1)"/>
      </label></td>
<td width="22" align="center">&nbsp;</td>
<td width="187"align="left"><div id="systype" style="display:<?php if ($_POST["radiobutton"]=="systype") echo "block"; else if (!$_POST["submit"]) echo "block"; else echo "none"; ?>">
	    <label>Type of object
<select name="type" id="type">
   <?php
	@ $fp = fopen($db_path."circulation/def/$lang/items.tab", "r");
 flock($fp, 1);
 if (!$fp)
   {
     echo "Unable to open file circulation/def/$lang/items.tab.</strong></p></body></html>";
     exit;
   }
while(!feof($fp))
{
 $order= fgets($fp, 100);
 $splitorder=explode("|",$order);
 if ($splitorder[0]!="" and $splitorder[1]!="") if ($_POST["type"]==$splitorder[0]) echo "<option value=\"$splitorder[0]\" selected=\"selected\" > $splitorder[1]</option>"; else echo "<option value=\"$splitorder[0]\" > $splitorder[1]</option>";
}
 flock($fp, 3);
  fclose($fp);
   ?>
    </select>
    </label>
	</div></td>
<td width="121" align="left"></td>
<td width="200" align="left">&nbsp;</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td>&nbsp;</td>
<td align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>
<tr>
<td align="right"><label>Use a field-subfield combination
      <input name="radiobutton" type="radio" value="fieldsel" <?php if ($_POST["radiobutton"]=="fieldsel") echo 'checked="checked"'; ?> onchange="ChangeOption(2)"/>
      </label></td>
<td>&nbsp;</td>
    <td colspan="3" align="left"><div id="fieldsel" style="display:<?php if ($_POST["radiobutton"]=="fieldsel") echo "block"; else echo "none"; ?>">
      <table width="280px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="40%" scope="col"><label>Type Field
  <input name="typef" type="text" id="typef" value="<?php if ($_POST["typef"]!="") echo $_POST["typef"];?>" size="5"/>
  </label></th>
          <th width="20%" scope="col" align="center">-</th>
          <th width="40%" scope="col"><label>SubField
  <input name="typesf" type="text" id="typesf" value="<?php if ($_POST["typesf"]!="") echo $_POST["typesf"];?>" size="5"/>
  </label></th>
        </tr>
      </table>
    </div></td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td>&nbsp;</td>
<td align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>

</table>


<table width="750px" border="0">
  <tr>
     <td width="22">&nbsp;</td>
    <td><?php
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
if (($field!="") && ($field[0]!=='v')) return 'v'.$field;
return $field;
}
function RemovePico($field)
{
$field=trim($field);
if ($field[0]=='^') return str_replace( '^','',$field);
return $field;
}
if ($_POST["submit"])
{
$from=$_POST['from'];
$to=$_POST['to'];
if (!is_numeric($from) or !is_numeric($to))
{
echo '<br /><span style="color:red"><b>The fields "from" or "to" had non numeric values</b></span>';
}
else
{
//Getting the fields information
$cnf=Vfield(strtolower($_POST['cnf']));
$inf=Vfield(strtolower($_POST['inf']));
$mlf=Vfield(strtolower($_POST['mlf']));
$blf=Vfield(strtolower($_POST['blf']));
$tomef=Vfield(strtolower($_POST['tomef']));
$volumef=Vfield(strtolower($_POST['volumef']));
$cpnumf=Vfield(strtolower($_POST['cpnumf']));
$adf=Vfield(strtolower($_POST['adf']));
$providerf=Vfield(strtolower($_POST['providerf']));
$datef=Vfield(strtolower($_POST['datef']));
$pricef=Vfield(strtolower($_POST['pricef']));
$pof=Vfield(strtolower($_POST['pof']));
$snf=Vfield(strtolower($_POST['snf']));
$condf=Vfield(strtolower($_POST['condf']));
$exchangef=Vfield(strtolower($_POST['exchangef']));
//Getting the subfields information
$cnsf=RemovePico(strtolower($_POST['cnsf']));
$insf=RemovePico(strtolower($_POST['insf']));
$mlsf=RemovePico(strtolower($_POST['mlsf']));
$blsf=RemovePico(strtolower($_POST['blsf']));
$tomesf=RemovePico(strtolower($_POST['tomesf']));
$volumesf=RemovePico(strtolower($_POST['volumesf']));
$cpnumsf=RemovePico(strtolower($_POST['cpnumsf']));
$adsf=RemovePico(strtolower($_POST['adsf']));
$providersf=RemovePico(strtolower($_POST['providersf']));
$datesf=RemovePico(strtolower($_POST['datesf']));
$pricesf=RemovePico(strtolower($_POST['pricesf']));
$posf=RemovePico(strtolower($_POST['posf']));
$snsf=RemovePico(strtolower($_POST['snsf']));
$condsf=RemovePico(strtolower($_POST['condsf']));
$exchangesf=RemovePico(strtolower($_POST['exchangesf']));
//Concatenating the fields and subfields
$cnfent="";
$infent="";
$mlfent="";
$blfent="";
$tomefent="";
$volumefent="";
$cpnumfent="";
$adfent="";
$providerfent="";
$datefent="";
$pricefent="";
$pofent="";
$snfent="";
$condfent="";
$exchangefent="";
if ($cnsf=="") $cnfent=$cnf; else $cnfent=$cnf."^".$cnsf;
if ($insf=="") $infent=$inf; else $infent=$inf."^".$insf;
if ($mlsf=="") $mlfent=$mlf; else $mlfent=$mlf."^".$mlsf;
if ($blsf=="") $blfent=$blf; else $blfent=$blf."^".$blsf;
if ($tomesf=="") $tomefent=$tomef; else $tomefent=$tomef."^".$tomesf;
if ($volumesf=="") $volumefent=$volumef; else $volumefent=$volumef."^".$volumesf;
if ($cpnumsf=="") $cpnumfent=$cpnumf; else $cpnumfent=$cpnumf."^".$cpnumsf;
if ($adsf=="") $adfent=$adf; else $adfent=$adf."^".$adsf;
if ($providersf=="") $providerfent=$providerf; else $providerfent=$providerf."^".$providersf;
if ($datesf=="") $datefent=$datef; else $datefent=$datef."^".$datesf;
if ($pricesf=="") $pricefent=$pricef; else $pricefent=$pricef."^".$pricesf;
if ($posf=="") $pofent=$pof; else $pofent=$pof."^".$posf;
if ($snsf=="") $snfent=$snf; else $snfent=$snf."^".$snsf;
if ($condsf=="") $condfent=$condf; else $condfent=$condf."^".$condsf;
if ($exchangesf=="") $exchangefent=$exchangef; else $exchangefent=$exchangef."^".$exchangesf;
$IsisScript=$xWxis."administrar.xis";
$query = "&base=copies&cipar=$db_path"."par/copies.par&Opcion=status";
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
$cantcopiersbefore=(int) $tag["MAXMFN"];
$IsisScript=$xWxis."administrar.xis";
$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Opcion=status";
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
$cantloabobjectsbefore=(int) $tag["MAXMFN"];
//Copies Work----------------------------------------------------------------------
// SE LEE LA TABLA DE STATUS DE LAS COPIAS
$mysentstatus="^a1^bIn process in technical office";
$mystatcopy="^a2^bSent to loanobjects";
$tab_st=$db_path."copies/def/".$_SESSION["lang"]."/status_copy.tab";
if (!file_exists($tab_st))
	$tab_st=$db_path."copies/def/".$lang_db."/status_copy.tab";
if (file_exists($tab_st)){
$fp=file($tab_st);
foreach ($fp as $value){
	$value=trim($value);
	if ($value!=""){
		$v=explode("|",$value);
		$status["^a".$v[0]."^b".$v[1]]="(".$v[0].") ".$v[1];
		if ($v[0]==1) $mysentstatus="^a".$v[0]."^b".$v[1];
		if ($v[0]==2) $mystatcopy="^a".$v[0]."^b".$v[1];
	}

}
}
@ $fp = fopen($db_path."wrk/cp_create.pft", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."/wrk/cp_create.pft";
   exit;
 }
$savestring="mpl,
(if p(".$infent.") then \n";
if ($cnf!=$inf) $savestring.=$cnfent."[1],'|',\n";
else $savestring.=$cnfent.",'|',\n";
$savestring.="'".$base_ant."|',
".$infent.",'|',
'".$mystatcopy."|',\n";

if ($mlfent!="")
{
 if ($mlf!=$inf) $savestring.=$mlfent."[1],'|',\n";
 else $savestring.=$mlfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($blfent!="")
{
 if ($blf!=$inf) $savestring.=$blfent."[1],'|',\n";
 else $savestring.=$blfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($tomefent!="")
{
 if ($tomef!=$inf) $savestring.=$tomefent."[1],'|',\n";
 else $savestring.=$tomefent.",'|',\n";
}
else $savestring.="'|',\n";

if ($volumefent!="")
{
 if ($volumef!=$inf) $savestring.=$volumefent."[1],'|',\n";
 else $savestring.=$volumefent.",'|',\n";
}
else $savestring.="'|',\n";

if ($cpnumfent!="")
{
 if ($cpnumf!=$inf) $savestring.=$cpnumfent."[1],'|',\n";
 else $savestring.=$cpnumfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($adfent!="")
{
 if ($adf!=$inf) $savestring.=$adfent."[1],'|',\n";
 else $savestring.=$adfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($providerfent!="")
{
 if ($providerf!=$inf) $savestring.=$providerfent."[1],'|',\n";
 else $savestring.=$providerfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($datefent!="")
{
 if ($datef!=$inf) $savestring.=$datefent."[1],'|',\n";
 else $savestring.=$datefent.",'|',\n";
}
else $savestring.="'|',\n";

if ($pricefent!="")
{
 if ($pricef!=$inf) $savestring.=$pricefent."[1],'|',\n";
 else $savestring.=$pricefent.",'|',\n";
}
else $savestring.="'|',\n";

if ($pofent!="")
{
 if ($pof!=$inf) $savestring.=$pofent."[1],'|',\n";
 else $savestring.=$pofent.",'|',\n";
}
else $savestring.="'|',\n";

if ($snfent!="")
{
 if ($snf!=$inf) $savestring.=$snfent."[1],'|',\n";
 else $savestring.=$snfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($condfent!="")
{
 if ($condf!=$inf) $savestring.=$condfent."[1],'|',\n";
 else $savestring.=$condfent.",'|',\n";
}
else $savestring.="'|',\n";

if ($exchangefent!="")
{
 if ($exchangef!=$inf) $savestring.=$exchangefent."[1],'|',\n";
 else $savestring.=$exchangefent.",'|',\n";
}
else $savestring.="'|',\n";


$savestring.="/ fi)\n";

fwrite($fp,$savestring);
fclose($fp);
@ $fp = fopen($db_path."wrk/cp_create.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."/wrk/cp_create.prc";
   exit;
 }
$savestring="'d*',
'<1>'v1'</1>',
'<10>'v2'</10>',
'<30>'v3'</30>',
'<200>'v4'</200>',
'<35>'v5'</35>',
'<40>'v6'</40>',
'<50>'v7'</50>',
'<60>'v8'</60>',
'<63>'v9'</63>',
'<68>'v10'</68>',
'<70>'v11'</70>',
'<80>'v12'</80>',
'<90>'v13'</90>',
'<100>'v14'</100>',
'<110>'v15'</110>',
'<300>'v16'</300>',
'<400>'v17'</400>',
";
fwrite($fp,$savestring);
fclose($fp);

$mx=$converter_path." $db_path".$base_ant."/data/".$base_ant." pft=@".$db_path."wrk/cp_create.pft from=$from to=$to lw=600 now -all >".$db_path."wrk/copies.lst";
exec($mx,$outmx,$banderamx);
$mx1=$converter_path." seq=".$db_path."wrk/copies.lst proc=@".$db_path."wrk/cp_create.prc append=".$db_path."copies/data/copies now -all";
exec($mx1,$outmx1,$banderamx1);
$mxinv=$converter_path." ".$db_path."copies/data/copies fst=@".$db_path."copies/data/copies.fst fullinv=".$db_path."copies/data/copies now -all";
exec($mxinv, $outputmxinv,$banderamxinv);
//End of Copies Work----------------------------------------------------------------------
//Loanobjects Work----------------------------------------------------------------------
@ $fp = fopen($db_path."wrk/lo_create.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/lo_create.prc";
   exit;
 }
$savestring="'d*',
if p(v3330) then
'<1>',v1,'</1>',
'<10>',v3310[1],'</10>',
('<959>',
'^i'v3330,
'^l'v3335,
'^b'v3340,\n";
if ($_POST["radiobutton"]=="systype") $savestring.="'^o".$_POST['type']."',\n";
else $savestring.="'^o'".Vfield(strtolower($_POST['typef']))."^".RemovePico(strtolower($_POST['typesf'])).",\n";
$savestring.="'</959>',),
fi,
";
fwrite($fp,$savestring);
fclose($fp);
$mx=$converter_path." $db_path".$base_ant."/data/".$base_ant." \"join=".$db_path."copies/data/copies,3330:30,3335:35,3320:200,3340:40,3310:10=mpu,'CN_".$base_ant."_'$cnfent\" \"proc=@".$db_path."wrk/lo_create.prc\" append=".$db_path."loanobjects/data/loanobjects ";
if ($inf!="") $mx.="from=$from to=$to ";
$mx.="now -all";
exec($mx,$outmx,$banderamx);
$mxinv=$converter_path." ".$db_path."loanobjects/data/loanobjects fst=@".$db_path."loanobjects/data/loanobjects.fst fullinv=".$db_path."loanobjects/data/loanobjects now -all";
exec($mxinv, $outputmxinv,$banderamxinv);
//Update the copy status if necessary
if ($inf=="")
{
@ $fp = fopen($db_path."wrk/cp_change.prc", "w");
if (!$fp)
 {
   echo "Unable to write the file ".$db_path."wrk/cp_change.prc";
   exit;
 }
$savestring="if v10='".$base_ant."' then if v200^a='1' then 'd200', '<200>".$mystatcopy."</200>',fi,fi,";
fwrite($fp,$savestring);
fclose($fp);
$mxchcopies=$converter_path." ".$db_path."copies/data/copies \"proc=@".$db_path."wrk/cp_change.prc\" copy=".$db_path."copies/data/copies now -all";
exec($mxchcopies, $outputchcopie,$banderamxchcopie);
}

//End of Loanobjects Work----------------------------------------------------------------------
$IsisScript=$xWxis."administrar.xis";
$query = "&base=copies&cipar=$db_path"."par/copies.par&Opcion=status";
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
$cantcopiersafter=(int) $tag["MAXMFN"];
$cantadd=$cantcopiersafter-$cantcopiersbefore;
echo '<br /><span style="color: blue"><b>&nbsp;&nbsp;'.$cantadd.' copies added from the database records</b></span>';
$IsisScript=$xWxis."administrar.xis";
$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Opcion=status";
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
$cantloabobjectsafter=(int) $tag["MAXMFN"];
$cantadd=$cantloabobjectsafter-$cantloabobjectsbefore;
echo '<br /><span style="color: blue"><b>&nbsp;&nbsp;'.$cantadd.' loanobjects records were created</b></span>';
@ unlink($db_path."/wrk/copies.lst");
@ unlink($db_path."/wrk/cp_create.pft");
@ unlink($db_path."/wrk/cp_create.prc");
@ unlink($db_path."wrk/lo_create.prc");
@ unlink($db_path."wrk/cp_change.prc");
//Link the base to the copies database
	$fp=file($db_path."bases.dat");
	$new=fopen($db_path."bases.dat","w");
	foreach ($fp as $value){
		$value=trim($value);
		$val=explode('|',$value);
		if (trim($val[0])==trim($arrHttp["base"])){
			$value=$val[0].'|'.$val[1]."|".'Y';
		}
		fwrite($new,$value."\n");
	}
	fclose($new);
    echo '<br /><span style="color: blue"><b>&nbsp;&nbsp;The '.$base_ant.' database was linked to the copies database.</b></span>';
}
}//if ($_POST["submit"])
?>
</div>
<?
include("../common/footer.php");
?>