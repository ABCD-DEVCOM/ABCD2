<?php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<HTML>
<HEAD>
<?php
$db_path="/var/opt/ABCD/bases/";
if (!file_exists($db_path."abcd.def")){
	echo "Missing  abcd.def in the database folder"; die;
}
$def = parse_ini_file($db_path."abcd.def");
$cisis_ver=$def[$base];

if (isset($cisis_ver)) $cisis_ver=$cisis_ver.'/';
//echo 'cisis_Ver=' . $cisis_ver . '<BR>';
$hdr = "Location: /cgi-bin/". $cisis_ver . "wxis/iah/scripts/?IsisScript=iah.xis&lang=" . $lang . "&base=" . $base;
//echo 'header=' . $hdr . "<BR>";
header($hdr);
?>


	<script language="JavaScript" src="../action.js"></script>
    <TITLE>ABCD iAH - Search Interface</TITLE>
	<script language="JavaScript">
		function startIAH(base){
            var aux="/cgi-bin/". $cisis_ver . "wxis/iah/scripts/?IsisScript=iah.xis&lang=en&base=" + base;
			this.location=aux;
		}
	</script>
	<style>
		BODY, TD{
			font-family: verdana;
			font-size: 70%;
		}
	</style>
</HEAD>

  <BODY BGCOLOR="#eoebeb" link="green" vlink="green">

   	<div align="right">
		[ <a href="../pt/index.htm">português</a> | <a href="../es/index.htm">español</a> | english ]
	</div>

    <TABLE WIDTH="550" HEIGHT="410" BORDER="0" ALIGN="center" cellspacing="8">
      <TR>
        <TD VALIGN="top" colspan="2" align="center">
			<img src="image/head2.gif">
			<P align="center"><b>Select the Database</b></P>
		</TD>
	  </TR>
	  <TR>
	    <TD VALIGN="top">
			<a href="javascript:startIAH('MARC')">MARC21</a>
		</TD>
		<TD VALIGN="top" align="justify">
			MARC21 library catalogue
		</TD>
	  </TR>
	  <TR>
	    <TD VALIGN="top">
			<a href="javascript:startIAH('DUBCORE')">DublinCore</a>
		</TD>
		<TD VALIGN="top" align="justify">
			Example Dublin Core repository database with full-text
		</TD>
	  </TR>
  	  <TR>
		<TD valign="bottom" align="center" colspan="2">
			<P><hr>Search engine: <a href="http://productos.bvsalud.org/product.php?id=iah&lang=en">iAH</a> by BIREME/PAHO/WHO<br>
			<a href="http://productos.bvsalud.org/product.php?id=wwwisis&lang=pt"><img src="image/powered.gif" border="0" alt="WWWISIS 4.0"></a>
		</TD>
	  </TR>

	</TABLE>

  </BODY>
</HTML>
